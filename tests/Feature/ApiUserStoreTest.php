<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Constants\StringConstants;

class ApiUserStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testApiRouteWorks(): void
    {
        $response = $this->get('/api');
        $response->assertStatus(200);
    }

    public function testSuccessfulUserCreation()
    {
        $response = $this->postJson('/api/users', $this->userData());
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'email', 'name', 'cpf_cnpj', 'user_type', 'balance', 'created_at', 'updated_at', 'id'
        ]);
    }

    public function testUserCreationWithInvalidData()
    {
        $userData = $this->userData([
            'name' => '', // Inválido porque não está vazio
            'email' => 'not-an-email', // Inválido porque não é email valido
            'cpf_cnpj' => 'invalid-cpf-cnpj', // Inválido porque não é numerico
            'user_type' => 'invalid-type', // Inválido porque é 'common' ou 'store'
            'balance' => 'invalid-balance', // Inválido porque não é numerico
            'password' => 'short', // Inválido porque é muito curto
        ]);

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(400);
        $response->assertJson(['message' => StringConstants::INVALID_DATA_GIVEN]);
        // Testando se os erros para cada campo é passado corretamente usando o arquivo de constantes
        $response->assertJsonFragment([StringConstants::NAME_REQUIRED]);
        $response->assertJsonFragment([StringConstants::EMAIL_EMAIL]);
        $response->assertJsonFragment([StringConstants::CPF_CNPJ_NUMERIC]);
        $response->assertJsonFragment([StringConstants::CPF_CNPJ_DIGITS_BETWEEN]);
        $response->assertJsonFragment([StringConstants::USER_TYPE_IN]);
        $response->assertJsonFragment([StringConstants::BALANCE_NUMERIC]);
        $response->assertJsonFragment([StringConstants::PASSWORD_MIN]);
        $response->assertJsonValidationErrors(['name', 'email', 'cpf_cnpj', 'user_type', 'balance', 'password']);
    }

    public function testUserCreationWithInvalidRangesData()
    {
        $userData = $this->userData([
            'cpf_cnpj' => '123', // Inválido porque é muito curto
            'balance' => -12, // Inválido porque é negativo
        ]);

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(400);
        $response->assertJson(['message' => StringConstants::INVALID_DATA_GIVEN]);
        // Testando se os erros para cada campo é passado corretamente usando o arquivo de constantes
        $response->assertJsonFragment([StringConstants::CPF_CNPJ_DIGITS_BETWEEN]);
        $response->assertJsonFragment([StringConstants::BALANCE_MIN]);
        $response->assertJsonValidationErrors(['cpf_cnpj', 'balance']);
    }

    public function testUserCreationWithDuplicateEmailAndCpfCnpj()
    {
        $userData = $this->userData([
            'email' => 'duplicate@test.com',
            'cpf_cnpj' => '99999999999',
        ]);

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(201); // Espera sucesso na primeira criação

        // Segunda criação com o mesmo email e CPF/CNPJ
        $secondUserData = $this->userData([
            'email' => 'duplicate@test.com',
            'cpf_cnpj' => '99999999999',
        ]);

        $secondResponse = $this->postJson('/api/users', $secondUserData);
        $secondResponse->assertStatus(400); // Espera falha devido a duplicidade
        $secondResponse->assertJson(['message' => StringConstants::INVALID_DATA_GIVEN]);
        // Testando se os erros para cada campo é passado corretamente usando o arquivo de constantes
        $secondResponse->assertJsonFragment([StringConstants::EMAIL_UNIQUE]);
        $secondResponse->assertJsonFragment([StringConstants::CPF_CNPJ_UNIQUE]);
        $secondResponse->assertJsonValidationErrors(['email', 'cpf_cnpj']);
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
