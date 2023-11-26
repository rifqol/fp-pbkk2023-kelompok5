<?php
namespace App\Http\Modules\Review\Application\Service\ProductReview;

class IndexProductReviewRequest
{
    public function __construct(
        private ?int $product_id,
    ) {}

    public function getProductId()
    {
        return $this->product_id;
    }
}
