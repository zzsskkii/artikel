<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ArticleController;

// Public Routes (Portal Berita)
Route::get('/', [PublicController::class, 'index']);
Route::get('/kategori/{id}', [PublicController::class, 'category']);
Route::get('/berita/{id}', [PublicController::class, 'article']);

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Dashboard (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('welcome', ['categories' => \App\Models\Category::all()]); // the simple table SPA we built earlier
    });
    
    // API endpoints moved to web to easily share session auth
    Route::apiResource('api/articles', ArticleController::class);
    Route::get('api/reporters', [\App\Http\Controllers\ReporterController::class, 'index']);
});
