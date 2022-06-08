<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {

            $table->engine = "InnoDB"; // engine for transaction support

            $table->id()->unsigned(); // can use bigint
            $table->integer('user_id')->unsigned();
            $table->decimal('balance',9,3)->default(0);
            $table->timestamps();

            // Relations
            $table->foreign('user_id')->references('id')->on('users');

            // Index
            /**
             * @todo define index fields
             * attention with query and searches
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
        Schema::dropIfExists('wallets');
    }
}
