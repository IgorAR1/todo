<?php

use App\Http\Controllers\web\CollaborationController;
use App\Http\Controllers\web\LoginController;
use App\Http\Controllers\web\RegisterController;
use App\Http\Controllers\web\TaskController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::resource('tasks', TaskController::class)->middleware('auth');
Route::group(['middleware' => 'owner', 'prefix' => 'tasks/{task}/users'], function () {
    Route::get('/', [CollaborationController::class, 'index']);
    Route::post('/', [CollaborationController::class, 'shareTask'])->name('task.share');
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [LoginController::class, 'index']);
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('register', [RegisterController::class, 'index']);
    Route::post('register', [RegisterController::class, 'register'])->name('register');
});
