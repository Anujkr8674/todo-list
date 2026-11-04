<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_dashboard_with_stats(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create(['user_id' => $user->id, 'status' => 'pending']);
        Todo::factory()->create(['user_id' => $user->id, 'status' => 'in_progress']);
        Todo::factory()->create(['user_id' => $user->id, 'status' => 'completed']);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Welcome back, ' . $user->name);
        $response->assertViewHas('stats', [
            'total' => 3,
            'pending' => 1,
            'in_progress' => 1,
            'completed' => 1,
        ]);
    }

    public function test_user_can_create_a_todo(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('todos.store'), [
            'title' => 'Buy groceries',
            'description' => 'Milk, Eggs, Bread',
            'priority' => 'high',
            'status' => 'pending',
            'due_date' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('todos', [
            'user_id' => $user->id,
            'title' => 'Buy groceries',
            'priority' => 'high',
            'status' => 'pending',
        ]);
    }

    public function test_todo_creation_requires_valid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('todos.store'), [
            'title' => '',
            'priority' => 'invalid-priority',
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors(['title', 'priority', 'status']);
    }

    public function test_user_can_view_edit_page_for_their_todo(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id, 'title' => 'My Task']);

        $response = $this->actingAs($user)->get(route('todos.edit', $todo->id));

        $response->assertStatus(200);
        $response->assertSee('My Task');
    }

    public function test_user_can_update_their_todo(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create([
            'user_id' => $user->id,
            'title' => 'Old Title',
            'priority' => 'low',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->put(route('todos.update', $todo->id), [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'priority' => 'high',
            'status' => 'in_progress',
            'due_date' => now()->addDays(5)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Updated Title',
            'priority' => 'high',
            'status' => 'in_progress',
        ]);
    }

    public function test_user_can_delete_their_todo(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('todos.destroy', $todo->id));

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }

    public function test_user_can_update_task_status_directly(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id, 'status' => 'pending']);

        $response = $this->actingAs($user)->patch(route('todos.updateStatus', $todo->id), [
            'status' => 'completed',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'status' => 'completed',
        ]);
    }

    public function test_user_can_search_and_filter_tasks(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create(['user_id' => $user->id, 'title' => 'Alpha Task', 'priority' => 'high', 'status' => 'pending']);
        Todo::factory()->create(['user_id' => $user->id, 'title' => 'Beta Task', 'priority' => 'low', 'status' => 'completed']);

        // Search test
        $response = $this->actingAs($user)->get(route('todos.index', ['search' => 'Alpha']));
        $response->assertStatus(200);
        $response->assertSee('Alpha Task');
        $response->assertDontSee('Beta Task');

        // Status filter test
        $response = $this->actingAs($user)->get(route('todos.index', ['status' => 'completed']));
        $response->assertStatus(200);
        $response->assertSee('Beta Task');
        $response->assertDontSee('Alpha Task');

        // Priority filter test
        $response = $this->actingAs($user)->get(route('todos.index', ['priority' => 'high']));
        $response->assertStatus(200);
        $response->assertSee('Alpha Task');
        $response->assertDontSee('Beta Task');
    }

    public function test_user_can_search_and_filter_tasks_on_dashboard(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create(['user_id' => $user->id, 'title' => 'Dashboard Alpha Task', 'priority' => 'high', 'status' => 'pending']);
        Todo::factory()->create(['user_id' => $user->id, 'title' => 'Dashboard Beta Task', 'priority' => 'low', 'status' => 'completed']);

        // Search on dashboard
        $response = $this->actingAs($user)->get(route('dashboard', ['search' => 'Alpha']));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Alpha Task');
        $response->assertDontSee('Dashboard Beta Task');

        // Filter by status on dashboard
        $response = $this->actingAs($user)->get(route('dashboard', ['status' => 'completed']));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Beta Task');
        $response->assertDontSee('Dashboard Alpha Task');
    }
}

