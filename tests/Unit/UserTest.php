<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_single_user(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    public function test_create_multiple_users(): void
    {
        $users = User::factory()->count(5)->create();
        $this->assertEquals(5, count($users));
    }

    public function test_specific_user(): void
    {
        $storeUser = User::factory()->create([
            'user_type' => 'store',
            'balance' => 500.00
        ]);
        $this->assertEquals('store', $storeUser->user_type);
        $this->assertEquals(500.00, $storeUser->balance);
    }
}
