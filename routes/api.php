<?php

use App\Http\Controllers\Api\Blog\BlogApiController;
use App\Http\Controllers\Api\Career\CareerApiController;
use App\Http\Controllers\Api\Product\ProductApiController;
use App\Http\Controllers\Api\Service\ServiceApiController;
use App\Http\Controllers\Candidate\CandidateController;
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

Route::group(['prefix' => 'candidate'], function(){
    Route::post('apply-job', [CandidateController::class, 'register']);
});

Route::group(['prefix' => 'blogs'], function(){
    Route::get('get', [BlogApiController::class, 'getBlogs']);
    Route::get('details', [BlogApiController::class, 'details']);
});

Route::group(['prefix' => 'service'], function(){
    Route::get('get', [ServiceApiController::class, 'getAllService']);
    Route::get('details', [ServiceApiController::class, 'serviceDetails']);
});

Route::group(['prefix' => 'products'], function(){
    Route::get('get', [ProductApiController::class, 'getAllProducts']);
    Route::get('details', [ProductApiController::class, 'productDetails']);
});

Route::group(['prefix' => 'career'], function(){
    Route::get('get', [CareerApiController::class, 'getCareer']);
    Route::get('details', [CareerApiController::class, 'getCareerDetails']);
});