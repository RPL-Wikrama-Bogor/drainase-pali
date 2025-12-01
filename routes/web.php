<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DrainageController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'home'])->name('home');

Route::get('/peta', function() {
    return view('peta');
})->name('peta');
Route::get('/peta/drainase', [DrainageController::class, 'maps'])->name('maps');

Route::get('/login', function() {
    return view('login');
})->name('login');

Route::get('/data-drainase', function() {
    return view('data');
})->name('data_drainase');
Route::get('/data/datatables', [DrainageController::class, 'datatables'])->name('data.datatables');
Route::get('/data/{drainageId}', [DrainageController::class, 'show'])->name('data.show');

Route::get('/laporan-pengaduan', [ComplaintController::class, 'index'])->name('pengaduan');
Route::get('/laporan-pengaduan/datatables', [ComplaintController::class, 'datatables'])->name('pengaduan.datatables');

