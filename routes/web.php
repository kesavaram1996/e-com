<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\PriceSlabController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\BuyerController;
use App\Http\Controllers\Admin\SalesPersonController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\SuperAdmin\AdminOrderController;
use App\Http\Controllers\Admin\DailyLogController;

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

// Only Super Admin
Route::get('/superAdmin', function () {
    return view('superAdmin.login');
})->name('superAdmin');

// Front End
Route::get('/', function () {
    return view('welcome');
});

// Default Auth
Auth::routes();

// Super Admin
Route::group(['middleware' => ['auth','role:Super Admin'],'prefix' => 'superAdmin'], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('admin_orders', AdminOrderController::class);
});

// Admin
Route::group(['middleware' => ['auth'],'prefix' => 'admin'], function() {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('sub_categories', SubCategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('price_slabs', PriceSlabController::class);
    Route::resource('products', ProductController::class);
    Route::get('edit_products', [ProductController::class, 'edit_products'])->name('products.edit_products');
    Route::post('update_products', [ProductController::class, 'update_products'])->name('update_products');
    Route::get('min_stock_products', [ProductController::class, 'min_stock_products'])->name('products.min_stock_products');
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('buyers', BuyerController::class);
    Route::resource('sales_persons', SalesPersonController::class);
    Route::resource('promo_codes', PromoCodeController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('orders', OrderController::class);
    Route::post('get_invoice', [OrderController::class, 'get_invoice'])->name('orders.get_invoice');
    Route::resource('admin_settings', AdminSettingController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('about', AboutController::class);
    Route::resource('privacy_policy', PrivacyPolicyController::class);
    Route::post('contact/upload', [ContactController::class, 'upload'])->name('contact.upload');
    Route::post('about/upload', [AboutController::class, 'upload'])->name('about.upload');
    Route::post('privacy_policy/upload', [PrivacyPolicyController::class, 'upload'])->name('privacy_policy.upload');
    Route::post('privacy_policy/terms_conditions_upload', [PrivacyPolicyController::class, 'terms_conditions_upload'])->name('privacy_policy.terms_conditions_upload');
    Route::post('privacy_policy/terms_conditions', [PrivacyPolicyController::class, 'terms_conditions'])->name('privacy_policy.terms_conditions');
    Route::resource('faqs', FAQController::class);
    Route::post('faqdelete', [FAQController::class, 'faqdelete'])->name('faqs.faqdelete');
    Route::resource('daily_logs', DailyLogController::class);

    Route::controller(ReportController::class)->group(function(){
        Route::post('login', 'login');
        Route::get('/sales_report','sales_report')->name('sales_report');
        Route::get('/buyers_report','buyers_report')->name('buyers_report');
        Route::get('/sales_persons_report','sales_persons_report')->name('sales_persons_report');
        Route::get('/top_buyers','top_buyers')->name('top_buyers');
        Route::get('/product_wise_report','product_wise_report')->name('product_wise_report');
        Route::get('/top_selling_products','top_selling_products')->name('top_selling_products');
        Route::get('/product_sales_chart','product_sales_chart')->name('product_sales_chart');
        Route::Post('/get_chart','get_chart')->name('get_chart');
    });
});

// Genaral with Auth
Route::get('/get_city_list/{id}',[AreaController::class, 'get_city_list'])->middleware('auth');
Route::get('/get_area_list/{id}',[AreaController::class, 'get_area_list'])->middleware('auth');
Route::get('orders', [HomeController::class, 'index'])->name('orders')->middleware('auth');
Route::get('/change_status',[OrderController::class, 'change_status'])->middleware('auth');
Route::get('/order_fetch_data', [AdminOrderController::class, 'fetch_data'])->middleware('auth');


