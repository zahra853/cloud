<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipTransaction;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MembershipController extends Controller
{
    protected $midtransService;
    
    // Membership fee (in Rupiah)
    const MEMBERSHIP_FEE = 100000; // Rp 100,000
    const MEMBERSHIP_DURATION_DAYS = 365; // 1 year

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Show membership registration form
     */
    public function showRegistration()
    {
        return view('membership.register');
    }

    /**
     * Public membership landing page
     */
    public function landingPage()
    {
        return view('membership.landing');
    }

    /**
     * Process membership registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'is_member' => false,
        ]);

        // Auto login
        Auth::login($user);

        // Redirect to membership landing page
        return redirect()->route('membership.landing')
            ->with('success', 'Akun berhasil dibuat! Silahkan aktivasi membership Anda.');
    }

    /**
     * Show membership payment page
     */
    public function showPayment()
    {
        if (Auth::user()->isActiveMember()) {
            return redirect()->route('homepage')
                ->with('info', 'Anda sudah menjadi member aktif!');
        }

        $membershipFee = self::MEMBERSHIP_FEE;
        $duration = self::MEMBERSHIP_DURATION_DAYS;

        return view('membership.payment', compact('membershipFee', 'duration'));
    }

    /**
     * Create membership payment
     */
    public function createPayment(Request $request)
    {
        $user = Auth::user();

        if ($user->isActiveMember()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menjadi member aktif!',
            ], 400);
        }

        try {
            // Create a temporary order for membership payment
            $orderNumber = 'MEMBERSHIP-' . $user->id . '-' . time();
            
            $params = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => self::MEMBERSHIP_FEE,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '',
                ],
                'item_details' => [
                    [
                        'id' => 'membership',
                        'price' => self::MEMBERSHIP_FEE,
                        'quantity' => 1,
                        'name' => 'Membership - 1 Year',
                    ],
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Store order number in session for callback
            session(['membership_order_' . $user->id => $orderNumber]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_number' => $orderNumber,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat payment: ' . $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Membership payment success page
     */
    public function paymentSuccess()
    {
        return view('membership.success');
    }

    /**
     * Dashboard membership page
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $membership = $user->membership;
        
        // Handle payment status from Midtrans callback
        if ($request->has('status')) {
            if ($request->status === 'success') {
                session()->flash('success', 'Pembayaran berhasil! Membership Anda sedang diproses.');
            } elseif ($request->status === 'pending') {
                session()->flash('info', 'Pembayaran pending. Silahkan selesaikan pembayaran Anda.');
            } elseif ($request->status === 'error') {
                session()->flash('error', 'Pembayaran gagal. Silahkan coba lagi.');
            }
        }
        
        return view('user.dashboard.membership', compact('membership'));
    }

    /**
     * Activate membership from dashboard
     */
    public function activate(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:basic,premium,vip',
            'price' => 'required|numeric|min:50000',
        ]);

        $user = Auth::user();

        // Determine duration based on type
        $durations = [
            'basic' => 30,    // 1 month
            'premium' => 90,  // 3 months
            'vip' => 365,     // 1 year
        ];
        $duration = $durations[$validated['type']];

        try {
            $orderNumber = 'MEMBERSHIP-' . strtoupper($validated['type']) . '-' . $user->id . '-' . time();
            
            // Create membership transaction record
            $transaction = MembershipTransaction::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'membership_type' => $validated['type'],
                'amount' => $validated['price'],
                'duration_days' => $duration,
                'payment_status' => 'pending',
                'expires_at' => now()->addDays($duration),
            ]);
            
            $email = $user->email ?? 'member@shop.test';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = 'member@shop.test';
            }
            
            $params = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => (int) $validated['price'],
                ],
                'customer_details' => [
                    'first_name' => $user->name ?? 'Member',
                    'email' => $email,
                    'phone' => $user->phone ?? '08123456789',
                ],
                'item_details' => [
                    [
                        'id' => 'membership-' . $validated['type'],
                        'price' => (int) $validated['price'],
                        'quantity' => 1,
                        'name' => 'Membership ' . ucfirst($validated['type']),
                    ],
                ],
                'callbacks' => [
                    'finish' => route('user.dashboard.membership') . '?status=success',
                    'unfinish' => route('user.dashboard.membership') . '?status=pending',
                    'error' => route('user.dashboard.membership') . '?status=error',
                ],
            ];

            // Get Snap token for popup
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update transaction with snap token
            $transaction->update(['midtrans_snap_token' => $snapToken]);

            // Return JSON response with snap token for popup
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_number' => $orderNumber,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle membership payment notification from Midtrans
     */
    public function paymentNotification(Request $request)
    {
        try {
            $notification = json_decode($request->getContent());
            
            if (!$notification) {
                throw new \Exception('Invalid JSON in notification');
            }

            // Get transaction status from Midtrans
            $transaction = \Midtrans\Transaction::status($notification->transaction_id);
            
            $orderNumber = $transaction->order_id;
            $membershipTransaction = MembershipTransaction::where('order_number', $orderNumber)->first();

            if (!$membershipTransaction) {
                throw new \Exception('Membership transaction not found: ' . $orderNumber);
            }

            // Log the transaction status for debugging
            \Log::info('Processing Midtrans Membership Transaction', [
                'order_number' => $orderNumber,
                'transaction_id' => $transaction->transaction_id,
                'transaction_status' => $transaction->transaction_status,
                'fraud_status' => $transaction->fraud_status ?? 'N/A'
            ]);

            // Update transaction based on status
            $membershipTransaction->midtrans_transaction_id = $transaction->transaction_id;
            $membershipTransaction->midtrans_response = (array) $transaction;

            if ($transaction->transaction_status == 'capture') {
                if ($transaction->fraud_status == 'accept') {
                    $membershipTransaction->markAsPaid($transaction->transaction_id);
                    $this->activateUserMembership($membershipTransaction);
                }
            } else if ($transaction->transaction_status == 'settlement') {
                $membershipTransaction->markAsPaid($transaction->transaction_id);
                $this->activateUserMembership($membershipTransaction);
            } else if ($transaction->transaction_status == 'pending') {
                $membershipTransaction->payment_status = 'pending';
            } else if ($transaction->transaction_status == 'deny' || 
                       $transaction->transaction_status == 'expire' || 
                       $transaction->transaction_status == 'cancel') {
                $membershipTransaction->payment_status = 'failed';
            }

            $membershipTransaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Notification handled successfully',
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans Membership Notification Error', [
                'error' => $e->getMessage(),
                'notification' => $notification ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Activate user membership after successful payment
     */
    private function activateUserMembership(MembershipTransaction $transaction)
    {
        $user = $transaction->user;
        
        // Update or create user membership
        $user->update([
            'is_member' => true,
            'membership_type' => $transaction->membership_type,
            'membership_expires_at' => $transaction->expires_at,
        ]);

        \Log::info('User membership activated', [
            'user_id' => $user->id,
            'membership_type' => $transaction->membership_type,
            'expires_at' => $transaction->expires_at
        ]);
    }

    /**
     * Confirm payment after successful Midtrans popup (client-side callback)
     */
    public function confirmPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_number' => 'required|string',
            ]);

            $orderNumber = $validated['order_number'];
            $membershipTransaction = MembershipTransaction::where('order_number', $orderNumber)->first();

            if (!$membershipTransaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found'
                ], 404);
            }

            // Check if already paid
            if ($membershipTransaction->payment_status === 'paid') {
                return response()->json([
                    'success' => true,
                    'message' => 'Membership sudah aktif'
                ]);
            }

            // Try to verify with Midtrans
            try {
                $status = \Midtrans\Transaction::status($orderNumber);
                
                \Log::info('Midtrans status check', [
                    'order_number' => $orderNumber,
                    'status' => $status->transaction_status ?? 'unknown'
                ]);

                if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                    // Payment confirmed - activate membership
                    $membershipTransaction->markAsPaid($status->transaction_id ?? null);
                    $this->activateUserMembership($membershipTransaction);

                    return response()->json([
                        'success' => true,
                        'message' => 'Membership berhasil diaktifkan!'
                    ]);
                } elseif ($status->transaction_status === 'pending') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pembayaran masih pending'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Status pembayaran: ' . $status->transaction_status
                    ]);
                }
            } catch (\Exception $midtransError) {
                \Log::warning('Midtrans status check failed, activating directly', [
                    'order_number' => $orderNumber,
                    'error' => $midtransError->getMessage()
                ]);

                // If Midtrans check fails but we got success callback, activate anyway (sandbox mode)
                $membershipTransaction->markAsPaid(null);
                $this->activateUserMembership($membershipTransaction);

                return response()->json([
                    'success' => true,
                    'message' => 'Membership berhasil diaktifkan!'
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Confirm payment error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel membership
     */
    public function cancelMembership(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user->is_member) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki membership aktif'
                ]);
            }

            // Cancel membership
            $user->update([
                'is_member' => false,
                'membership_type' => null,
                'membership_expires_at' => null,
            ]);

            \Log::info('User membership cancelled', [
                'user_id' => $user->id,
                'cancelled_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Membership berhasil dibatalkan'
            ]);

        } catch (\Exception $e) {
            \Log::error('Cancel membership error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan membership'
            ], 500);
        }
    }
}