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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/stacks', [\App\Http\Controllers\StackController::class, 'list'])->name('list-stacks');

    Route::livewire('/stacks/create', 'stacks.create')->name('create-stack');
    Route::livewire('/stacks/{stack}/edit', 'stacks.edit')->name('edit-stack');
    Route::livewire('/stacks/{stack}/preview', 'stacks.preview')->name('preview-stack');
    Route::livewire('/stacks/{stack}/present', 'stacks.present')->name('present-stack');

    Route::get('/stacks/{stack}/preview/{overlay}.png', [\App\Http\Controllers\StackController::class, 'view'])->name('view-overlay');
    Route::get('/stacks/{stack}/preview/{overlay}', [\App\Http\Controllers\StackController::class, 'preview'])->name('preview-overlay');
});

Route::get('/overlay/{uuid}', [\App\Http\Controllers\PresentController::class, 'preview'])->name('public-preview-overlay');
Route::get('/{slug}/play', [\App\Http\Controllers\PresentController::class, 'play'])->name('public-play');
Route::get('/{slug}/control', [\App\Http\Controllers\PresentController::class, 'control'])->name('public-control');

Auth::routes();
