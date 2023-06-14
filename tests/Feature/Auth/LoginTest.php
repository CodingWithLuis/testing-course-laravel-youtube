<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->from('/login')
            ->post('/login', [
                'email' => 'admin@admin.com',
                'password' => 'password'
            ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('home'));
    }
}
