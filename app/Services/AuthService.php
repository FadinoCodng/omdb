<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    // Proses registrasi
    public function register($data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        if ($user) {
            return true;
        }

        return false;
    }

    // Proses login
    public function login($data)
    {
        // Auth::attempt otomatis cek email + password + hash
        $attempt = Auth::attempt([
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        return $attempt;
    }
}