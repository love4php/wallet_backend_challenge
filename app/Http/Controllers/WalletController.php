<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\WalletRequest;
use App\Repository\Transaction\WalletRepositoryInterface;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    public function __construct(private WalletRepositoryInterface $walletRepository)
    {
    }

    public function getBalance(int $user_id){

        try{
            $balance = $this->walletRepository->getUserBalance($user_id);
            if($balance){
                return Response::success('', [
                    'balance' => $balance
                ]);
            }else{
                return Response::failed('wallet not found', [], Response::HTTP_NOT_FOUND);
            }
        }catch (\Exception $e){
            return Response::failed($e->getMessage());
        }
    }
}
