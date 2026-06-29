<?php

use App\Http\Controllers\Api\v1\DocumentController;
use App\Http\Controllers\Api\v1\FilterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function(){
    
    Route::get('/filters', FilterController::class);
    Route::get('/documents', [DocumentController::class, 'index']);
    Route::get('/documents/{slug}', [DocumentController::class, 'show']);

});