<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "project"], function () {
    Route::get('{project_id}/graphData', [\App\Http\Controllers\Api\Project\ProjectController::class, 'graphData']);
    Route::get('{project_id}/task/{task_id}', [\App\Http\Controllers\Api\Project\ProjectController::class, 'getTask'])->name('api.project.task.edit');
    Route::put('{project_id}/task/{task_id}', [\App\Http\Controllers\Api\Project\ProjectController::class, 'updateTask']);
    Route::put('{project_id}/task/{task_id}/close', [\App\Http\Controllers\Api\Project\ProjectController::class, 'closeTask'])->name('api.project.task.close');
    Route::put('{project_id}/task/{task_id}/open', [\App\Http\Controllers\Api\Project\ProjectController::class, 'openTask'])->name('api.project.task.open');
    Route::delete('{project_id}/task/{task_id}', [\App\Http\Controllers\Api\Project\ProjectController::class, 'deleteTask'])->name('api.project.task.delete');

    Route::get('{project_id}/files', [\App\Http\Controllers\Api\Project\ProjectController::class, 'listFiles']);
    Route::post('{project_id}/files/search', [\App\Http\Controllers\Api\Project\ProjectController::class, 'searchFiles']);
    Route::post('{project_id}/files/upload', [\App\Http\Controllers\Api\Project\ProjectController::class, 'uploadFiles']);

    Route::get('{project_id}/messages', [\App\Http\Controllers\Api\Project\ProjectController::class, 'getMessages']);
    Route::post('{project_id}/messages', [\App\Http\Controllers\Api\Project\ProjectController::class, 'postMessages']);
});

Route::group(["prefix" => "user"], function () {
    Route::post('searching', [\App\Http\Controllers\Api\User\UserController::class, 'searching']);
});

