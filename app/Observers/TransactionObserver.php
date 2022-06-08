<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Repository\Transaction\WalletRepository;
use App\Repository\Transaction\WalletRepositoryInterface;

class TransactionObserver
{

    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $wallet = $transaction->wallet;
        if($transaction->type == Transaction::TYPE_DEPOSIT){
            $wallet->balance += floatval($transaction->amount);
        }else{
            $wallet->balance -= floatval($transaction->amount);
        }

        if(!$wallet->save()){
            throw new  \Exception('can not update wallet');
        }

    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
