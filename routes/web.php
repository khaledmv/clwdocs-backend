<?php

use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\TaxonomyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Models\Document;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use Spatie\PdfToText\Pdf;

Route::get('/test-pdf', function () {

    $text = Pdf::getText(
        storage_path('app/public/documents/test.pdf')
    );

    dd($text);

});

Route::get('/import-documents', function () {

    Document::query()
        ->chunkById(500, function ($documents) {
            $documents->searchable();
        });

    return 'Documents imported successfully!';
});

Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    Artisan::call('optimize');

    return 'Done';
});

Route::get('/', function () {
    return view('frontend.home');
})->name('frontend.index');

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



     // Documents 
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::post('/documents/{id}/restore', [DocumentController::class, 'restore'])->name('documents.restore');
    Route::delete('/documents/{id}/force', [DocumentController::class, 'forceDelete'])->name('documents.force-delete');
    Route::post('/documents/{document}/publish', [DocumentController::class, 'publish'])->name('documents.publish');
    Route::post('/documents/{document}/unpublish', [DocumentController::class, 'unpublish'])->name('documents.unpublish');

  

});









