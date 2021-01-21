<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Auth\Events\Login;
use App\Http\Middleware\IsUserLogged;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware([IsUserLogged::class])->group(function () {
    Route::get('/',[IndexController::class,'Home']);
    Route::get('/yeni-proje-ekle',[IndexController::class,'NewProject']);
    Route::get('/yeni-is-ekle',[IndexController::class,'NewJob']);
    Route::get('/projeler/{id}',[IndexController::class,'ProjectDetail']);
    Route::get('/isler/{id}',[IndexController::class,'JobDetail']);
});
Route::get('/giris-yap', [LoginController::class,'Login']);
Route::get('/kayit-ol',[LoginController::class,'Register']);
