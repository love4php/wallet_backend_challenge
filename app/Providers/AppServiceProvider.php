<?php

namespace App\Providers;

use App\Repository\Transaction\TransactionRepository;
use App\Repository\Transaction\TransactionRepositoryInterface;
use App\Repository\Transaction\WalletRepository;
use App\Repository\Transaction\WalletRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
