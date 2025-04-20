<?php

use App\Http\Controllers\web\CollaborationController;
use Illuminate\Support\Facades\Route;

Route::post('/{id}',[CollaborationController::class,'shareTask']);
