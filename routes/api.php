<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ok', function () {
    return 'ok';
});
Route::get('/articles', [ArticleController::class, 'getAllArticles']);
// Route::get('/article/{id}', [ArticleController::class, 'getArticle']);
Route::get('/article/{article}', [ArticleController::class, 'getArticle']);  //route for implicit binding

Route::middleware('auth:api')->group(function () {                              // first way to use middleware
    Route::post('/article', [ArticleController::class, 'createArticle']);
    Route::put('/article/{article}', [ArticleController::class, 'updateArticle']);
});
Route::delete('/article/{article}', [ArticleController::class, 'deleteArticle'])->middleware('auth:api'); //anothe way to use middleware

Route::middleware('auth:api')->get('/user', function (Request $request) { //url?api_token=YOUR TOKEN
    return $request->user();
});

//for login
Route::post('/token', [UserController::class, 'generateToken']);

//create user
Route::get('/create', function () {
    User::forceCreate([
        'name' => 'Sahadat Hossain',
        'email' => 'sahadat@gmail.com',
        'password' => Hash::make('11223344')
    ]);
    User::forceCreate([
        'name' => 'Faruq Hossain',
        'email' => 'faruq@gmail.com',
        'password' => Hash::make('11223344')
    ]);
});



//for token generata
Route::get('/tc', function () {
    $user = User::find(1);
    $user->api_token = Str::random(80);
    $user->save();

    $user = User::find(2);
    $user->api_token = Str::random(80);
    $user->save();
});
