<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ItemController;
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

Route::get('/reports/create', [ReportController::class, 'createUserReport'])->name('user.createReport');
Route::post('/reports/insert', [ReportController::class, 'insertUserReport'])->name('user.insertReport');

Route::get('/reports', [ReportController::class, 'showAdminReport'])->name('admin.showAdminReport');
Route::put('/reports/verified/{report}', [ReportController::class, 'isVerified'])->name('admin.isVerified');
Route::get('/reports/edit/{report}', [ReportController::class, 'editAdminReport'])->name('admin.editReport');
Route::put('/reports/update/{report}', [ReportController::class, 'updateAdminReport'])->name('admin.updateReport');
Route::delete('/reports/{report}', [ReportController::class, 'deleteAdminReport'])->name('admin.deleteReport');

Route::get('/reports/assign/{report}', [ReportController::class, 'showAssignPage'])->name('admin.showAssignPage');
Route::post('/reports/assign-item/{report}', [ReportController::class, 'assignItemToReport'])->name('admin.assignItemToReport');
Route::get('/items/detail/{item}', [ReportController::class, 'detailItem'])->name('admin.detailItem');

Route::get('/items', [ItemController::class, 'showAdminItem'])->name('admin.showAdminItem');
Route::get('/items/create', [ItemController::class, 'createAdminItem'])->name('admin.createItem');
Route::post('/items/insert', [ItemController::class, 'insertAdminItem'])->name('admin.insertItem');
Route::get('/items/edit/{item}', [ItemController::class, 'editAdminItem'])->name('admin.editItem');
Route::put('/items/update/{item}', [ItemController::class, 'updateAdminItem'])->name('admin.updateItem');
Route::delete('/items/delete/{item}', [ItemController::class, 'deleteAdminItem'])->name('admin.deleteItem');
Route::patch('/items/update-item-status/{id}', [ItemController::class, 'updateItemStatus']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
