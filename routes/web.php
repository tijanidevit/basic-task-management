<?php

use App\Http\Controllers\App\AuthController;
use App\Http\Controllers\App\EmployeeController;
use App\Http\Controllers\App\ScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('login');



Route::as('auth.')->middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('home', [EmployeeController::class, 'dashboard'])->name('home');


    Route::as('employee.')->prefix('employees')->group(function () {
        Route::get('', [EmployeeController::class, 'index'])->name('index');
        Route::get('new', [EmployeeController::class, 'create'])->name('create');
        Route::post('', [EmployeeController::class, 'store'])->name('store');
        Route::get('{id}', [EmployeeController::class, 'show'])->name('show');
        Route::patch('', [EmployeeController::class, 'update'])->name('update');
        Route::delete('{id}', [EmployeeController::class, 'delete'])->name('delete');
    });


    Route::as('schedule.')->prefix('schedules')->group(function () {
        Route::get('', [ScheduleController::class, 'index'])->name('index');
        Route::get('new', [ScheduleController::class, 'create'])->name('create');
        Route::post('', [ScheduleController::class, 'store'])->name('store');
        Route::get('{id}', [ScheduleController::class, 'show'])->name('show');
        Route::delete('{id}', [ScheduleController::class, 'delete'])->name('delete');
    });
});
