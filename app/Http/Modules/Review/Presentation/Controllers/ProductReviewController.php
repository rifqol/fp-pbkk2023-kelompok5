<?php
namespace App\Http\Modules\Review\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Review\Application\Service\ProductReview\CreateProductReviewRequest;
use App\Http\Modules\Review\Application\Service\ProductReview\IndexProductReviewRequest;
use App\Http\Modules\Review\Application\Service\ProductReview\ProductReviewService;
use App\Http\Modules\Review\Application\Service\ProductReview\UpdateProductReviewRequest;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function __construct(
        private ProductReviewService $product_review_service
    ) {}

    public function indexProductReview(Request $request, $id)
    {
        $index_request = new IndexProductReviewRequest($id ?? 0);

        return $this->executeService(
            function() use($index_request) {return $this->product_review_service->indexProductReview($index_request);}
        );
    }
    
    public function createProductReview(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|max:1023',
            'user_id' => 'required|numeric|exists:users,id|',
            'product_id' => 'required|numeric|exists:products,id',
        ]);

        $create_request = new CreateProductReviewRequest(
            $request->rating,
            $request->review,
            $request->user_id,
            $request->product_id,
        );

        return $this->executeService(
            function() use($create_request) {return $this->product_review_service->createProductReview($create_request);}
        );
    }

    public function showCreateProductReview(Request $request)
    {
        return view('review-form');
    }

    public function updateProductReview(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'rating' => 'required',
            'review' => 'nullable',
        ]);

        $update_request = new UpdateProductReviewRequest(
            $request->id,
            $request->rating,
            $request->review,
            $request->user_id,
            $request->product_id
        );

        return $this->executeService(
            function() use($update_request) {return $this->product_review_service->updateProductReview($update_request);}
        );
    }

    public function deleteProductReview(Request $request)
    {
        return $this->executeService(
            function() use($request) {return $this->product_review_service->deleteProductReview($request->id);}
        );
    }
}