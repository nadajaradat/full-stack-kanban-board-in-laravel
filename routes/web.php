<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::resource('tasks', TaskController::class)->except([
    'index',
])->middleware('auth');


Route::put('tasks/{id}/update-value/{status}/{position}', [TaskController::class, 'updateValue']);



Route::match(['get', 'post'],'/register', [AuthController::class, 'register'])->name('register')->middleware('guest');


Route::match(['get', 'post'],'/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
