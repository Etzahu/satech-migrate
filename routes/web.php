<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login/google', [LoginController::class, 'redirectToProvider'])->name('login.redirect');
Route::get('/login/google/callback', [LoginController::class, 'handleProviderCallback'])->name('login.callback');
Route::get('home', [LoginController::class, 'home'])->name('home')->middleware('auth');

if (config('app.env') === 'local') {
    @include_once('pruebas.php');
}
