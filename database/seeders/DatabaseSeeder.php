<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User 1: John Doe
        $john = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
            ]
        );

        // User 2: Jane Smith
        $jane = User::firstOrCreate(
            ['email' => 'jane@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password123'),
            ]
        );

        // Create realistic tasks for John
        if ($john->todos()->count() === 0) {
            Todo::create([
                'user_id' => $john->id,
                'title' => 'Fix header navigation bug on mobile',
                'description' => 'Test drawer menu toggle on iOS Safari and Android Chrome.',
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => now()->addDays(2),
            ]);

            Todo::create([
                'user_id' => $john->id,
                'title' => 'Send monthly invoice to Acme Corp',
                'description' => 'Attach updated timesheet and send to accounting.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(4),
            ]);

            Todo::create([
                'user_id' => $john->id,
                'title' => 'Call dentist for routine checkup',
                'description' => 'Schedule appointment for next Tuesday afternoon.',
                'priority' => 'low',
                'status' => 'completed',
                'due_date' => now()->subDay(),
            ]);
        }

        // Create realistic tasks for Jane
        if ($jane->todos()->count() === 0) {
            Todo::create([
                'user_id' => $jane->id,
                'title' => 'Prepare slide deck for client meeting',
                'description' => 'Include key milestones and Q4 deliverables.',
                'priority' => 'high',
                'status' => 'completed',
                'due_date' => now()->subDays(2),
            ]);

            Todo::create([
                'user_id' => $jane->id,
                'title' => 'Order replacement monitor cable',
                'description' => 'Need 2-meter DisplayPort to USB-C cable.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addWeek(),
            ]);
        }
    }
}
