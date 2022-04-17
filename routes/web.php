<?php

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Stacks AS Stacks;
use App\Http\Livewire\Session AS Session;
use App\Http\Livewire\Sessions AS Sessions;
use App\Http\Livewire\Teams AS Teams;
use App\Http\Controllers AS Controllers;

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
    return redirect()->route('list-stacks');
});

Route::middleware('auth')->group(function () {
    Route::get('/stacks/create', Stacks\Create::class)->name('create-stack');
    Route::get('/stacks/{category}', Stacks\Index::class)->name('list-stacks');
    Route::get('/stacks/{stack}/edit', Stacks\Edit::class)->name('edit-stack');
    Route::get('/stacks/{stack}/preview', Stacks\Preview::class)->name('preview-stack');
    Route::get('/stacks/{stack}/present', Stacks\Present::class)->name('present-stack');
    Route::get('/stacks/{stack}/build', Stacks\Build::class)->name('build-stack');
    Route::get('/stacks/{stack}/download', Stacks\Download::class)->name('download-stack');
    Route::get('/stacks/{stack}/settings', Stacks\Configure::class)->name('configure-stack');

    Route::get('/stacks/{stack}.zip', [\App\Http\Controllers\StackController::class, 'zip'])->name('zip-stack');

    Route::get('/stacks/{stack}/preview/{overlay}.png', [Controllers\StackController::class, 'view'])->name('view-overlay');
    Route::get('/stacks/{stack}/preview/{overlay}', [Controllers\StackController::class, 'preview'])->name('preview-overlay');

    Route::get('/sessions', Sessions\Index::class)->name('list-sessions');

    Route::get('/teams', Teams\Index::class)->name('list-teams');
    Route::get('/teams/create', Teams\Create::class)->name('create-team');
    Route::get('/teams/{team}/edit', Teams\Edit::class)->name('edit-team');
    Route::get('/teams/{team}/settings', Teams\Configure::class)->name('configure-team');
    Route::get('/teams/{team}', [Controllers\TeamController::class, 'select'])->name('select-team');
});

Route::middleware('visitor')->group(function () {
    Route::get('/view/{slug}.{format}', Session\View::class)->name('public-view')->where('format', 'png|html');

    Route::get('/overlay/{uuid}.html', [Controllers\OverlayController::class, 'preview'])->name('overlay-preview');
    Route::get('/overlay/{uuid}.png', [Controllers\OverlayController::class, 'png'])->name('overlay-png');
    Route::get('/overlay/{uuid}/overlay_{index}.png', [Controllers\OverlayController::class, 'download'])->name('download-png');
    Route::get('/control/{slug}/control', [Controllers\PresentController::class, 'control'])->name('public-control');
});
