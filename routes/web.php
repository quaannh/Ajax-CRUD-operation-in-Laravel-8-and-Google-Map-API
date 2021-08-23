<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

use Rescources\Views;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('location', [LocationController::class, 'index']);
Route::post('location', [LocationController::class, 'store']);
Route::get('fetch-location', [LocationController::class, 'fetch']);
Route::get('edit-location/{id}', [LocationController::class, 'edit']);
Route::put('update-location/{id}', [LocationController::class, 'update']);
Route::delete('delete-location/{id}', [LocationController::class, 'destroy']);
