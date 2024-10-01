<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\InfoblockController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\AdminController;



Route::get('/', [MainController::class, 'index']);
Route::get('/catalog', [CatalogController::class, 'getCatalog']);

Route::get('/productByCategory', [CatalogController::class, 'productByCategory']);
Route::get('/getSubcategory', [CatalogController::class, 'getSubcategory']);
Route::get('/sort', [CatalogController::class, 'sort']);
Route::get('/getProduct/{id}', [CatalogController::class, 'getProduct']);

Route::get('/getBasket', [BasketController::class, 'getBasket']);

Route::post('/addProduct', [BasketController::class, 'addProduct']);
Route::post('/addBasketProduct', [BasketController::class, 'addBasketProduct']);
Route::post('/plusProduct', [BasketController::class, 'plusProduct']);
Route::post('/minusProduct', [BasketController::class, 'minusProduct']);
Route::post('/deleteProduct', [BasketController::class, 'deleteProduct']);
Route::get('/getTotalBasket', [BasketController::class, 'getTotalBasket']);


Route::post('/basketToOrders', [BasketController::class, 'BasketToOrders']);


Route::get('/getCity', [BasketController::class, 'getCity']);
Route::post('/getAddress', [BasketController::class, 'getAddress']);

Route::post('/decBasketProduct', [BasketController::class, 'decBasketProduct']);
Route::post('/addReview', [ReviewController::class, 'addReview']);

Route::post('/updateRating', [ProductController::class, 'updateRating']);

Route::post('/getFavorite', [FavoriteController::class, 'getFavorite']);
Route::post('/updateFavorite', [FavoriteController::class, 'updateFavorite']);
Route::get('/getFavoriteByUser', [FavoriteController::class, 'getFavoriteByUser']);

Route::post('/getReview', [ReviewController::class, 'getReview']);

Route::get('/getUserBasket', [BasketController::class, 'getUserBasket']);


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/getOrders', [OrderController::class, 'getOrders']);
Route::get('/getOrdersProduct/{id}', [OrderController::class, 'getOrdersProduct']);

Route::get('/seller/createSeller', [SellerController::class, 'createSeller']);



Route::post('/checkSeller', [SellerController::class, 'checkSeller']);

Route::post('/insertSeller', [SellerController::class, 'insertSeller']);



Route::get('/seller/profile', [SellerController::class, 'profile']);

Route::get('/seller/create', [SellerController::class, 'create']);


Route::post('/getSubcategories', [SellerController::class, 'getSubcategories']);
Route::post('/insertProduct', [SellerController::class, 'insertProduct']);
Route::get('/seller/getProducts', [SellerController::class, 'getProducts']);
Route::post('/checkUpdateCount', [SellerController::class, 'checkUpdateCount']);
Route::post('/updateCount', [SellerController::class, 'updateCount']);



Route::post('/deleteReview', [ReviewController::class, 'deleteReview']);


Route::post('/updateFavoriteCatalog', [CatalogController::class, 'updateFavoriteCatalog']);



Route::get('/getInfoblock/{id}', [InfoblockController::class, 'getInfoblock']);
Route::get('/getQuestionsAndAnswers', [InfoblockController::class, 'getQuestionsAndAnswers']);


Route::post('/getProductsInOrder', [HomeController::class, 'getProductsInOrder']);

Route::get('/search', [MainController::class, 'search']);


Route::post('/getSearchProducts', [CatalogController::class, 'getSearchProducts']);
Route::get('/targetPage', [CatalogController::class, 'targetPage']);


Route::get('/getSeller/{id}', [SellerController::class, 'getSeller']);


// Route::get('/admin/home', [AdminController::class, 'index'])->name('index');


Route::prefix('admin')->group(function(){
    Route::get('/home', [AdminController::class, 'index'])->name('admin.home')->middleware('admin_check');
    Route::resource('products', App\Http\Controllers\admin\ProductController::class)->middleware('is_admin');
    Route::resource('sellers', App\Http\Controllers\admin\SellerController::class)->middleware('is_admin');
    Route::resource('reviews', App\Http\Controllers\admin\ReviewController::class)->middleware('is_admin');
    Route::resource('categories', App\Http\Controllers\admin\CategoryController::class)->middleware('is_admin');
    Route::resource('subcategories', App\Http\Controllers\admin\SubcategoryController::class)->middleware('is_admin');
    Route::resource('questAndAns', App\Http\Controllers\admin\QuestionAndAnswerController::class)->middleware('is_admin');
    Route::resource('city', App\Http\Controllers\admin\CityController::class)->middleware('is_admin');
    Route::resource('point', App\Http\Controllers\admin\PointController::class)->middleware('is_admin');
    Route::resource('color', App\Http\Controllers\admin\ColorController::class)->middleware('is_admin');
    Route::resource('worker', App\Http\Controllers\admin\WorkerController::class)->middleware('is_admin');
    Route::resource('order', App\Http\Controllers\admin\OrderController::class)->middleware('is_admin');

    Route::prefix('work')->group(function(){
        Route::resource('work_products', App\Http\Controllers\admin\work\ProductController::class)->middleware('is_worker');
        Route::resource('work_orders', App\Http\Controllers\admin\work\OrderController::class)->middleware('is_worker');
        Route::resource('work_getProduct', App\Http\Controllers\admin\work\getProductController::class)->middleware('is_worker');
        Route::resource('work_update', App\Http\Controllers\admin\work\UpdateController::class)->middleware('is_worker');
    });
});