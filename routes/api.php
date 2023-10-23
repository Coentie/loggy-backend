<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Issue\IssueController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

Route::post('projects', [ProjectController::class, 'store']);

Route::group([
    'middleware' => 'auth:api'
], function() {
    Route::get('projects', [ProjectController::class, 'index']);
    Route::post('issues', [IssueController::class, 'store']);
    Route::get('issues/{issue}', [IssueController::class, 'show']);
    Route::post('issues/test', [IssueController::class, 'test']);
});


