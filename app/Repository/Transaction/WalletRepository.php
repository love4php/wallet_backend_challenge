<?php

namespace App\Repository\Transaction;

use App\Models\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    public function getOrCreate($user_id){
        return Wallet::firstOrCreate(['user_id' => $user_id]);
    }

    public function getUserBalance(int $user_id): float
    {
        $wallet = Wallet::where('user_id', $user_id)->first();
        if ($wallet == null) {
            return false;
        }
        return floatval($wallet->balance);
    }

    public function updateBalance(Wallet $wallet, float|int $amount) : bool
    {
        $wallet->balance += floatval($amount);
        return $wallet->save();
    }

    public function create(array $walletDetails)
    {
        $wallet = Wallet::create([
            'user_id' => $walletDetails['user_id'],
            'balance' => $walletDetails['balance'] ?? 0,
        ]);
        return $wallet;
    }

}
