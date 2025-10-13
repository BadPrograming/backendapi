<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    HomeController,
    AboutController,
    PortfolioController,
    CareerController,
    ContactController,
    AuthController,
    ServiceController,
    AdminController,
    CategoryServiceController,
    CategoryCareerController,
    ClientController,
    PageController,
    TeamController
};

// ================= Public Routes =================
Route::get('/home', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/careers', [CareerController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);

// ================= Authentication =================
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    
    // Logout harus pakai middleware sanctum
    Route::post('/logout', [AuthController::class, 'logout'])
         ->middleware('auth:sanctum');
});

// ================= Resource Routes =================
Route::apiResources([
    'about' => AboutController::class,
    'career' => CareerController::class,
    'client' => ClientController::class,
    'pages' => PageController::class,
    'service' => ServiceController::class,
    'portfolio' => PortfolioController::class,
    'admin' => AdminController::class,
    'categories' => CategoryServiceController::class,
    'category-careers' => CategoryCareerController::class,
    'team' => TeamController::class
]);

// Jika Portfolio ingin mendukung PUT & PATCH sekaligus, bisa ditambahkan:
Route::match(['put', 'patch'], '/portfolio/{portfolio}', [PortfolioController::class, 'update']);