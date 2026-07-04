<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

// ... (kode route lainnya jika ada)

Route::apiResource('articles', ArticleController::class);