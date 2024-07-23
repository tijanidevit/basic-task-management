<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->getAuthorizationToken($user);
    }

    public function test_cannot_create_task_without_data(): void
    {
        $response = $this->jsonWithHeaders('POST', route('task.store'));

        $response->assertStatus(422)->assertJsonStructure(['message', 'errors']);
    }

    public function test_cannot_create_task_with_null_value(): void
    {
        $response = $this->jsonWithHeaders('POST', route('task.store'), [
            'name' => null,
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'name' => ['The name field is required.']
            ]);
    }

    public function test_cannot_create_task_with_invalid_name(): void
    {
        $response = $this->jsonWithHeaders('POST', route('task.store'), [
            'name' => ['null'],
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'name' => ['The name field must be a string.']
            ]);
    }

    public function test_can_create_task_without_description(): void
    {
        $response = $this->jsonWithHeaders('POST', route('task.store'), [
            'name' => fake()->words(4, true),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'success', 'data'])
            ->assertJsonFragment([
                'message' => 'Task created successfully'
            ]);
        $this->assertTrue(Task::count() == 1);
    }

    public function test_can_create_task_with_description(): void
    {
        $response = $this->jsonWithHeaders('POST', route('task.store'), [
            'name' => fake()->words(4, true),
            'description' => fake()->sentence(),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'success', 'data'])
            ->assertJsonFragment([
                'message' => 'Task created successfully'
            ]);
        $this->assertTrue(Task::count() == 1);
    }
}
