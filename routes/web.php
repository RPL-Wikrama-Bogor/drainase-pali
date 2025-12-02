<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DrainageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'home'])->name('home');

Route::get('/peta', function() {
    return view('peta');
})->name('peta');
Route::get('/peta/drainase', [DrainageController::class, 'maps'])->name('maps');

Route::get('/data-drainase', function() {
    return view('data');
})->name('data_drainase');
Route::get('/data/datatables', [DrainageController::class, 'datatables'])->name('data.datatables');
Route::get('/data/{drainageId}', [DrainageController::class, 'show'])->name('data.show');

Route::get('/laporan-pengaduan', [ComplaintController::class, 'index'])->name('pengaduan');
Route::get('/laporan-pengaduan/datatables', [ComplaintController::class, 'datatables'])->name('pengaduan.datatables');

Route::get('/login', function() {
    return view('login');
})->name('login');
Route::post('/login', [UserController::class, 'auth'])->name('auth');

Route::middleware('isAdmin')->group(function() {
    Route::prefix('/admin')->name('admin.')->group(function() {
        Route::get('dashboard', function() {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::prefix('/drainase')->name('drainase.')->group(function() {
            Route::get('/', [DrainageController::class, 'index'])->name('index');
            Route::post('/upload-image', [DrainageController::class, 'uploadImage'])->name('upload-image');
            Route::post('/update-image/{id}', [DrainageController::class, 'updateImage'])->name('update-image');
            Route::delete('/delete-image/{id}', [DrainageController::class, 'deleteImage'])->name('delete-image');

            // Route untuk melihat dan download gambar
            Route::get('/image/{id}', [DrainageController::class, 'showImage'])->name('show-image');
            Route::get('/image/{id}/download', [DrainageController::class, 'downloadImage'])->name('download-image');
        });
    });

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});
