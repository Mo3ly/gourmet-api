<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ResturantController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminDashboardController;
use App\Events\OrderReceived;

// Auth
Route::group(['middleware' => ['web']], function () {  
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', AuthController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Resturants
Route::get('/resturants', [ResturantController::class, 'index']);
Route::get('/resturants/{name}', [ResturantController::class, 'show']);

// Products
Route::get('/products', [ProductController::class, 'index']);

// orders -> make token in order to create 
Route::post('/orders/store', [OrderController::class, 'store']);

// Bookings
Route::post('/bookings/store', [BookingController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function () {

  // user data
  Route::get('/user', function (Request $request) {
      $user = $request->user();
      $user['scope'] = array($user['scope']); 
      return $user;
  });

  // admin dashboard
  Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);

  // resturants
  Route::post('/resturants/store', [ResturantController::class, 'store']);
  Route::post('/resturants/destroy', [ResturantController::class, 'destroy']);
  Route::post('/resturants/update', [ResturantController::class, 'update']);

  // categories
  Route::post('/categories/store', [MenuCategoryController::class, 'store']);
  Route::post('/categories/destroy', [MenuCategoryController::class, 'destroy']);
  Route::post('/categories/update', [MenuCategoryController::class, 'update']);

  // Products
  Route::post('/products/store', [ProductController::class, 'store']);
  Route::post('/products/destroy', [ProductController::class, 'destroy']);
  Route::post('/products/update', [ProductController::class, 'update']);

  // orders
  Route::get('/orders', [OrderController::class, 'index']);
  Route::get('/orders/paginated', [OrderController::class, 'paginate']);
  Route::get('/orders/today', [OrderController::class, 'todayOrders']);
  Route::get('/orders/id/{id}', [OrderController::class, 'show']);
  Route::post('/orders/destroy', [OrderController::class, 'destroy']);
  Route::post('/orders/update', [OrderController::class, 'update']);

  // bookings
  Route::get('/bookings', [BookingController::class, 'index']);
  Route::get('/bookings/paginated', [BookingController::class, 'paginate']);
  Route::post('/bookings/destroy', [BookingController::class, 'destroy']);
  Route::post('/bookings/update', [BookingController::class, 'update']);
});