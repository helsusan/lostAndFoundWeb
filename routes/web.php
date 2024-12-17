<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/fetch-verified-reports', [HomeController::class, 'fetchVerifiedReports']);
    Route::get('/fetch-lost-goods', [HomeController::class, 'fetchLostGoods']);
    // Add the route for fetching reports
    Route::get('/fetch-reports', [HomeController::class, 'fetchReports']);


    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:1'])->group(function(){
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
        Route::get('/admin/assign/item/{id}', [ItemController::class, 'showAssignItemPage'])->name('admin.showAssignItemPage');
        Route::post('/admin/assign/item/{id}', [ItemController::class, 'assignItem'])->name('admin.assignItem');
    });

    Route::middleware(['role:2'])->group(function(){
        Route::get('/myreports', [MyReportController::class, 'showMyReports'])->name('myreport.showReports');
        Route::get('/myreports/edit/{report}', [MyReportController::class, 'editMyReport'])->name('myreport.editReport');
        Route::put('/myreports/update/{report}', [MyReportController::class, 'updateMyReport'])->name('myreport.updateReport');
        Route::put('/myreports/found/{id}', [MyReportController::class, 'foundReport'])->name('myreport.foundReport');
        Route::delete('/myreports/{report}', [MyReportController::class, 'deleteMyReport'])->name('myreport.deleteReport');
        Route::get('/myreports/create', [MyReportController::class, 'createMyReport'])->name('myreport.createReport');
        Route::post('/myreports/insert', [MyReportController::class, 'insertMyReport'])->name('myreport.insertReport');
    });
});


require __DIR__.'/auth.php';

