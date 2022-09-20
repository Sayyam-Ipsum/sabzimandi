<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleController;

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

//-------------------------------------------------
//--------------Authentication Routes -------------
//-------------------------------------------------
Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forgot', [AuthController::class, 'forgotView']);
Route::get('/reset/{token}', [AuthController::class, 'resetPasswordView']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/forgot', [AuthController::class, 'forgotPassword']);
Route::post('/reset', [AuthController::class, 'resetPassword']);

Route::group(['middleware' => 'auth'], function (){
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('can:PageAccess.Dashboard');
    Route::get('/profile', [DashboardController::class, 'profile']);
    Route::get('/setting', [DashboardController::class, 'setting']);

    Route::group(['middleware' => 'can:PageAccess.Users'], function () {
        Route::prefix('users')->group(function (){
            Route::get('/', [UserController::class, 'index']);
            Route::get('/create/{customer?}', [UserController::class, 'create']);
            Route::get('/edit/{id}/{customer?}', [UserController::class, 'create']);
            Route::post('/store', [UserController::class, 'store']);
            Route::post('/store/{id}', [UserController::class, 'store']);
            Route::get('/status/{id}', [UserController::class, 'status']);
        });

        Route::prefix('customers')->group(function (){
            Route::get('/', [UserController::class, 'customers']);
        });
    });


    Route::group(['middleware' => 'can:PageAccess.Roles'], function (){
        Route::prefix('roles')->group(function (){
            Route::get('/', [RoleController::class, 'index']);
            Route::get('/create', [RoleController::class, 'create']);
            Route::get('/edit/{id}', [RoleController::class, 'create']);
            Route::post('/store', [RoleController::class, 'store']);
            Route::post('/store/{id}', [RoleController::class, 'store']);
            Route::get('/status/{id}', [RoleController::class, 'status']);
            Route::get('/permissions/{id}', [RoleController::class, 'rolePermissionsListing']);
            Route::post('/permissions', [RoleController::class, 'managePermissions']);
        });
    });

    Route::group(['middleware' => 'can:PageAccess.Products'], function (){
        Route::prefix('products')->group(function (){
            Route::get('/', [ProductController::class, 'index']);
            Route::get('/create', [ProductController::class, 'create']);
            Route::get('/edit/{id}', [ProductController::class, 'create']);
            Route::post('/store', [ProductController::class, 'store']);
            Route::post('/store/{id}', [ProductController::class, 'store']);
            Route::get('/status/{id}', [ProductController::class, 'status']);
        });
    });

    Route::prefix('pos')->group(function (){
        Route::get('/', [SaleController::class, 'pos']);
        Route::post('/', [SaleController::class, 'sell']);
    });

    Route::prefix('sales')->group(function (){
        Route::get('/', [SaleController::class, 'list']);
        Route::get('/today', [SaleController::class, 'todaySales']);
        Route::get('/{id}', [SaleController::class, 'show']);
        Route::get('/{customer?}', [SaleController::class, 'customerSales']);
    });
});


