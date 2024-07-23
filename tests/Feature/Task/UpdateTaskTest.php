<?php

namespace Tests\Feature;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;
    protected $task;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->getAuthorizationToken($user);

        $this->task = Task::factory()->create([
            'user_id' => $user->id
        ]);
    }

    public function test_cannot_update_task_without_data(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'));

        $response->assertStatus(422)->assertJsonStructure(['message', 'errors']);
    }

    public function test_cannot_update_task_without_task_id(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'));
        $response->assertStatus(422)
                ->assertJsonStructure(['message', 'errors'])
                ->assertJsonFragment([
                    'task_id' => ['The task id field is required.']
                ]);
    }

    public function test_cannot_update_task_with_invalid_task_id(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'),[
            'task_id' => 'invalid-id',
        ]);
        $response->assertStatus(422)
                ->assertJsonStructure(['message', 'errors'])
                ->assertJsonFragment(['task_id' => ['The selected task id is invalid.']]);
    }

    public function test_cannot_update_task_with_null_name(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'), [
            'task_id' => $this->task->id,
            'name' => null,
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'name' => ['The name field is required.']
            ]);
    }

    public function test_cannot_update_task_with_invalid_name(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'), [
            'task_id' => $this->task->id,
            'name' => ['null'],
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'name' => ['The name field must be a string.']
            ]);
    }

    public function test_can_update_task_without_description(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'), [
            'task_id' => $this->task->id,
            'name' => fake()->words(4, true),
        ]);

        $response->assertOk()
            ->assertJsonStructure(['message', 'success'])
            ->assertJsonFragment([
                'message' => 'Task updated successfully'
            ]);
    }

    public function test_can_update_task_with_description(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'), [
            'task_id' => $this->task->id,
            'name' => fake()->words(4, true),
            'description' => fake()->sentence(),
        ]);

        $response->assertOk()
            ->assertJsonStructure(['message', 'success'])
            ->assertJsonFragment([
                'message' => 'Task updated successfully'
            ]);
    }

    public function test_cannot_update_task_with_invalid_status(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'), [
            'task_id' => $this->task->id,
            'name' => fake()->words(4, true),
            'description' => fake()->sentence(),
            'status' => fake()->word(),
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'status' => ['The selected status is invalid.']
            ]);
    }

    public function test_can_update_task_with_valid_status(): void
    {
        $response = $this->jsonWithHeaders('PATCH', route('task.update'), [
            'task_id' => $this->task->id,
            'name' => fake()->words(4, true),
            'description' => fake()->sentence(),
            'status' => TaskStatusEnum::COMPLETED->value,
        ]);

        $response->assertOk()
            ->assertJsonStructure(['message', 'success'])
            ->assertJsonFragment([
                'message' => 'Task updated successfully'
            ]);
    }
}
