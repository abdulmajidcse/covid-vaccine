<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('users', [UserController::class, 'store']);
Route::get('search/{nid}', [UserController::class, 'search']);