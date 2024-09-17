<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user login.
     *
     * @return void
     */
    public function test_login()
    {
        // Criar um usuário para teste
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        // Tentar autenticar o usuário
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Verificar se o token é retornado
        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user' => ['id', 'name', 'email'],
            ]);
    }
}
