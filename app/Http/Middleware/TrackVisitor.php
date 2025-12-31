<?php

namespace App\Http\Middleware;

use App\Models\VisitorAnalytic;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for admin routes, API routes, assets, and Google callback
        if ($request->is('admin/*') || 
            $request->is('api/*') || 
            $request->is('_debugbar/*') ||
            $request->is('auth/google/callback') ||
            $request->isMethod('POST') ||
            str_contains($request->path(), '.')) {
            return $next($request);
        }

        try {
            $agent = new Agent();
            
            // Get device info
            $deviceType = 'desktop';
            if ($agent->isMobile()) {
                $deviceType = 'mobile';
            } elseif ($agent->isTablet()) {
                $deviceType = 'tablet';
            }

            // Track the visitor
            VisitorAnalytic::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'page_url' => $request->fullUrl(),
                'page_title' => $this->getPageTitle($request),
                'referrer' => $request->header('referer'),
                'device_type' => $deviceType,
                'browser' => $agent->browser(),
                'os' => $agent->platform(),
                'user_id' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't break the request
            logger('Visitor tracking error: ' . $e->getMessage());
        }

        return $next($request);
    }

    /**
     * Get page title based on route
     */
    private function getPageTitle(Request $request): string
    {
        $route = $request->route();
        if (!$route) return 'Unknown Page';

        $routeName = $route->getName();
        
        $titles = [
            'homepage' => 'Homepage',
            'location' => 'Location',
            'review' => 'Review',
            'menu' => 'Menu',
            'product' => 'Products',
            'product.detail' => 'Product Detail',
            'membership.landing' => 'Membership',
            'membership.register' => 'Membership Registration',
            'membership.payment' => 'Membership Payment',
            'login' => 'Login',
            'register' => 'Register',
        ];

        return $titles[$routeName] ?? ucfirst(str_replace('.', ' ', $routeName ?? 'Page'));
    }
}
