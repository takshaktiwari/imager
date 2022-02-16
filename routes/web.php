<?php

use Illuminate\Support\Facades\Route;
use Takshak\Imager\Http\Controllers\PicsumController;
use Takshak\Imager\Http\Controllers\PlaceholderController;

Route::prefix('imgr')->name('imgr.')->group(function(){
	if(config('site.imager.placeholder.enable_url', true)){
		Route::get('placeholder', [PlaceholderController::class, 'index'])->name('placeholder');
	}

	if(config('site.imager.picsum.enable_url', true)){
		Route::get('picsum', [PicsumController::class, 'index'])->name('picsum');
	}
});