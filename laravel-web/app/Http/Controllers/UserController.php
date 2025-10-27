<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['user'] = user::all();
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$data['password'] = Hash::make($request->password);
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->only(['name', 'email', 'password']);
        // $data['password'] = Hash::make($data['password']);
        // User::create($data);
        // return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
        $validatedData = $request->validate([
        'name' => 'required|string|max:100',
        // unique:users,email artinya email harus unik di tabel 'users' pada kolom 'email'
        'email' => 'required|email|unique:users,email',
        // confirmed memerlukan input dengan name="password_confirmation"
        'password' => 'required|min:8|confirmed',
    ]);

    // Data yang akan disimpan
    $data = [
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        // Enkripsi password
        'password' => Hash::make($validatedData['password']),
    ];

    User::create($data);

    // Redirect dengan flash message 'success'
    return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan dan divalidasi!');
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
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $user = User::findOrFail($id);
        // $data = $request->only(['name', 'email']);
        // if ($request->filled('password')) {
        //     $data['password'] = Hash::make($request->password);
        // }
        // $user->update($data);
        // return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
        $user = User::findOrFail($id);

    // Terapkan Validasi
    $validatedData = $request->validate([
        'name' => 'required|string|max:100',
        // 'unique:users,email,'.$user->id artinya abaikan ID user ini saat mengecek keunikan email
        'email' => 'required|email|unique:users,email,' . $user->id,
        // password tidak required, tapi jika diisi, ia harus min:8 dan confirmed
        'password' => 'nullable|min:8|confirmed',
    ]);

    $data = [
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
    ];

    // Cek apakah password diisi/diubah
    if ($request->filled('password')) {
        $data['password'] = Hash::make($validatedData['password']);
    }

    $user->update($data);

    // Redirect dengan flash message 'success'
    return redirect()->route('user.index')->with('success', 'User berhasil diperbarui dan divalidasi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}
