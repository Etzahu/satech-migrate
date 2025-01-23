<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LoginController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\PurchaseOrderController;
use Vormkracht10\FilamentMails\Facades\FilamentMails;
use App\Http\Controllers\PurchaseRequisitionController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login/google', [LoginController::class, 'redirectToProvider'])->name('login.redirect');
Route::get('/login/google/callback', [LoginController::class, 'handleProviderCallback'])->name('login.callback');
Route::get('home', [LoginController::class, 'home'])->name('home')->middleware('auth');

if (config('app.env') === 'local') {
    @include_once('pruebas.php');
}
@include_once('purchase-requisition.php');

Route::get('empresa/{id}', [LoginController::class, 'setCompany'])
    ->name('company')
    ->middleware('auth');

Route::post('/logout', function () {
    Session::flush();
    Auth::logout();
    return redirect()->to('/');
})->name('logout');


FilamentMails::routes();

Route::get('compras/requisiciones/{id}/pdf',[PurchaseRequisitionController::class,'pdf'])
->name('requisition.pdf');
Route::get('compras/ordenes/{id}/pdf',[PurchaseOrderController::class,'pdf'])
->name('order.pdf');
