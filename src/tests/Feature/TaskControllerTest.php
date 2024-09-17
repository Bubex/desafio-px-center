<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /**
     * Test list tasks endpoint.
     *
     * @return void
     */
    public function test_list_tasks()
    {
        $response = $this->get('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'status', 'deadline']
            ]);
    }

    /**
     * Test show task endpoint.
     *
     * @return void
     */
    public function test_show_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'status',
                'deadline',
                'priority',
                'description',
                'created_at'
            ]);
    }

    /**
     * Test create task endpoint.
     *
     * @return void
     */
    public function test_create_task()
    {
        $response = $this->post('/api/tasks', [
            'title' => 'New Task',
            'status' => 'Pendente',
            'deadline' => '2024-12-31',
            'priority' => 'Alta',
            'description' => 'Task description',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => 'New Task',
            ]);
    }

    /**
     * Test update task endpoint.
     *
     * @return void
     */
    public function test_update_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->put("/api/tasks/{$task->id}", [
            'title' => 'Updated Task',
            'status' => 'Em Andamento',
            'deadline' => '2024-12-31',
            'priority' => 'Média',
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Updated Task',
            ]);
    }

    /**
     * Test complete task endpoint.
     *
     * @return void
     */
    public function test_complete_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->put("/api/tasks/{$task->id}/complete");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'Concluída',
            ]);
    }

    /**
     * Test delete task endpoint.
     *
     * @return void
     */
    public function test_delete_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete("/api/tasks/{$task->id}");

        $response->assertStatus(204);
    }
}
