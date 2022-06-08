<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class WalletTransactionTest extends TestCase
{


    public function test_required_params(){
        $response = $this->post('/api/add-money', [
            "amount" => 5000.00
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_validate_params(){
        $response = $this->post('/api/add-money', [
            'user_id' => 'string',
            "amount" => 5000.00
        ]);
        $response->assertExactJson([
            'user_id' => ["The user id must be an integer."],
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }



    public function test_add_money(){
        $response = $this->post('/api/add-money', [
            "user_id" => 1,
            "amount" => 5000.00
        ]);

        $response->assertJsonStructure([
            'reference_id'
        ])
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function test_wallet_not_found(){

        $response = $this->get('/api/get-balance/999999999999');

        $response->assertExactJson([
            'message' => 'wallet not found'
        ])->assertStatus(Response::HTTP_NOT_FOUND);

    }

    public function test_get_balance(){

        $user_id = rand(1, 100);
        $amount = rand(500, 5000);

        $this->post('/api/add-money', [
            "user_id" => $user_id,
            "amount" => $amount
        ]);

        $response = $this->get('/api/get-balance/'.$user_id);


        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['balance' => $amount]);

    }

    public function test_insufficient_budget(){
        $response = $this->post('/api/add-money', [
            "user_id" => 200,
            "amount" => -50000
        ]);
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->assertExactJson([
                'message' => 'Insufficient budget'
            ]);

    }
}
