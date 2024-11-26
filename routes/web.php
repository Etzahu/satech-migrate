<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    Route::get('qr', function(){
        $data = QrCode::size(512)
                ->format('png')
                ->merge('/storage/app/public/logotipo_GPT_negro.png')
                ->errorCorrection('M')
                ->generate(
                    'https://gptservices.com/perfil-corporativo-en',
                );

            return response($data)
                ->header('Content-type', 'image/png');
    });
