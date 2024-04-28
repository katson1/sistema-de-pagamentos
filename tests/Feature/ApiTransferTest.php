<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

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
        $response->assertStatus(404);
        $response->assertJsonValidationErrors(['amount']);

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
        $response->assertJson(['error' => 'Sender cannot send money.']);

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
        $response->assertJson(['error' => 'Sender does not have enough balance.']);

        $userCommonUpdated = User::find($userCommon->id);
        $userStoreUpdated = User::find($userStore->id);
        $this->assertEquals($userCommon->balance, $userCommonUpdated->balance);
        $this->assertEquals($userStore->balance, $userStoreUpdated->balance);
    }
}
