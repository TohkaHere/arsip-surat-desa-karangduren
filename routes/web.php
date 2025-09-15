<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    return redirect()->route('surat.index');
});

// Routes untuk Surat
Route::resource('surat', SuratController::class);
Route::get('surat/{surat}/download', [SuratController::class, 'download'])->name('surat.download');
Route::get('surat/{surat}/preview', [SuratController::class, 'preview'])->name('surat.preview');
Route::post('surat/{surat}/preview-secure', [SuratController::class, 'previewSecure'])->name('surat.preview.secure');
Route::get('surat/{surat}/preview-data', [SuratController::class, 'previewDataUri'])->name('surat.preview.data');

// Routes untuk Kategori
Route::resource('kategori', KategoriController::class);

// Route untuk About
Route::get('/about', function () {
    return view('about');
})->name('about');
