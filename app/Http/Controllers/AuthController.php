<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FREE: halaman public
    public function __construct()
    {
        // user yang sudah login cuma boleh akses logout
        $this->middleware('guest')->except(['logout']);
    }

    // ======================
    //  VIEW SELECTOR
    // ======================

    public function chooseRole()
    {
        return view('auth.choose-role');
    }

    // LOGIN VIEW
    public function loginAdmin()
    {
        return view('auth.login-admin');
    }

    public function loginUser()
    {
        return view('auth.login-user');
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
            'role'      => 'required|in:admin,user', // ROLE WAJIB DARI FORM
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'role'      => $validated['role'],  // role dari form
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
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/user');
            }

            // user biasa ke homepage (route '/')
            return redirect()->route('homepage');
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
}
