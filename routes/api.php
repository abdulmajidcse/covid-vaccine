<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VaccineCenterController;
use Illuminate\Support\Facades\Route;

Route::get('vaccine-centers', VaccineCenterController::class);
Route::post('users', [UserController::class, 'store']);
Route::get('search/{nid}', [UserController::class, 'search']);