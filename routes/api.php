<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\BuyerController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\BuyerAddressesController;
use App\Http\Controllers\API\StateController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\AreaController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CheckinController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Authendication
Route::controller(RegisterController::class)->group(function(){
    // Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('otp_login', 'otp_login');
    Route::post('reset_password', 'reset_password');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

// Sales Person
Route::middleware('auth:sanctum', 'role:Sales Person')->prefix('sales_person')->group( function () {
    Route::get('/buyer_lists', [BuyerController::class, 'index']);
    Route::post('/search_buyer', [BuyerController::class, 'search_buyer']);
    Route::post('/checkin', [CheckinController::class, 'store']);
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::post('/no_order', [OrderController::class, 'no_order']);
});

// Buyer
Route::middleware('auth:sanctum', 'role:Buyer')->prefix('buyer')->group( function () {
    Route::get('/address_lists', [BuyerAddressesController::class, 'index']);
    Route::post('/add_new_address', [BuyerAddressesController::class, 'store']);
    Route::post('/delete_address', [BuyerAddressesController::class, 'delete_address']);
});

// General with auth
Route::middleware('auth:sanctum')->group( function () {
    Route::get('/category_list', [CategoryController::class, 'index']);
    Route::post('/category_product_list', [ProductController::class, 'category_product_list']);
    Route::post('/add_to_cart', [CartController::class, 'add_to_cart']);
    Route::get('/cart_list', [CartController::class, 'index']);
    Route::post('/update_cart_product', [CartController::class, 'update_cart_product']);
    Route::post('/delete_cart_product', [CartController::class, 'delete_cart_product']);
    Route::post('/edit_address', [BuyerAddressesController::class, 'edit_address']);
    Route::get('/state_list', [StateController::class, 'index']);
    Route::get('/city_list', [CityController::class, 'index']);
    Route::get('/area_list', [AreaController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'index']);
    Route::post('/place_order', [OrderController::class, 'store']);
    Route::get('/my_orders', [OrderController::class, 'my_orders']);
    Route::post('/product_details', [ProductController::class, 'product_details']);
});