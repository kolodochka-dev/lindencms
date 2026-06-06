<?php

use LindenCMS\Cms\Http\Controllers\FileController;
use LindenCMS\Cms\Http\Controllers\HtmxController;
use LindenCMS\Cms\Http\Controllers\NodeController;
use Illuminate\Support\Facades\Route;

Route::prefix(config('lindencms.route_prefix'))->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [NodeController::class, 'dashboard'])->name('dashboard');
    Route::post('/htmx/{method}', HtmxController::class)->name('htmx');
    Route::controller(NodeController::class)->prefix('/nodes/{code}')->group(function () {
        // Show
        Route::get('/show/{id}', 'show')->name('nodes.show');
        // Index
        Route::get('', 'index')->name('nodes.index');
        // Create
        Route::get('/create', 'create')->name('nodes.create');
        Route::post('', 'store')->name('nodes.store');
        // Update
        Route::get('/edit/{id}', 'edit')->name('nodes.edit');
        Route::put('/{id}', 'update')->name('nodes.update');
        // Delete
        Route::delete('/{id}', 'delete')->name('nodes.delete');
        Route::post('/deletes', 'deletes')->name('nodes.deletes');
        // Copy
        Route::post('/copy/{id}', 'copy')->name('nodes.copy');
        Route::post('/copies', 'copies')->name('nodes.copies');
    });

    Route::controller(FileController::class)->prefix('/files')->group(function () {
        Route::get('preview/{fileId}', 'preview')->name('files.preview');
        Route::get('download/{fileId}', 'download')->name('files.download');
    });
});
