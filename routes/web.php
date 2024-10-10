<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('signin',[HomeController::class,'signin']);
Route::get('login',[HomeController::class,'login'])->name('login');
Route::get('profile',[HomeController::class,'profile'])->middleware('auth');
Route::post('store',[HomeController::class,'store'])->name('signinProcess');
Route::post('loginProcess',[HomeController::class,'loginProcess'])->name('loginProcess');

Route::post('logout', function(){
    Auth::logout();
    return redirect('login');
})->name('logout');
