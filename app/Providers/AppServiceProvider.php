<?php

namespace App\Providers;

use App\Repositories\Entry\EntryRepository;
use App\Repositories\Entry\EntryRepositoryInterface;
use App\Repositories\Output\OutputRepository;
use App\Repositories\Output\OutputRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(EntryRepositoryInterface::class, EntryRepository::class);
        $this->app->bind(OutputRepositoryInterface::class, OutputRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
