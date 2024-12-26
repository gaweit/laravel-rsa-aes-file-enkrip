<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\HomeController;
use App\Http\Controllers\Main\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Main\KategoriController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::redirect('/', '/auth/login');
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'processLogin']);
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'processRegister']);
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::prefix('main')->middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // user
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user/tambah', [UserController::class, 'tambah'])->name('tambah');
    Route::post('user/simpan', [UserController::class, 'simpan'])->name('user.simpan');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('user/lihat/{id}', [UserController::class, 'lihat'])->name('user.lihat');
    Route::post('user/aksi_ubah/{id}', [UserController::class, 'aksi_ubah'])->name('user.aksi_ubah');
    Route::get('user/hapus/{id}', [UserController::class, 'hapus'])->name('user.hapus');

    // kategori
    Route::resource('kategori', KategoriController::class);
});
