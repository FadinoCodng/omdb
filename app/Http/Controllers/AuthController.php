<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register()
    {
        return view('auth.register');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register_process(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ]
        ]);

        try {
            $response = $this->authService->register($validated);

            if (!$response) {
                return redirect()->back()->with('error', 'Registrasi gagal.');
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Throwable $th) {
            Log::error([
                'line'    => $th->getLine(),
                'file'    => $th->getFile(),
                'message' => $th->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Registrasi gagal: ' . $th->getMessage());
        }
    }

    public function login_process(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email', 
            ],
            'password' => [
                'required',
            ],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.exists'      => 'Email tidak terdaftar.',   
            'password.required' => 'Password wajib diisi.',
        ]);

        try {
            $response = $this->authService->login([
                'email'    => $request->email,
                'password' => $request->password,
            ]);

            if (!$response) {
                return redirect()->back()
                    ->with('error', 'Password atau email yang Anda masukkan salah.')
                    ->withInput();
            }

            $request->session()->regenerate();

            session(['logged_in' => true]);

            return redirect()->route('dashboard');

        } catch (\Throwable $th) {
            Log::error([
                'line'    => $th->getLine(),
                'file'    => $th->getFile(),
                'message' => $th->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Login gagal: ' . $th->getMessage())
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->forget('logged_in');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil keluar.');
    }
}