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


require __DIR__.'/auth.php';
Route::middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::group(['prefix' => 'files', 'middleware' => 'auth'], function () {
        Lfm::routes();
    });
});
