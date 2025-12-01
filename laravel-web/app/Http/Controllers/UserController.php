<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataUser'] = user::all();
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$data['password'] = Hash::make($request->password);
        $data['roles'] = Role::all();
        return view('admin.user.create', $data);
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
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:7|string',
            'role'     => 'required',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($request->hasFile('avatar')) {
            // Simpan ke folder 'public/avatars'
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($validatedData);
        $user->assignRole($request->role);
        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Penambahan Data Berhasil!');
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
        $data['dataUser'] = User::findOrFail($id);
        $data['roles']    = Role::all();
        return view('admin.user.edit', compact('user'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:7'],                         // Password baru
            'role'     => ['required', 'string'],                                  // Role wajib diisi
            'avatar'   => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'], // Avatar baru, maksimal 2MB
        ]);

        if (filled($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($validatedData['avatar']);
        }

        $user->update($validatedData);
        $user->syncRoles($request->role);

        return redirect()->route('admin.user.index')->with('success', 'Perubahan Data Berhasil!');
    }

/**
 * Remove the specified resource from storage.
 */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);

            $user->delete();

            return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil dihapus!');
        }
    }
}
