<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Recipe\CreateRecipeController;
use App\Http\Controllers\Recipe\DeleteRecipeController;
use App\Http\Controllers\Recipe\GetRecipeController;
use App\Http\Controllers\Recipe\GetUserRecipesController;
use App\Http\Controllers\Recipe\SearchRecipeController;
use App\Http\Controllers\Recipe\UpdateRecipeController;
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
    Route::get('/recipe/search/{provider}', SearchRecipeController::class);

    Route::get('/user/recipes', GetUserRecipesController::class);
    Route::delete('user/recipe/{id}', DeleteRecipeController::class);
    Route::put('user/recipe/{id}', UpdateRecipeController::class);

    Route::post('logout', LogoutController::class);
});
