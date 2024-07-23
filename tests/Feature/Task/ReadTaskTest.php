<?php

namespace Tests\Feature;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadTaskTest extends TestCase
{
    use RefreshDatabase;
    protected $tasks;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->getAuthorizationToken($user);

        $this->tasks = Task::factory(5)->create([
            'user_id' => $user->id
        ]);
    }

    public function test_can_view_all_tasks_without_filters(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.index'));
        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'success', 'data'])
                ->assertJsonCount(5, 'data');

    }

    public function test_all_tasks_with_invalid_name_search_returns_empty_data(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.index'),[
            'name' => 'DefNotVal9'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'success', 'data'])
                ->assertJsonCount(0, 'data');
    }

    public function test_can_view_all_tasks_with_name_search(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.index'),[
            'name' => $this->tasks->first()->name
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'success', 'data']);

        $this->assertGreaterThanOrEqual(1, count($response['data']));
    }


    public function test_all_tasks_with_invalid_status_filter_returns_empty_data(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.index'),[
            'status' => 'wrong'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'success', 'data'])
                ->assertJsonCount(0, 'data');
    }

    public function test_can_view_all_tasks_with_status_filter(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.index'),[
            'status' => TaskStatusEnum::PENDING->value
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'success', 'data'])
                ->assertJsonCount(5, 'data');
    }

    public function test_all_tasks_with_invalid_date_filter_returns_empty_data(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.index'),[
            'from_date' => '2024-07-20',
            'to_date' => '2024-07-20',
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'success', 'data'])
                ->assertJsonCount(0, 'data');
    }

    public function test_can_view_all_tasks_with_date_filter(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.index'),[
            'from_date' => today(),
            'to_date' => today(),
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'success', 'data'])
                ->assertJsonCount(5, 'data');
    }

    public function test_can_view_all_tasks_with_limit_filter(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.index'),[
            'limit' => 2
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'success', 'data'])
                ->assertJsonCount(2, 'data');
    }

    public function test_cannot_view_single_task_with_invalid_id(): void
    {
        $response = $this->jsonWithHeaders('GET', route('task.show', 'invalid-id'));

        $response->assertNotFound()
                ->assertJsonStructure(['message', 'success'])
                ->assertJson(['message' => 'Task not found']);
    }

    public function test_can_view_single_task_with_valid_id(): void
    {
        $taskId = $this->tasks->first()->id;
        $response = $this->jsonWithHeaders('GET', route('task.show', $taskId));

        $response->assertOk()
                ->assertJsonStructure(['message', 'success', 'data']);
    }
}
