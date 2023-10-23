<?php
namespace App\Http\Modules\Review\Presentation\Routes;

use App\Http\Modules\Review\Presentation\Controllers\ProductReviewController;
use Illuminate\Support\Facades\Route;

Route::post('create', [ProductReviewController::class, 'createProductReview']);
Route::get('create', [ProductReviewController::class, 'showCreateProductReview']);
Route::post('update/{id}', [ProductReviewController::class, 'updateProductReview']);
Route::post('delete/{id}', [ProductReviewController::class, 'deleteProductReview']);