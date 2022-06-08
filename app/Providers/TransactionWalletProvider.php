<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Observers\TransactionObserver;
use App\Repository\Transaction\TransactionRepository;
use App\Repository\Transaction\TransactionRepositoryInterface;
use App\Repository\Transaction\WalletRepository;
use App\Repository\Transaction\WalletRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TransactionWalletProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // bind Repository
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Observer
        Transaction::observe(TransactionObserver::class);

        // Response Macro
        Response::macro('success', function($message ='', $data = '', $statusCode = ResponseAlias::HTTP_OK){
            return \response()->json($data, $statusCode);
            /*
            return \response()->json(array_filter([
                'status' => true,
                'message' => $message,
                'data' => $data,
            ]), $statusCode);
             */
        });

        Response::macro('failed', function ($message = '', $data = '', $statusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR){
            return \response()->json(['message' => $message],$statusCode);
            /*
            return  \response()->json(array_filter([
                'status' => false,
                'message' => $message,
                'data' => $data,
            ], function ($field){
                return !empty($field) || ($field === false) ;
            }), $statusCode);
            */
        });
    }
}
