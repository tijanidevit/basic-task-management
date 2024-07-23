<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::as('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::as('task.')->prefix('tasks')->group(function () {
        Route::get('', [TaskController::class, 'index'])->name('index');
        Route::post('', [TaskController::class, 'store'])->name('store');
        Route::get('{id}', [TaskController::class, 'show'])->name('show');
        Route::patch('', [TaskController::class, 'update'])->name('update');
        Route::delete('{id}', [TaskController::class, 'delete'])->name('delete');
        Route::post('{id}/status', [TaskController::class, 'toggleStatus'])->name('toggleStatus');
    });
});
