<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\JsonResponse;
use Mockery;

class UserControllerTest extends TestCase
{
    public function test_store_method_catches_exception()
    {
        $userService = Mockery::mock(UserService::class);
        $userService->shouldReceive('createUser')->andThrow(new \Exception('Error message'));

        $request = UserStoreRequest::create('/api/users', 'POST', []);

        $response = $this->app->make('App\Http\Controllers\UserController')
            ->store($request);

        $this->assertEquals(400, $response->status());
        $this->assertJson($response->content());
    }
}