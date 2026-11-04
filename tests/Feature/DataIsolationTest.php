<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_see_other_users_tasks_on_dashboard(): void
    {
        $userA = User::factory()->create(['name' => 'User Alice']);
        $userB = User::factory()->create(['name' => 'User Bob']);

        Todo::factory()->create([
            'user_id' => $userA->id,
            'title' => "Alice's Secret Task",
        ]);

        Todo::factory()->create([
            'user_id' => $userB->id,
            'title' => "Bob's Confidential Task",
        ]);

        $response = $this->actingAs($userA)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee("Alice's Secret Task");
        $response->assertDontSee("Bob's Confidential Task");
    }

    public function test_user_cannot_see_other_users_tasks_in_todo_list(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        Todo::factory()->create([
            'user_id' => $userA->id,
            'title' => "Alice's Project Plan",
        ]);

        Todo::factory()->create([
            'user_id' => $userB->id,
            'title' => "Bob's Financial Review",
        ]);

        $response = $this->actingAs($userA)->get(route('todos.index'));

        $response->assertStatus(200);
        $response->assertSee("Alice's Project Plan");
        $response->assertDontSee("Bob's Financial Review");
    }

    public function test_user_cannot_edit_another_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $bobsTodo = Todo::factory()->create([
            'user_id' => $userB->id,
            'title' => "Bob's Private Task",
        ]);

        // Alice tries to edit Bob's task by changing ID in URL
        $response = $this->actingAs($userA)->get(route('todos.edit', $bobsTodo->id));

        $response->assertStatus(404);
    }

    public function test_user_cannot_update_another_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $bobsTodo = Todo::factory()->create([
            'user_id' => $userB->id,
            'title' => "Original Title",
        ]);

        // Alice tries to PUT update Bob's task
        $response = $this->actingAs($userA)->put(route('todos.update', $bobsTodo->id), [
            'title' => 'Hacked by Alice',
            'priority' => 'high',
            'status' => 'completed',
        ]);

        $response->assertStatus(404);
        $this->assertDatabaseHas('todos', [
            'id' => $bobsTodo->id,
            'title' => 'Original Title',
        ]);
        $this->assertDatabaseMissing('todos', [
            'title' => 'Hacked by Alice',
        ]);
    }

    public function test_user_cannot_delete_another_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $bobsTodo = Todo::factory()->create([
            'user_id' => $userB->id,
            'title' => "Bob's Safe Task",
        ]);

        // Alice tries to DELETE Bob's task
        $response = $this->actingAs($userA)->delete(route('todos.destroy', $bobsTodo->id));

        $response->assertStatus(404);
        $this->assertDatabaseHas('todos', [
            'id' => $bobsTodo->id,
            'title' => "Bob's Safe Task",
        ]);
    }

    public function test_user_cannot_change_status_of_another_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $bobsTodo = Todo::factory()->create([
            'user_id' => $userB->id,
            'status' => 'pending',
        ]);

        // Alice tries to PATCH status of Bob's task
        $response = $this->actingAs($userA)->patch(route('todos.updateStatus', $bobsTodo->id), [
            'status' => 'completed',
        ]);

        $response->assertStatus(404);
        $this->assertDatabaseHas('todos', [
            'id' => $bobsTodo->id,
            'status' => 'pending',
        ]);
    }

    public function test_dashboard_statistics_isolate_user_counts(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        // Alice has 2 pending, 1 completed = 3 total
        Todo::factory()->count(2)->create(['user_id' => $userA->id, 'status' => 'pending']);
        Todo::factory()->create(['user_id' => $userA->id, 'status' => 'completed']);

        // Bob has 10 completed = 10 total
        Todo::factory()->count(10)->create(['user_id' => $userB->id, 'status' => 'completed']);

        // Check Alice's dashboard stats
        $response = $this->actingAs($userA)->get(route('dashboard'));
        $response->assertViewHas('stats', [
            'total' => 3,
            'pending' => 2,
            'in_progress' => 0,
            'completed' => 1,
        ]);

        // Check Bob's dashboard stats
        $response = $this->actingAs($userB)->get(route('dashboard'));
        $response->assertViewHas('stats', [
            'total' => 10,
            'pending' => 0,
            'in_progress' => 0,
            'completed' => 10,
        ]);
    }
}

