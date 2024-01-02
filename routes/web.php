<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/upload', [HomeController::class, 'upload'])->name('upload');


Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/auth/login' , [LoginController::class , 'loginUser'])->name('auth.login');
