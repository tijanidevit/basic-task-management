<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToggleTaskStatusTest extends TestCase
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

    public function test_cannot_toggle_task_status_with_invalid_id(): void
    {
        $response = $this->jsonWithHeaders('post', route('task.toggleStatus', 'invalid-id'));

        $response->assertNotFound()
                ->assertJsonStructure(['message', 'success'])
                ->assertJson(['message' => 'Task not found']);
    }

    public function test_can_toggle_task_status_with_valid_id(): void
    {
        $taskId = $this->task->id;
        $response = $this->jsonWithHeaders('post', route('task.toggleStatus', $taskId));

        $response->assertOk()
                ->assertJsonStructure(['message', 'success'])
                ->assertJson(['message' => 'Task status toggled successfully']);
    }
}
