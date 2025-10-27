@extends('admin.layouts.app')
@section('title', 'Edit user ' . $user->name)
@section('content')

    <div class="py-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                {{-- Judul Diperbaiki --}}
                <h1 class="h4">Edit User: {{ $user->name }}</h1>
                <p class="mb-0">Form untuk memperbarui data User.</p>
            </div>
            <div>
                <a href="{{ route('user.index') }}" class="btn btn-primary"><i class="far fa-arrow-left me-1"></i>
                    Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">

                    {{-- Menampilkan Flash Message Success/Error --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Metode wajib untuk Update --}}
                        <div class="row">
                            {{-- Kolom Pertama: Name dan Email --}}
                            <div class="col-lg-6 col-sm-12">

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        {{-- old() mengambil nilai dari sesi, jika tidak ada, gunakan nilai dari $user --}}
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kolom Kedua: Password dan Konfirmasi Password (Optional) --}}
                            <div class="col-lg-6 col-sm-12">

                                <!-- Password BARU (Optional) -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru (Kosongkan jika tidak ingin diubah)</label>
                                    {{-- JANGAN PERNAH mengisi value pada input password saat edit! --}}
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        {{-- Hapus 'required' karena password bersifat optional saat update --}}
                                    >
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation" {{-- NAMA YANG BENAR --}}
                                        class="form-control"
                                        {{-- Hapus 'required' --}}
                                    >
                                    {{-- Error 'confirmed' akan ditampilkan di field 'password' --}}
                                </div>
                            </div>

                            <hr class="mt-4">

                            <!-- Buttons -->
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">Update User</button>
                                <a href="{{ route('user.index') }}"
                                    class="btn btn-outline-secondary ms-2">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
