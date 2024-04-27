<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_route_works(): void
    {
        $response = $this->get('/api');
        $response->assertStatus(200);
    }

    public function test_successful_user_creation()
    {
        $response = $this->postJson('/users', $this->userData());
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'email', 'name', 'cpf_cnpj', 'user_type', 'balance', 'created_at', 'updated_at', 'id'
        ]);
    }

    public function test_user_creation_with_invalid_data()
    {
        $userData = $this->userData([
            'name' => '', // Inválido porque não está vazio
            'email' => 'not-an-email', // Inválido porque não é email valido
            'cpf_cnpj' => 'invalid-cpf-cnpj', // Inválido porque não é numerico
            'user_type' => 'invalid-type', // Inválido porque é 'common' ou 'store'
            'balance' => 'invalid-balance', // Inválido porque não é numerico
            'password' => 'short', // Inválido porque é muito curto
        ]);

        $response = $this->postJson('/users', $userData);
        $response->assertStatus(404);
        $response->assertJsonValidationErrors(['name', 'email', 'cpf_cnpj', 'user_type', 'balance', 'password']);
    }

    public function test_user_creation_with_invalid_ranges_data()
    {
        $userData = $this->userData([
            'cpf_cnpj' => '123', // Inválido porque é muito curto
            'balance' => -12, // Inválido porque é negativo
        ]);

        $response = $this->postJson('/users', $userData);
        $response->assertStatus(404);
        $response->assertJsonValidationErrors(['cpf_cnpj', 'balance']);
    }

    //Func para reutilizar o userData nos testes
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
}