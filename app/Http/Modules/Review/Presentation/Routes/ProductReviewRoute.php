<?php
namespace App\Http\Modules\Review\Presentation\Routes;

use App\Http\Modules\Review\Presentation\Controllers\ProductReviewController;
use Illuminate\Support\Facades\Route;

Route::post('reviews/create', [ProductReviewController::class, 'createProductReview']);
Route::get('reviews/create', [ProductReviewController::class, 'showCreateProductReview']);
Route::post('reviews/update/{id}', [ProductReviewController::class, 'updateProductReview']);
Route::post('reviews/delete/{id}', [ProductReviewController::class, 'deleteProductReview']);
Route::get('products/{id}/reviews', [ProductReviewController::class, 'indexProductReview'])->whereNumber('id');