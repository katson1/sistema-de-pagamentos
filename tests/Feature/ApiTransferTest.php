<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Constants\StringConstants;

class ApiTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_transfer()
    {
        $userCommon = User::factory()->create([
            'user_type' => 'common',
            'balance' => 100
        ]);
        $userStore = User::factory()->create([
            'email' => 'teste2@teste.com',
            'cpf_cnpj' => '10987654321',
            'user_type' => 'store',
            'balance' => 100
        ]);

        $transferData = [
            "id_sender" => $userCommon->id,
            "id_receiver" => $userStore->id,
            "amount" => 100
        ];

        $response = $this->postJson('/api/transfer', $transferData);
        $response->assertStatus(200);

        // testando se o 'balance' dos 'users' foram atualizados corretamente
        $userCommonUpdated = User::find($userCommon->id);
        $userStoreUpdated = User::find($userStore->id);
        $this->assertEquals(0, $userCommonUpdated->balance);
        $this->assertEquals(200, $userStoreUpdated->balance);
    }

    public function test_fail_transfer_amount_less_than_001()
    {
        $userCommon = User::factory()->create([
            'user_type' => 'common',
            'balance' => 0
        ]);
        $userStore = User::factory()->create([
            'email' => 'teste2@teste.com',
            'cpf_cnpj' => '10987654321',
            'user_type' => 'store'
        ]);

        $transferData = [
            "id_sender" => $userCommon->id,
            "id_receiver" => $userStore->id,
            "amount" => 0
        ];

        $response = $this->postJson('/api/transfer', $transferData);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['amount']);
        $response->assertJson(['message' => StringConstants::INVALID_DATA_GIVEN]);
        $response->assertJsonFragment([StringConstants::AMOUNT_MIN]);

        // testando se o 'balance' dos 'users' se manteve o mesmo
        $userCommonUpdated = User::find($userCommon->id);
        $userStoreUpdated = User::find($userStore->id);
        $this->assertEquals($userCommon->balance, $userCommonUpdated->balance);
        $this->assertEquals($userStore->balance, $userStoreUpdated->balance);
    }

    public function test_fail_transfer_store_trying_to_send()
    {
        $userCommon = User::factory()->create([
            'user_type' => 'common'
        ]);
        $userStore = User::factory()->create([
            'email' => 'teste2@teste.com',
            'cpf_cnpj' => '10987654321',
            'user_type' => 'store'
        ]);

        $transferData = [
            "id_sender" => $userStore->id,
            "id_receiver" => $userCommon->id,
            "amount" => 100
        ];

        $response = $this->postJson('/api/transfer', $transferData);
        $response->assertStatus(400);
        $response->assertJson(['error' => StringConstants::SENDER_CANNOT_SEND]);

        // testando se o 'balance' dos 'users' se manteve o mesmo
        $userCommonUpdated = User::find($userCommon->id);
        $userStoreUpdated = User::find($userStore->id);
        $this->assertEquals($userCommon->balance, $userCommonUpdated->balance);
        $this->assertEquals($userStore->balance, $userStoreUpdated->balance);
    }

    public function test_fail_transfer_not_have_enough_balance()
    {
        $userCommon = User::factory()->create([
            'user_type' => 'common',
            'balance' => 0
        ]);
        $userStore = User::factory()->create([
            'email' => 'teste2@teste.com',
            'cpf_cnpj' => '10987654321',
            'user_type' => 'store'
        ]);

        $transferData = [
            "id_sender" => $userCommon->id,
            "id_receiver" => $userStore->id,
            "amount" => 100
        ];

        $response = $this->postJson('/api/transfer', $transferData);
        $response->assertStatus(400);
        $response->assertJson(['error' => StringConstants::INSUFFICIENT_BALANCE]);

        // testando se o 'balance' dos 'users' se manteve o mesmo
        $userCommonUpdated = User::find($userCommon->id);
        $userStoreUpdated = User::find($userStore->id);
        $this->assertEquals($userCommon->balance, $userCommonUpdated->balance);
        $this->assertEquals($userStore->balance, $userStoreUpdated->balance);
    }

    public function test_fail_transfer_same_sender_and_receiver()
    {
        $userCommon = User::factory()->create([
            'user_type' => 'common',
            'balance' => 100
        ]);

        $transferData = [
            "id_sender" => $userCommon->id,
            "id_receiver" => $userCommon->id,
            "amount" => 100
        ];

        $response = $this->postJson('/api/transfer', $transferData);
        $response->assertStatus(400);
        $response->assertJson(['error' => StringConstants::SAME_SENDER_RECEIVER]);

        // testando se o 'balance' do 'user' se manteve o mesmo
        $userCommonUpdated = User::find($userCommon->id);
        $this->assertEquals($userCommon->balance, $userCommonUpdated->balance);
    }
}
