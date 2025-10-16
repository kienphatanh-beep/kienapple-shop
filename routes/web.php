<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\CategoryController as FrontCategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController as ControllerMenu;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PostController as FrontPostController;
use App\Http\Controllers\OrderController as FrontOrderController;
// routes/web.php
use App\Http\Controllers\ChatAIController;




// BACKEND Controllers
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\CKEditorController;




// ================= FRONTEND =================

// Cart (chỉ cho user login)
Route::middleware('auth')->group(function () {
    // 🛒 Giỏ hàng
     Route::get('/user/settings', [AuthController::class, 'settings'])->name('settings');
    Route::post('/user/settings/update', [AuthController::class, 'updateSettings'])->name('settings.update');
    Route::post('/user/settings/password', [AuthController::class, 'updatePassword'])->name('settings.password');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::get('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/processCheckout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');
    Route::get('cart/qr/{order}', [CartController::class, 'qr'])->name('cart.qr');
    Route::post('/product/{id}/review', [FrontProductController::class, 'addReview'])->name('product.addReview');


    // 📦 Lịch sử đơn hàng
    Route::get('/orders', [FrontOrderController::class, 'history'])->name('orders.history');
     Route::get('/order/{id}', [FrontOrderController::class, 'show'])->name('order.show');
    // ❤️ Danh sách yêu thích
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product_id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});
Route::get('/test-chat', function(\App\Services\ChatGPTService $chatGPT) {
    return $chatGPT->ask('Xin chào! Bạn là ai?');
});

Route::post('/chat-ai', [ChatAIController::class, 'handle'])->name('chat.ai');
// Auth user
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
// 🔑 Quên mật khẩu (OTP)
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.show');
Route::post('/forgot-password', [AuthController::class, 'sendOTP'])->name('forgot.send');
Route::get('/verify-otp', [AuthController::class, 'showVerifyForm'])->name('forgot.verifyForm');
Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('forgot.verify');
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('forgot.resetForm');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::get('/about', [SiteController::class, 'about'])->name('site.about');

Route::get('/about', [SiteController::class, 'about'])->name('site.about');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

 

Route::prefix('post')->name('post.')->group(function () {
    Route::get('/', [FrontPostController::class, 'index'])->name('index');
    Route::get('/{slug}', [FrontPostController::class, 'show'])->name('show');
});
// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/myapp', [HomeController::class, 'index'])->name('home');

// Catalog (slug tiếng Việt)
Route::get('/san-pham', [FrontProductController::class, 'index'])->name('site.product');
Route::get('/san-pham/{slug}', [FrontProductController::class, 'detail'])->name('site.product_detail');

// Search
Route::get('/tim-kiem', [FrontProductController::class, 'search'])->name('site.search');

// Category
Route::get('/category/{id}', [FrontCategoryController::class, 'show'])->name('site.category.show');



// ================= ADMIN ROUTES =================

// Auth admin
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Nhóm route admin
Route::prefix('admin')->middleware('admin')->as('admin.')->group(function () {
Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])
        ->name('ckeditor.upload');
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

 // Product
