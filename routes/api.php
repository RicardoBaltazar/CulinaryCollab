<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Recipe\CreateRecipeController;
use App\Http\Controllers\Recipe\GetRecipeController;
use App\Http\Controllers\Recipe\GetUserRecipesController;
use App\Http\Controllers\User\CreateUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/user', CreateUserController::class);

Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/recipe', CreateRecipeController::class);
    Route::get('/recipe', GetRecipeController::class);
    Route::get('/user/recipes', GetUserRecipesController::class);
});
