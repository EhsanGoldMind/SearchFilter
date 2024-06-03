<?php

namespace App\Providers;

use App\Http\repository\OrderRepository;
use App\Http\repository\RepositoryInterface\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }
}
