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

    Route::livewire('/stacks/create', 'stacks.create');
    Route::livewire('/stacks/{stack}', 'stacks.edit');

    Route::get('/stacks/{stack}/preview/{overlay}', [\App\Http\Controllers\StackController::class, 'preview'])->name('stacks.preview');

});

Auth::routes();
