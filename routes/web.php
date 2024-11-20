<?php

use App\Http\Controllers\AdminFormController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/report', [AdminReportController::class, 'showAdminReport'])->name('admin.showAdminReport');
Route::get('/form-item', [AdminFormController::class, 'index'])->name('admin.showForm');

Route::put('/report/verified/{report}', [AdminReportController::class, 'isVerified'])->name('admin.isVerified');

require __DIR__.'/auth.php';
