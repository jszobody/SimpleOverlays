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

    Route::get('/stacks', [\App\Http\Controllers\StackController::class, 'list'])->name('stacks.list');
    Route::livewire('/stacks/{stack}', 'stacks.edit');

    Route::post('/overlays/previews', [\App\Http\Controllers\OverlayController::class, 'createPreview'])->name('overlays.create-preview');
    Route::get('/overlays/previews/{hash}', [\App\Http\Controllers\OverlayController::class, 'preview'])->name('overlays.preview');

});

Auth::routes();
