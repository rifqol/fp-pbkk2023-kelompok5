<?php
namespace App\Http\Modules\Review\Infrastructure\Service;

use App\Http\Modules\Review\Domain\Models\ProductReview;
use App\Http\Modules\Review\Domain\Service\Repository\ProductReviewRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductReviewRepository implements ProductReviewRepositoryInterface
{
    public function persist(ProductReview $product_review)
    {
        $data = $this->createPayload($product_review);

        if($product_review->getId() && DB::table('product_reviews')->where('id', $product_review->getId()))
        {
            $data['updated_at'] = Carbon::now();
        } 
        else
        {
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
        }

        DB::table('product_reviews')->upsert($data, 'id');
    }

    public function getById(int $product_review_id)
    {
        return DB::table('product_reviews')->where('id', $product_review_id)->get();
    }

    public function deleteById(int $product_review_id)
    {
        DB::table('product_reviews')->where('id', $product_review_id)->delete();
    }

    public function createPayload(ProductReview $product_review)
    {
        return [
            'id' => $product_review->getId(),
            'rating' => $product_review->getRating(),
            'review' => $product_review->getReview(),
            'user_id' => $product_review->getUserId(),
            'product_id' => $product_review->getProductId(),
        ];
    }
}