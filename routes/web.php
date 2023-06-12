<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Candidate\CandidateController;
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

    Route::group(['prefix' => 'dashboard'], function(){
        Route::get('view', [DashboardController::class, 'viewDashboard'])->name('admin.view.dashboard');
    });

    Route::group(['prefix' => 'blog'], function(){

        Route::get('allBlog', [BlogController::class, 'allBlog'])->name('admin.view.all.blog');
        Route::get('blog-details/{id}', [BlogController::class, 'viewBlogDetails'])->name('admin.view.blog.details');
        Route::get('add-new-blog-page', [BlogController::class, 'newBlogPage'])->name('admin.create.new.blog');
        Route::get('edit-blog-details-page/{id}', [BlogController::class, 'editBlogDetailsPage'])->name('admin.edit.blog.details.page');
        Route::post('create-blog', [BlogController::class, 'createBlog'])->name('admin.create.blog');
        Route::post('edit-blog', [BlogController::class, 'editBlog'])->name('admin.edit.blog');
        Route::post('change-status', [BlogController::class, 'changeStatusBlog'])->name('admin.blog.change.status');

    });
    
    Route::group(['prefix' => 'opening'], function(){

        Route::get('add-new-opening-page', [CareerController::class, 'addNewOpeningPage'])->name('admin.add.new.opening.page');
        Route::post('create', [CareerController::class, 'createOpening'])->name('admin.create.openings');
        Route::get('active-opening', [CareerController::class, 'activeOpening'])->name('admin.active.opening');
        Route::get('deActive-opening', [CareerController::class, 'deActiveOpening'])->name('admin.deActive.opening');
        Route::post('change-status', [CareerController::class, 'changeStatus'])->name('admin.change.status');
        Route::get('view/{id}', [CareerController::class, 'viewOpening'])->name('admin.view.opening');
        Route::post('edit', [CareerController::class, 'editOpening'])->name('admin.edit.opening');

    });
    
    Route::group(['prefix' => 'candidate'], function(){

        Route::get('all-candidates', [CandidateController::class, 'allCandidates'])->name('admin.all.candidates');

    });
    
    Route::group(['prefix' => 'service'], function(){

        Route::get('all-services', [ServiceController::class, 'getAllServices'])->name('admin.get.all.services');
        Route::get('add-new-service-page', [ServiceController::class, 'addNewServicePage'])->name('admin.add.new.service.page');
        Route::post('create', [ServiceController::class, 'createService'])->name('admin.create.service');
        Route::get('details/{id}', [ServiceController::class, 'serviceDetails'])->name('admin.service.details');
        Route::get( 'edit-service-page/{id}', [ServiceController::class, 'editService'])->name('admin.edit.service.page');
        Route::post( 'save-edit-service', [ServiceController::class, 'saveEditService'])->name('admin.save.edit.service');
        Route::post('change-status', [ServiceController::class, 'changeStatus'])->name('admin.service.change.status');

    });
    
    Route::group(['prefix' => 'product'], function(){

        Route::get('all-products', [ProductController::class, 'getAllProducts'])->name('admin.get.all.products');
        Route::get('add-new-product-page', [ProductController::class, 'addNewProductPage'])->name('admin.add.new.product.page');
        Route::post('create', [ProductController::class, 'createProduct'])->name('admin.create.product');
        Route::get('details/{id}', [ProductController::class, 'productDetails'])->name('admin.product.details');
        Route::get( 'edit-product-page/{id}', [ProductController::class, 'editProduct'])->name('admin.edit.product.page');
        Route::post( 'save-edit-product', [ProductController::class, 'saveEditProduct'])->name('admin.save.edit.product');
        Route::post('change-status', [ProductController::class, 'changeStatus'])->name('admin.product.change.status');

    });

    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
});
