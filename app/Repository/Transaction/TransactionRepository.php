<?php

namespace App\Repository\Transaction;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class TransactionRepository implements TransactionRepositoryInterface
{
    protected array $_message = [];

    public function __construct(
        private Transaction $transaction
    ) {
    }

    /**
     *
     * @throws \Exception
     */
    public function create(array $transactionDetails): string|bool
    {

        // begin transaction
        DB::beginTransaction();

        // Wallet Repository
        $walletRepository = new WalletRepository();
        $wallet = $walletRepository->getOrCreate($transactionDetails['user_id']);
        $referenceId = $this->getUUID();
        try {
            $amount = floatval($transactionDetails['amount']);
            if((float) $wallet->balance + $amount < 0){
                $this->_message[] = 'Insufficient budget';
                return false;
            }

             Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => ($amount > 0) ? Transaction::TYPE_DEPOSIT : Transaction::TYPE_WITHDRAW,
                'amount' => abs($amount),
                'reference_id' => $referenceId
            ]);


            // Update Wallet Balance Without Observer
            //$saved = $walletRepository->updateBalance($wallet, $amount);
            //if(!$saved){
            //    throw new \Exception('Can not update wallet !');
            //}

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return $referenceId;

    }

    private function getUUID(){
        return Uuid::uuid4()->toString();
    }

    /**
     * @param $filter
     * @return Builder
     */
    private function getQuery($filter) : Builder {

        $query = $this->transaction->newQuery();
        if(isset($filter['from']) && !empty($filter['from'])) {
            $query->where('created_at', '>=', $filter['from']);
        }
        if(isset($filter['to']) && !empty($filter['to'])) {
            $query->where('created_at', '<=', $filter['to']);
        }
        if(isset($filter['type']) && !empty($filter['type'])) {
            $query->where('type', $filter['type']);
        }


        if(isset($filter['user_id']) && !empty($filter['user_id'])) {
            $query
                ->join('wallets', 'wallets.id', '=', 'transactions.wallet_id')
                ->where('user_id', $filter['user_id']);

        }

        return $query;
    }

    /**
     * @param array $filter
     * @return array
     */
    public function getTotal(array $filter) : array{
        $query = $this->getQuery($filter);
        $countQuery = clone $query;
        $q = $query->groupBy('type')
            ->select([
                DB::raw('sum(amount) as sum'),
                'type'
            ]);

        $sums = $q->get();
        $total = $sums->pluck('sum', 'type')->all();
        $total['total'] = array_sum($total);
        $total['final'] = ($total[Transaction::TYPE_DEPOSIT]??0) - ($total[Transaction::TYPE_WITHDRAW]??0);
        $total['count'] = $countQuery->count();

        return $total;

    }

    /**
     * get errors during process
     * @return array
     */
    public function getErrors() : array
    {
        return $this->_message;
    }
}
