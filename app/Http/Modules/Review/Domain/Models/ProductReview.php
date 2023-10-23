<?php
namespace App\Http\Modules\Review\Domain\Models;

class ProductReview
{
    public function __construct(
        private ?int $id,
        private int $rating,
        private ?string $review,
        private int $user_id,
        private int $product_id,
    ) {}

    public function getId()
    {
        return $this->id;
    }

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
