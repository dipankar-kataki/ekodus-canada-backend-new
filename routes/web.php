<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Career\CareerController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Service\ServiceController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LoginController::class, 'getLoginForm'])->name('admin.get.login');

Route::post('login', [LoginController::class, 'login'])->name('admin.login');

Route::group(['middleware' => 'auth'], function(){

    Route::group(['prefix' => 'view'], function(){
        Route::get('dashboard', [DashboardController::class, 'viewDashboard'])->name('admin.view.dashboard');
        Route::get('blog/{id?}', [BlogController::class, 'viewBlog'])->name('admin.view.blog');
        Route::get('blog-details/{id}', [BlogController::class, 'viewBlogDetails'])->name('admin.view.blog.details');
    });
    
    Route::group(['prefix' => 'create'], function(){
        Route::get('new-blog', [BlogController::class, 'newBlogPage'])->name('admin.create.new.blog');
        Route::post('blog', [BlogController::class, 'createBlog'])->name('admin.create.blog');
    });
    
    Route::group(['prefix' => 'edit'], function(){
        Route::post('blog', [BlogController::class, 'editBlog'])->name('admin.edit.blog');
        Route::post('change-status', [BlogController::class, 'changeStatusBlog'])->name('admin.blog.change.status');
    });
    
    Route::group(['prefix' => 'opening'], function(){
        Route::get('all-openings', [CareerController::class, 'viewAllOpenings'])->name('admin.view.all.openings');
        Route::post('create', [CareerController::class, 'createOpening'])->name('admin.create.openings');
        Route::post('change-status', [CareerController::class, 'changeStatus'])->name('admin.change.status');
        Route::get('view/{id}', [CareerController::class, 'viewOpening'])->name('admin.view.opening');
        Route::post('edit', [CareerController::class, 'editOpening'])->name('admin.edit.opening');
    });
    
    Route::group(['prefix' => 'candidate'], function(){
        Route::get('all-candidates', [CandidateController::class, 'allCandidates'])->name('admin.all.candidates');
    });
    
    Route::group(['prefix' => 'service'], function(){
        Route::get('all', [ServiceController::class, 'getAllServices'])->name('admin.get.all.services');
        Route::post('create', [ServiceController::class, 'createService'])->name('admin.create.service');
        Route::get('details/{id}', [ServiceController::class, 'serviceDetails'])->name('admin.service.details');
        Route::get( 'edit-service/{id}', [ServiceController::class, 'editService'])->name('admin.edit.service');
        Route::post( 'save-edit-service', [ServiceController::class, 'saveEditService'])->name('admin.save.edit.service');
        Route::post('change-status', [ServiceController::class, 'changeStatus'])->name('admin.service.change.status');
    });
    
    Route::group(['prefix' => 'product'], function(){
        Route::get('all', [ProductController::class, 'getAllProducts'])->name('admin.get.all.products');
        Route::post('create', [ProductController::class, 'createProduct'])->name('admin.create.product');
        Route::get('details/{id}', [ProductController::class, 'productDetails'])->name('admin.product.details');
        Route::get( 'edit-product/{id}', [ProductController::class, 'editProduct'])->name('admin.edit.product');
        Route::post( 'save-edit-product', [ProductController::class, 'saveEditProduct'])->name('admin.save.edit.product');
        Route::post('change-status', [ProductController::class, 'changeStatus'])->name('admin.product.change.status');
    });

    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
});
