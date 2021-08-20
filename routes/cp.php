<?php

use Illuminate\Support\Facades\Route;
use VOLLdigital\Autosizeimages\Controllers\AutosizeimagesController;

Route::group(["prefix" => "autosizeimages"], function () {
    Route::get('/', [AutosizeimagesController::class, 'index'])->name('autosizeimages.index');
    Route::get('settings', [AutosizeimagesController::class, 'settings'])->name('autosizeimages.settings');
    Route::post('saveSettings', [AutosizeimagesController::class, 'saveSettings'])->name('autosizeimages.saveSettings');
});
