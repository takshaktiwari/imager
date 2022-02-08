<?php

use Illuminate\Support\Facades\Route;
use Takshak\Imager\Http\Controllers\PicsumController;
use Takshak\Imager\Http\Controllers\PlaceholderController;

Route::prefix('imgr')->name('imgr.')->group(function(){
	Route::get('placeholder', [PlaceholderController::class, 'index'])->name('placeholder');
	Route::get('picsum', [PicsumController::class, 'index'])->name('picsum');
});