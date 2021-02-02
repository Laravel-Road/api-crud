<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TokenTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function tokenStore()
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->json('POST', route('tokens.store'), [
            'device' => 'test',
        ]);

        // Assert
        $response
            ->assertOk()
            ->assertJsonStructure(['token']);
    }

    /**
     * @test
     */
    public function tokenDestroy()
    {
        // Arrange
        Sanctum::actingAs($user = User::factory()->create());
        $token = $user->createToken('test');

        // Act
        $response = $this->json('DELETE', route('tokens.destroy', $token->accessToken->id));

        // Assert
        $response->assertNoContent();
    }
}
