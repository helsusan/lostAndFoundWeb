<?php

use App\Http\Controllers\AdminFormController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
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

Route::get('/form-item', [AdminFormController::class, 'index'])->name('admin.showForm');

Route::get('/report', [AdminReportController::class, 'showAdminReport'])->name('admin.showAdminReport');
Route::put('/report/verified/{report}', [AdminReportController::class, 'isVerified'])->name('admin.isVerified');
Route::get('/report/edit/{report}', [AdminReportController::class, 'editAdminReport'])->name('admin.editReport');
Route::put('/report/update/{report}', [AdminReportController::class, 'updateAdminReport'])->name('admin.updateReport');
Route::delete('/report/{report}', [AdminReportController::class, 'deleteAdminReport'])->name('admin.deleteReport');


Route::get('/items', [AdminItemController::class, 'showAdminItem'])->name('admin.showAdminItem');
Route::get('/items/{item}/edit', [AdminItemController::class, 'editAdminItem'])->name('admin.editItem');
Route::put('/items/{item}', [AdminItemController::class, 'updateAdminItem'])->name('admin.updateItem');
Route::delete('/items/{item}', [AdminItemController::class, 'deleteAdminItem'])->name('admin.deleteItem');
Route::patch('/items/{id}/update-status', [AdminItemController::class, 'updateStatus'])->name('admin.updateStatus');


Route::get('/home', [HomeController::class, 'index']);

require __DIR__.'/auth.php';
