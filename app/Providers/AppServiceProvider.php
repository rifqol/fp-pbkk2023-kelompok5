<?php

namespace App\Providers;

use App\Http\Modules\Review\Domain\Service\Repository\ProductReviewRepositoryInterface;
use App\Http\Modules\Review\Infrastructure\Service\ProductReviewRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ProductReviewRepositoryInterface::class, ProductReviewRepository::class);
    }
}
