<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\TravelInsurancecontroller;
use App\Http\Controllers\GroupInsuranceController;
use App\Http\Controllers\PostController;

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
})->name('home');

Route::prefix('/travel-insurance')->group(function() {
    
    Route::post('/store', [TravelInsuranceController::class, 'store']);
    Route::put('/{id}', [TravelInsurancecontroller::class, 'update']);
    Route::delete('/{id}', [TravelInsuranceController::class, 'destroy']);

    Route::get('/admin/show-travel-insurances', [TravelInsuranceController::class, 'index']);
    
});

Route::prefix('/user')->group(function() {

    Route::post('/store', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);

    Route::post('/login', [UserController::class, 'authenticate']);

});

Route::prefix('/group')->group(function() {

    Route::get('/{id}', [GroupInsuranceController::class, 'groupById']);

});

Route::prefix('/admin')->group(function() {

    Route::post('/post-store', [PostController::class, 'store']);

});

// Post Routes
Route::get('/post-all', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/post-edit/{id}', [PostController::class, 'edit']);
Route::post('/post-update', [PostController::class, 'update']);
Route::post('/post-archive', [PostController::class, 'archive']);
