<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // FREE: halaman public
    public function __construct()
    {
        // user yang sudah login cuma boleh akses logout dan google callback
        $this->middleware('guest')->except(['logout', 'googleCallback']);
    }

    // ======================
    //  LOGIN VIEW
    // ======================

    public function showLogin()
    {
        return view('auth.login');
    }

    // REGISTER VIEW
    public function registerAdmin()
    {
        return view('auth.register-admin');
    }

    public function registerUser()
    {
        return view('auth.register-user');
    }

    // ======================
    //  PROCESS REGISTER
    // ======================

    public function handleRegister(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:7|confirmed',
            'role'      => 'sometimes|in:admin,user', // Optional, default to 'user'
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'role'      => $validated['role'] ?? 'user',  // default to user
            'password'  => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    // ======================
    //  PROCESS LOGIN
    // ======================

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // redirect by role
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // user/member ke membership
            return redirect()->route('membership.landing');
        }

        return back()->withErrors([
            'login_error' => 'Email atau password salah!',
        ])->withInput();
    }

    // ======================
    //  FORGOT PASSWORD + OTP
    // ======================

    // step 1: kirim OTP (sementara disimpan di session)
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ]);
        }

        // generate OTP 6 digit
        $otp = rand(100000, 999999);

        // simpan di session (simple dulu)
        session([
            'reset_email' => $user->email,
            'reset_otp'   => $otp,
        ]);

        // NOTE: di sini nanti bisa ditambah logic kirim email beneran
        // logger('OTP reset password: '.$otp);

        // 👉 SETELAH FORGOT → KE HALAMAN RESET PASSWORD (KIRI)
        return redirect()
            ->route('password.reset.form')
            ->with('status', 'Silakan buat password baru.');
    }

    // step 2: update password (setelah isi form reset password – KIRI)
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('reset_email');

        if (! $email) {
            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Session reset password tidak ditemukan.']);
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        // 👉 habis ganti password, lanjut ke halaman VERIFY OTP (KANAN)
        return redirect()
            ->route('password.otp.form')
            ->with('status', 'Password berhasil direset. Silakan verifikasi OTP.');
    }

    // step 3: verifikasi OTP (halaman kanan)
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp'   => 'required|array|size:6',
            'otp.*' => 'required|digits:1',
        ]);

        $inputOtp   = implode('', $request->otp);
        $sessionOtp = session('reset_otp');

        if ($inputOtp !== $sessionOtp) {
            return back()->withErrors([
                'otp' => 'Kode OTP salah.',
            ]);
        }

        // OTP benar → beresin session
        session()->forget(['reset_otp']);

        // selesai semua, balik ke login admin
        return redirect()
            ->route('login.admin')
            ->with('status', 'Akun berhasil diverifikasi. Silakan login.');
    }

    // ======================
    //  LOGOUT
    // ======================

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    // ======================
    //  GOOGLE OAUTH
    // ======================

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // Update Google ID and avatar if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => 'user',
                    'password' => null, // No password for Google users
                ]);
            }
            
            // Login the user
            Auth::login($user);
            
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('membership.landing');
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['google_error' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }
}
