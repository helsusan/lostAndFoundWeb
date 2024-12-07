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

Route::get('/reports', [AdminReportController::class, 'showAdminReport'])->name('admin.showAdminReport');
Route::put('/reports/verified/{report}', [AdminReportController::class, 'isVerified'])->name('admin.isVerified');
Route::get('/reports/edit/{report}', [AdminReportController::class, 'editAdminReport'])->name('admin.editReport');
Route::put('/reports/update/{report}', [AdminReportController::class, 'updateAdminReport'])->name('admin.updateReport');
Route::delete('/reports/{report}', [AdminReportController::class, 'deleteAdminReport'])->name('admin.deleteReport');

Route::get('/reports/{report}/assign', [AdminReportController::class, 'showAssignPage'])->name('admin.showAssignPage');
Route::post('/reports/{report}/assign-item', [AdminReportController::class, 'assignItemToReport'])->name('admin.assignItemToReport');
Route::get('/items/{item}', [AdminReportController::class, 'detailItem'])->name('admin.detailItem');


Route::get('/items', [AdminItemController::class, 'showAdminItem'])->name('admin.showAdminItem');
Route::get('/items/{item}/edit', [AdminItemController::class, 'editAdminItem'])->name('admin.editItem');
Route::put('/items/{item}', [AdminItemController::class, 'updateAdminItem'])->name('admin.updateItem');
Route::delete('/items/{item}', [AdminItemController::class, 'deleteAdminItem'])->name('admin.deleteItem');
Route::patch('/items/{id}/update-item-status', [AdminItemController::class, 'updateItemStatus']);


Route::get('/home', [HomeController::class, 'index']);

require __DIR__.'/auth.php';
