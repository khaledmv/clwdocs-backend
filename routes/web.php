<?php

use App\Http\Controllers\Admin\TaxonomyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('backend.index');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';


Route::get('admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

Route::middleware('auth')->group(function(){
    Route::get('/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'AdminProfileStore'])->name('profile.store');
});



Route::middleware('auth')->group(function(){
    
  Route::prefix('taxonomy')->name('taxonomy.')->group(function () {
    Route::get('{type}', [TaxonomyController::class, 'index'])->name('index');

    Route::get('{type}/create', [TaxonomyController::class, 'create'])->name('create');
    Route::post('{type}', [TaxonomyController::class, 'store'])->name('store');

    Route::get('{type}/{id}/edit', [TaxonomyController::class, 'edit'])->name('edit');
    Route::put('{type}/{id}', [TaxonomyController::class, 'update'])->name('update');

    Route::delete('{type}/{id}', [TaxonomyController::class, 'destroy'])->name('destroy');
  });

});









