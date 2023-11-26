<?php
namespace App\Http\Modules\Review\Application\Service\ProductReview;

use App\Http\Modules\Review\Domain\Models\ProductReview;
use App\Http\Modules\Review\Domain\Service\Repository\ProductReviewRepositoryInterface;
use Exception;

class ProductReviewService
{
    public function __construct(
        private ProductReviewRepositoryInterface $product_review_repository
    ) {}

    public function indexProductReview(IndexProductReviewRequest $request)
    {
        return $this->product_review_repository->index($request->getProductId());
    }
    
    public function createProductReview(CreateProductReviewRequest $request)
    {
        $product_review = new ProductReview(null,
            $request->getRating(),
            $request->getReview(),
            $request->getUserId(),
            $request->getProductId()
        );

        $this->product_review_repository->persist($product_review);

    }

    public function updateProductReview(UpdateProductReviewRequest $request)
    {
        if(!$this->product_review_repository->getById($request->getId())->toArray())
        {
            throw new Exception('Not found.');
        }

        $product_review = new ProductReview(
            $request->getId(),
            $request->getRating(),
            $request->getReview(),
            $request->getUserId(),
            $request->getProductId()
        );

        $this->product_review_repository->persist($product_review);
    }

    public function deleteProductReview(int $product_review_id)
    {
        if(!$this->product_review_repository->getById($product_review_id)->toArray())
        {
            throw new Exception('Not found.');
        }

        $this->product_review_repository->deleteById($product_review_id);
    }
}