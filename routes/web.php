<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;

// Mengarahkan URL root (/) langsung ke halaman daftar buku
Route::get('/', function () {
    return redirect()->route('buku.index');
});

// Mendaftarkan 7 rute CRUD otomatis untuk Buku dan Kategori
Route::resource('buku', BukuController::class);
Route::resource('kategori', KategoriController::class);