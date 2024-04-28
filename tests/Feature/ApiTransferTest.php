<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User; // Certifique-se de importar o modelo User, se estiver usando Eloquent.

class ApiTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_transfer()
    {
        //criar teste
    }

    private function userData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Katson Teste',
            'email' => 'teste@teste.com',
            'cpf_cnpj' => '12345678901',
            'user_type' => 'common',
            'balance' => 100,
            'password' => 'password123',
        ], $overrides);
    }

    private function createUser(array $overrides = []): User
    {
        $userData = $this->userData($overrides);
        $response = $this->postJson('/users', $userData);
        $response->assertStatus(201);
        return User::find($response->json('id'));
    }
}