Route::prefix('product')->group(function () {
    Route::get('trash', [ProductController::class, 'trash'])->name('product.trash');
    Route::get('restore/{product}', [ProductController::class, 'restore'])->name('product.restore');
    Route::post('status/{product}', [ProductController::class, 'status'])->name('product.status');
    Route::delete('forceDelete/{product}', [ProductController::class, 'forceDelete'])->name('product.forceDelete');
});
// ⚡ KHÔNG loại bỏ show nữa
Route::resource('product', ProductController::class);


    // Banner
    Route::prefix('banner')->group(function () {
        Route::get('trash', [BannerController::class, 'trash'])->name('banner.trash');
        Route::get('restore/{banner}', [BannerController::class, 'restore'])->name('banner.restore');
        Route::post('status/{banner}', [BannerController::class, 'status'])->name('banner.status');
        Route::delete('forceDelete/{banner}', [BannerController::class, 'forceDelete'])->name('banner.forceDelete');
    });
    Route::resource('banner', BannerController::class);

    // Category
        Route::prefix('category')->as('category.')->group(function () {
            Route::get('trash', [CategoryController::class, 'trash'])->name('trash');
            Route::get('restore/{id}', [CategoryController::class, 'restore'])->name('restore');
            Route::post('status/{id}', [CategoryController::class, 'status'])->name('status');
            Route::delete('delete/{id}', [CategoryController::class, 'delete'])->name('delete');
        });

        // CRUD chính
        Route::resource('category', CategoryController::class);

     Route::prefix('brand')->as('brand.')->group(function () {
            Route::get('trash', [BrandController::class, 'trash'])->name('trash');
            Route::get('restore/{id}', [BrandController::class, 'restore'])->name('restore');
            Route::post('status/{id}', [BrandController::class, 'status'])->name('status');
            Route::delete('delete/{id}', [BrandController::class, 'delete'])->name('delete');
        });

        // CRUD chính
        Route::resource('brand', BrandController::class);

    // Post
    Route::prefix('post')->as('post.')->group(function () {
        Route::get('trash', [PostController::class, 'trash'])->name('trash');
        Route::get('restore/{post}', [PostController::class, 'restore'])->name('restore');
        Route::post('status/{post}', [PostController::class, 'status'])->name('status');
        Route::delete('forceDelete/{post}', [PostController::class, 'forceDelete'])->name('forceDelete');
    });
    Route::resource('post', PostController::class);

    // Topic
    Route::prefix('topic')->as('topic.')->group(function () {
        Route::get('trash', [TopicController::class, 'trash'])->name('topic.trash');
        Route::get('restore/{topic}', [TopicController::class, 'restore'])->name('topic.restore');
        Route::post('status/{topic}', [TopicController::class, 'status'])->name('topic.status');
        Route::delete('forceDelete/{topic}', [TopicController::class, 'forceDelete'])->name('topic.forceDelete');
    });
    Route::resource('topic', TopicController::class);

    // Menu
    Route::prefix('menu')->as('menu.')->group(function () {
        Route::get('trash', [MenuController::class, 'trash'])->name('menu.trash');
        Route::get('restore/{menu}', [MenuController::class, 'restore'])->name('menu.restore');
        Route::post('status/{menu}', [MenuController::class, 'status'])->name('menu.status');
        Route::delete('forceDelete/{menu}', [MenuController::class, 'forceDelete'])->name('menu.forceDelete');
    });
    Route::resource('menu', MenuController::class) ;

    // Contact
    Route::prefix('contact')->as('contact.')->group(function () {
        Route::get('trash', [ContactController::class, 'trash'])->name('contact.trash');
        Route::get('restore/{contact}', [ContactController::class, 'restore'])->name('contact.restore');
        Route::post('status/{contact}', [ContactController::class, 'status'])->name('contact.status');
        Route::delete('forceDelete/{contact}', [ContactController::class, 'forceDelete'])->name('contact.forceDelete');
    });
    Route::resource('contact', ContactController::class);

    // USER
        Route::prefix('user')->as('user.')->group(function () {
            Route::get('trash', [UserController::class, 'trash'])->name('trash');
            Route::get('restore/{id}', [UserController::class, 'restore'])->name('restore');
            Route::post('status/{id}', [UserController::class, 'status'])->name('status');
            Route::delete('delete/{id}', [UserController::class, 'delete'])->name('delete');
        });

        Route::resource('user', UserController::class);

    // Order
        Route::prefix('order')->as('order.')->group(function () {
        Route::get('trash', [OrderController::class, 'trash'])->name('trash');
        Route::get('restore/{order}', [OrderController::class, 'restore'])->name('restore');
        Route::post('status/{order}', [OrderController::class, 'status'])->name('status');
        Route::delete('delete/{order}', [OrderController::class, 'delete'])->name('delete');
        Route::delete('forceDelete/{order}', [OrderController::class, 'destroy'])->name('forceDelete');
    });

    Route::resource('order', OrderController::class);
});


