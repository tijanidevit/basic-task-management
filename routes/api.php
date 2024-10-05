<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
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


// Route::as('auth.')->group(function () {
//     // Route::post('register', [AuthController::class, 'register'])->name('register');
//     Route::post('login', [AuthController::class, 'login'])->name('login');
// });

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
//     Route::as('employee.')->prefix('employees')->group(function () {
//         Route::get('', [EmployeeController::class, 'index'])->name('index');
//         Route::post('', [EmployeeController::class, 'store'])->name('store');
//         Route::get('{id}', [EmployeeController::class, 'show'])->name('show');
//         Route::patch('', [EmployeeController::class, 'update'])->name('update');
//         Route::delete('{id}', [EmployeeController::class, 'delete'])->name('delete');
//     });


//     Route::as('schedule.')->prefix('schedules')->group(function () {
//         Route::get('', [ScheduleController::class, 'index'])->name('index');
//         Route::post('', [ScheduleController::class, 'store'])->name('store');
//         Route::get('{id}', [ScheduleController::class, 'show'])->name('show');
//         Route::delete('{id}', [ScheduleController::class, 'delete'])->name('delete');
//     });
// });
