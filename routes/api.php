<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiProjectController;
use App\Http\Controllers\ApiJobController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login',[ApiUserController::class,'login']);
Route::post('/register',[ApiUserController::class,'register']);
Route::get('/logout',[ApiUserController::class,'logout']);
Route::get('/projects/list',[ApiProjectController::class,'list']);
Route::post('/projects/add',[ApiProjectController::class,'add']);
Route::post('/projects/update',[ApiProjectController::class,'update']);
Route::post('/projects/delete',[ApiProjectController::class,'delete']);
Route::get('/projects/detail',[ApiProjectController::class,'detail']);
Route::post('/jobs/add',[ApiJobController::class,'add']);
Route::post('/jobs/update',[ApiJobController::class,'update']);
Route::post('/jobs/detail',[ApiJobController::class,'detail']);
Route::post('/jobs/stateUpdate',[ApiJobController::class,'stateUpdate']);
Route::post('/jobs/delete',[ApiJobController::class,'delete']);
