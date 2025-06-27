<?php

namespace Tests\Feature;

use App\Jobs\V1\User\SendEmailActivationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザーの作成(): void
    {
        $response = $this->post('/v1/user/create', [
            'name' => 'Youki Takemoto',
            'email' => 'foo@example.com',
            'password' => '$TestTest123',
        ]);

        $response->assertStatus(200);
    }
}
