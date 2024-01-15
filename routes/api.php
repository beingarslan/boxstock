<?php

use App\Http\Controllers\API\ContactForm;
use App\Http\Controllers\API\ImageUpdateController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProductManageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SizeController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\VariantController;


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

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::group(['middleware' => 'auth'], function() {
    Route::resources([
        'brands'        => BrandController::class,
        'categories'    => CategoryController::class,
        'colors'        => ColorController::class,
        'sizes'         => SizeController::class,
        'products'      => ProductController::class,
        'variants'      => VariantController::class,
        'orders'        => OrderController::class,
        'posts'         => PostController::class
    ]);
    Route::get('/filter/search', [ProductManageController::class, 'productFilter']);
    Route::get('/search', [ProductManageController::class, 'productFilterSearch']);
    Route::get('/product/single', [ProductManageController::class, 'getProductBySlug']);
    Route::get('/filter/type', [ProductManageController::class, 'getProductByType']);
    Route::post('/contact', [ContactForm::class, 'send_contact']);
    Route::post('/image/update', [ImageUpdateController::class, 'update_image']);
});

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth'
], function ($router) {
    Route::get('/users', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/user/{id}', [AuthController::class, 'singleUser']);
    Route::post('/update/{id}', [AuthController::class, 'update']);
    Route::post('/delete/{id}', [AuthController::class, 'delete']);
});

/*

Route::group([
    'middleware' => ['api']
], function ($router) {
    //Route::apiResource('products', ProductController::class);
});

**/



//Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admins','jwt.auth']],function ()

//:middleware(['auth', 'user-access:user'])
