<?php

namespace App\Repository\Transaction;

use App\Models\Wallet;

interface WalletRepositoryInterface
{

    public function getOrCreate(int $user_id);
    public function create(array $walletDetails);
    public function getUserBalance(int $user_id);
    public function updateBalance(Wallet $wallet, int|float $amount);
}
