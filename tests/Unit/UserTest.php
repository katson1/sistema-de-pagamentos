<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateSingleUser(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    public function testCreateMultipleUsers(): void
    {
        $users = User::factory()->count(5)->create();
        $this->assertEquals(5, count($users));
    }

    public function testSpecificUser(): void
    {
        $storeUser = User::factory()->create([
            'user_type' => 'store',
            'balance' => 500.00
        ]);
        $this->assertEquals('store', $storeUser->user_type);
        $this->assertEquals(500.00, $storeUser->balance);
    }
}
