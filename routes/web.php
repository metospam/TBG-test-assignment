<?php

use App\Http\Controllers\IndexController;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Route;
use WeStacks\TeleBot\TeleBot;

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


Route::get('/{page}', IndexController::class)->where('page', '.*');



