<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('is_petugas')) {
            return redirect()->route('petugas.denda');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === 'petugaspiketxipplg1@gmail.com' && $password === 'piket11pplg1') {
            session(['is_petugas' => true]);
            return redirect()->route('petugas.denda');
        }

        return back()->withErrors(['error' => 'Email atau password salah!']);
    }

    public function logout(Request $request)
    {
        session()->forget('is_petugas');
        return redirect()->route('home');
    }
}