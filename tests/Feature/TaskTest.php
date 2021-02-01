<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
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
        Sanctum::actingAs(User::factory()->create());
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
        Sanctum::actingAs(User::factory()->create());
        $taskFake = Task::factory()->make();

        // Act
        $response = $this->json('POST', route('tasks.store'), $taskFake->toArray());

        // Assert
        $response->assertCreated();
        $this->assertDatabaseHas('tasks', $taskFake->getAttributes());
    }

    /**
     * @test
     */
    public function taskShow()
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $task = Task::factory()->create();

        // Act
        $response = $this->json('GET', route('tasks.show', $task));

        // Assert
        $response
            ->assertOk()
            ->assertJsonPath('data.name', $task->name);
    }

    /**
     * @test
     */
    public function taskUpdate()
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $taskFake = Task::factory()->make();

        // Act
        $response = $this->json('PUT', route('tasks.update', $task), $taskFake->toArray());

        // Assert
        $response->assertOk();
        $this->assertDatabaseHas('tasks', $taskFake->getAttributes());
    }

    /**
     * @test
     */
    public function taskDestroy()
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $task = Task::factory()->create();

        // Act
        $response = $this->json('DELETE', route('tasks.destroy', $task));

        // Assert
        $response->assertNoContent();
        $this->assertDatabaseMissing('tasks', $task->getAttributes());
    }
}
