<?php
namespace App\Http\Modules\Review\Application\Service\ProductReview;

class CreateProductReviewRequest
{
    public function __construct(
        private int $rating,
        private ?string $review,
        private int $user_id,
        private int $product_id,
    ) {}

    public function getRating()
    {
        return $this->rating;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }
}