<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_task_can_be_created(): void
    {
        $response = $this->post('/tasks', [
            'title' => 'Plan tomorrow',
            'description' => 'Review the calendar',
            'status' => 'pending',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['title' => 'Plan tomorrow', 'status' => 'pending']);
    }

    public function test_a_task_can_be_updated_and_completed(): void
    {
        $task = Task::create(['title' => 'Draft notes', 'description' => null, 'status' => 'pending']);

        $this->put("/tasks/{$task->id}", [
            'title' => 'Draft final notes',
            'description' => 'Include the summary',
            'status' => 'pending',
        ])->assertRedirect('/tasks');

        $this->patch("/tasks/{$task->id}/toggle")->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Draft final notes', 'status' => 'completed']);
    }

    public function test_a_task_can_be_deleted(): void
    {
        $task = Task::create(['title' => 'Temporary task', 'description' => null, 'status' => 'pending']);

        $this->delete("/tasks/{$task->id}")->assertRedirect('/tasks');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}