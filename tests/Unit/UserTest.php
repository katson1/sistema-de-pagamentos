<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_random_users(): void
    {
        $users = User::factory()->count(5)->create();
        $this->assertEquals(5, count($users));
    }

    public function test_specific_user(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'cpf_cnpj' => $user->cpf_cnpj,
            'user_type' => $user->user_type,
            'balance' => $user->balance,
            'password' => $user->password,
        ]);
    }

    public function test_user_type_must_be_either_common_or_store()
    {
        $this->expectException(QueryException::class);

        $user = User::factory()->make([
            'user_type' => 'invalid_type'
        ]);
        $user->save();
        $user->user_type = 'common';
        
        $this->assertTrue($user->save());
    }

    public function test_user_email_and_cpf_cnpj_must_be_unique()
    {
        $this->expectException(QueryException::class);

        $user1 = User::factory()->create();

        $user2 = User::factory()->make([
            'email' => $user1->email,
            'cpf_cnpj' => $user1->cpf_cnpj
        ]);
    
        $user2->save();
    }

    public function test_user_required_attribute()
    {
        $this->expectException(QueryException::class);

        $user = User::factory()->make([
            'name' => null,
            'email' => null,
            'cpf_cnpj' => null,
            'user_type' => null,
            'balance' => null,
            'password' => null,
        ]);

        $user->save();
    }

}
