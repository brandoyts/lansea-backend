<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
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

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/user', 'user');

});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, "logout"]);

    Route::prefix('jobs')->controller(JobController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'store');
        Route::put('/update', 'update');
        Route::delete('/delete/{job}', 'destroy');
        Route::delete('/clear-all', 'clearAll');
    });
});
