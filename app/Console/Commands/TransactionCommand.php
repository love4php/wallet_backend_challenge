<?php

namespace App\Console\Commands;

use App\Repository\Transaction\TransactionRepository;
use Illuminate\Console\Command;
use \App\Models\Transaction as TransactionModel;
class TransactionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:total {--type=} {--from=} {--to=} {--user-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate total amount of transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected TransactionRepository $transactionRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $options = $this->options();



        $amount = $this->transactionRepository->getTotal([
            'type' => $options['type'] ?? null,
            'from' => $options['from'] ?? null,
            'to' => $options['to'] ?? null,
            'user_id' => $options['user-id'] ?? null,
        ]);

        $this->info('The result of the transactions is as follows');
        $this->info('Count : ' . $amount['count'] );
        $this->info('Total : ' . $amount['final']);
        if(isset($amount[TransactionModel::TYPE_WITHDRAW])){
            $this->info('Total withdraw ' . $amount[TransactionModel::TYPE_WITHDRAW] );
        }
        if(isset($amount[TransactionModel::TYPE_DEPOSIT])){
            $this->info('Total deposit is ' . $amount[TransactionModel::TYPE_DEPOSIT] );
        }


    }
}
