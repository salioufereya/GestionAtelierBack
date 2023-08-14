<?php

use App\Http\Controllers\CategorieController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::apiResource('/categorie', CategorieController::class)->only(['store', 'update', 'index', 'destroy']);

Route::get('/categorie/all', [CategorieController::class, 'all']);
Route::post('/categorie/add', [CategorieController::class, 'add']);
Route::get('/categorie/{one}/get', [CategorieController::class, 'getOne']);
Route::delete('/categorie/delete', [CategorieController::class, 'delete']);
Route::put('/categorie/{categorie}/update', [CategorieController::class, 'update']);

Route::post('/categorie/search', [CategorieController::class, 'search']);
