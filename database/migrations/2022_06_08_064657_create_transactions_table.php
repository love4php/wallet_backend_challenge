<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->engine = "InnoDB"; // engine for transaction support

            $table->bigIncrements('id')->unsigned();
            $table->integer('wallet_id')->unsigned();
            $table->decimal('amount',9,3);
            $table->enum('type', ['deposit', 'withdraw']);
            $table->uuid('reference_id');
            $table->timestamps();

            // Relations
            $table->foreign('wallet_id')->references('id')->on('wallets');

            // Index
            /**
             * @todo define index fields
             * attention with query and searches
             * I suggest define this indexes : (type, wallet_id)
             */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
