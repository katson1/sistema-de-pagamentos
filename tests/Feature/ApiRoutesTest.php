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

    public function testSuccessfulUserCreation()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'cpf_cnpj' => '12345678901',
            'user_type' => 'common',
            'balance' => 100,
            'password' => 'password123',
        ];

        $response = $this->postJson('/users', $userData);

        $response->assertStatus(201);
        //$response->assertJson($userData);
    }

    public function atestUserCreationWithInvalidData()
    {
        $userData = [
            'name' => '', // dado inválido
            'email' => 'not-an-email',
            'cpf_cnpj' => 'invalid-cpf',
            'user_type' => 'invalid-type',
            'balance' => -10,
            'password' => 'short',
        ];

        $response = $this->postJson('/users', $userData);

        $response->assertStatus(404);
        $response->assertJsonValidationErrors(['name', 'email', 'cpf_cnpj', 'user_type', 'balance', 'password']);
    }
}
