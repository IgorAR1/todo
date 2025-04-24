<?php

use App\Http\Controllers\web\CollaborationController;
use App\Http\Controllers\web\LoginController;
use App\Http\Controllers\web\RegisterController;
use App\Http\Controllers\web\TaskController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::resource('tasks', TaskController::class)->middleware('auth');
Route::group(['middleware' => 'owner', 'prefix' => 'tasks/{task}/users'], function () {
    Route::get('/', [CollaborationController::class, 'index'])->name('tasks.collaboration');
    Route::post('/', [CollaborationController::class, 'share'])->name('task.share');
});

