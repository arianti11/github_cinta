<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home', [
        'username' => session('username'),
        'last_login' => session('last_login'),
    ]);
});

Route::get('/pcr', function () {
    return 'Selamat Datang di website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Hallo Mahasiswa';
});

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: '.$param1;
});

Route::get('/nim/{param1}', function ($param1) {
    return 'Nim saya: '.$param1;
});

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('matakuliah');

Route::get('/matakuliah/show/{param1?}', [MataKuliahController::class, 'show']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('question/store', [QuestionController::class, 'store']) ->name('question.store');

Route::get('/auth', [AuthController::class, 'index']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/', [PegawaiController::class, 'index'])->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('pelanggan', PelangganController::class);

Route::resource('user', UserController::class);

Route::middleware('guest')->group(function () {

    // Halaman Form Login
    Route::get('/auth', [AuthController::class, 'index'])->name('login');

    // Proses Submit Login
    Route::post('/auth/login', [AuthController::class, 'login'])
        ->name('login.process');

    // Halaman Depan (Welcome)
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // DASHBOARD UNTUK USER BIASA
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Fitur User Biasa (Contoh: Kirim Pertanyaan)
    Route::post('/question/store', [QuestionController::class, 'store'])
        ->name('question.store');

    // =======================
    // KHUSUS ADMIN
    // =======================
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->group(function () {

            // Manajemen User
            Route::resource('user', UserController::class);

            // Manajemen Pelanggan
            Route::resource('pelanggan', PelangganController::class);
        });
});
