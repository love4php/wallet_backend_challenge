<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Repository\Transaction\TransactionRepository;
use App\Repository\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\Response;

class TransactionController extends Controller
{

    public function __construct(private TransactionRepositoryInterface $transactionRepository)
    {
    }

    public function addMoney(TransactionRequest $request){

        try{
            $transactionResult = $this->transactionRepository->create($request->only(['user_id', 'amount']));
            if($transactionResult){
                return Response::success('success transaction',[
                    'reference_id' => $transactionResult
                ], Response::HTTP_CREATED );
            }else{
                return Response::failed(implode(", ",$this->transactionRepository->getErrors()));
            }
        }catch (\Exception $e){
            return Response::failed($e->getMessage());
        }

    }

}
