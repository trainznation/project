<?php

use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

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


require __DIR__ . '/auth.php';
Route::middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');

    Route::group(["prefix" => "project"], function () {
        Route::get('/', [\App\Http\Controllers\Project\ProjectController::class, 'index'])->name('project.index');
        Route::get('create', [\App\Http\Controllers\Project\ProjectController::class, 'create'])->name('project.create');
        Route::post('create', [\App\Http\Controllers\Project\ProjectController::class, 'store'])->name('project.store');
        Route::get('{project_id}', [\App\Http\Controllers\Project\ProjectController::class, 'show'])->name('project.show');
        Route::post('{project_id}/addUsers', [\App\Http\Controllers\Project\ProjectController::class, 'addUsers'])->name('project.addUsers');
    });

    Route::group(["prefix" => "public"], function () {
        Route::get('/', [\App\Http\Controllers\Project\ProjectController::class, 'public'])->name('project.public');
    });

    Route::group(['prefix' => 'files'], function () {
        Lfm::routes();
    });

    Route::group(["prefix" => "account"], function () {
        Route::get('readAllNotification', [\App\Http\Controllers\Account\AccountController::class, 'readAllNotification']);
    });
});
