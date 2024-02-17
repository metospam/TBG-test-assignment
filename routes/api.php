<?php

use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
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

Route::middleware('api')->prefix('v1')->group(function () {
    Route::post('upload', [UploadController::class, 'handleUploadFile']);

    Route::post('users/send', [UserController::class, 'handleSendFile']);
    Route::post('users', [UserController::class, 'handleGetUsers']);
    Route::post('users/create', [UserController::class, 'handleCreateUser']);
    Route::patch('users/{id}', [UserController::class, 'handleUpdateUser']);
    Route::delete('users/{id}', [UserController::class, 'handleDeleteUser']);
});
