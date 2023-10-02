<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleVenteController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
use App\Models\Article;
use App\Models\ArticleVenteCategorie;
use App\Models\Fournisseur;
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



Route::group(['prefix' => 'categorie'], function () {
    Route::get('/all', [CategorieController::class, 'all']);
    Route::get('/index', [CategorieController::class, 'index']);
    Route::post('/add', [CategorieController::class, 'add']);
    Route::get('/{one}/get', [CategorieController::class, 'getOne']);
    Route::delete('/delete', [CategorieController::class, 'delete']);
    Route::put('/{categorie}/update', [CategorieController::class, 'update']);
    Route::post('/search', [CategorieController::class, 'search']);
});


Route::group(['prefix' => 'article'], function () {
    Route::get('/all', [ArticleController::class, 'index']);
    Route::post('/add', [ArticleController::class, 'store']);
    Route::post('/last', [ArticleController::class, 'lastArticle']);
    Route::post('/editer/{libelle}', [ArticleController::class, 'editer']);
    Route::delete('/delete', [ArticleController::class, 'delete']);
    Route::get('/Articategorie', [ArticleController::class, 'chargeData']);
    Route::post('/image', [ArticleController::class, 'getImage']);
});

Route::group(['prefix' => 'fournisseur'], function () {
    Route::get('/all', [FournisseurController::class, 'index']);
    Route::post('/search', [FournisseurController::class, 'search']);
    Route::post('/add', [FournisseurController::class, 'store']);
});


Route::group(['prefix' => 'articleVente'], function () {
    Route::get('/all', [ArticleVenteController::class, 'index']);
    Route::post('/add', [ArticleVenteController::class, 'store']);
    Route::post('/editer/{libelle}', [ArticleVenteController::class, 'update']);
    Route::delete('/delete', [ArticleVenteController::class, 'delete']);
});
