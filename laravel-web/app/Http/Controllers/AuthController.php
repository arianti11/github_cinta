<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login-form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
         $request->validate([
        'username' => 'required',
        'password' => 'required'
    ], [
        'username.required' => 'Username wajib diisi.',
        'password.required' => 'Password wajib diisi.'
    ]);

    $username = $request->username;
    $password = $request->password;

    if (strlen($password) < 3) {
        return back()->with('error', 'Password harus minimal 3 karakter.')->withInput();
    }

    if (!preg_match('/[A-Z]/', $password)) {
        return back()->with('error', 'Password harus mengandung minimal satu huruf kapital.')->withInput();
    }

    if ($username === 'Cinta Dwi' && $password === 'Cinta123') {

        // Simpan data ke session
        session([
            'username' => $username,
            'last_login' => now()->format('d M Y H:i:s')
        ]);

        // Redirect ke halaman home.blade.php
        return redirect('/')->with('success', 'Login berhasil! Selamat datang, ' . $username);
    } else {
        // Jika login gagal
        return back()->with('error', 'Username atau password salah.')->withInput();
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
