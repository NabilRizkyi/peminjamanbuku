<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Book\BookInterface;
use App\Services\Book\BookService;
use App\Services\Borrowing\BorrowingInterface;
use App\Services\Borrowing\BorrowingService;

class ServiceRegistryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookInterface::class, BookService::class);
        $this->app->bind(BorrowingInterface::class, BorrowingService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
