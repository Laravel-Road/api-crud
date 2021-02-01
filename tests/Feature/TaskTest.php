<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function taskIndex()
    {
        // Arrange
        Task::factory($total = $this->faker->numberBetween(15, 50))->create();

        // Act
        $response = $this->json('GET', route('tasks.index'));

        // Assert
        $response
            ->assertOk()
            ->assertJsonPath('meta.total', $total);
    }

    /**
     * @test
     */
    public function taskStore()
    {
        // Arrange

        // Act

        // Assert
    }

    /**
     * @test
     */
    public function taskUpdate()
    {
        // Arrange

        // Act

        // Assert
    }

    /**
     * @test
     */
    public function taskDestroy()
    {
        // Arrange

        // Act

        // Assert
    }
}
