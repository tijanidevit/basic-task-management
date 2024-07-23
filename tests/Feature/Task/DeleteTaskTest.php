<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
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

    public function test_cannot_delete_single_task_with_invalid_id(): void
    {
        $response = $this->jsonWithHeaders('delete', route('task.show', 'invalid-id'));

        $response->assertNotFound()
                ->assertJsonStructure(['message', 'success'])
                ->assertJson(['message' => 'Task not found']);
    }

    public function test_can_delete_single_task_with_valid_id(): void
    {
        $taskId = $this->task->id;
        $response = $this->jsonWithHeaders('delete', route('task.show', $taskId));

        $response->assertOk()
                ->assertJsonStructure(['message', 'success'])
                ->assertJson(['message' => 'Task deleted successfully']);

        $this->assertTrue(Task::count() == 0);
    }
}
