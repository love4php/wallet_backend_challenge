<?php

namespace App\Repository\Transaction;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function __construct(Transaction $transaction);
    public function create(array $transactionDetails) : string|bool;
    public function getErrors():array;
    public function getTotal(array $filter):array;

}
