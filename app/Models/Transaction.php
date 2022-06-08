<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public const TYPE_DEPOSIT = 'deposit';
    public const TYPE_WITHDRAW = 'withdraw';

    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'reference_id',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

}
