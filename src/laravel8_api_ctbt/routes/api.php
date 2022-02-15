<?php

use App\Http\Controllers\DeviveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/devices', [DeviveController::class, 'getAll']);
Route::get('/devices/{id}', [DeviveController::class, 'getById']);
Route::post('/device/add', [DeviveController::class, 'addNewDevice']);
Route::put('/device/update', [DeviveController::class, 'updateDevice']);
Route::get('/device/search/{keyword}', [DeviveController::class, 'searchDevice']);
Route::delete('/device/delete/{id}', [DeviveController::class, 'delete']);