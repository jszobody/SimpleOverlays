<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::livewire('/stacks', 'stacks.index')->name('list-stacks');
    Route::livewire('/stacks/create', 'stacks.create')->name('create-stack');
    Route::livewire('/stacks/{stack}/edit', 'stacks.edit')->name('edit-stack');
    Route::livewire('/stacks/{stack}/preview', 'stacks.preview')->name('preview-stack');
    Route::livewire('/stacks/{stack}/present', 'stacks.present')->name('present-stack');
    Route::livewire('/stacks/{stack}/download', 'stacks.download')->name('download-stack');
    Route::livewire('/stacks/{stack}/settings', 'stacks.configure')->name('configure-stack');

    Route::get('/stacks/{stack}.zip', [\App\Http\Controllers\StackController::class, 'zip'])->name('zip-stack');

    Route::get('/stacks/{stack}/preview/{overlay}.png', [\App\Http\Controllers\StackController::class, 'view'])->name('view-overlay');
    Route::get('/stacks/{stack}/preview/{overlay}', [\App\Http\Controllers\StackController::class, 'preview'])->name('preview-overlay');
});

Route::middleware('visitor')->group(function () {
    Route::livewire('/view/{slug}.{format}', 'session.view')->name('public-view')->layout('layouts.session')->where('format', 'png|html');

    Route::get('/overlay/{uuid}.html', [\App\Http\Controllers\OverlayController::class, 'preview'])->name('overlay-preview');
    Route::get('/overlay/{uuid}.png', [\App\Http\Controllers\OverlayController::class, 'png'])->name('overlay-png');
    Route::get('/control/{slug}/control', [\App\Http\Controllers\PresentController::class, 'control'])->name('public-control');
});


