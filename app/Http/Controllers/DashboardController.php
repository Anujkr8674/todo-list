<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Calculate overall stats for all user tasks
        $allTodos = $user->todos()->get();
        $stats = [
            'total' => $allTodos->count(),
            'pending' => $allTodos->where('status', 'pending')->count(),
            'in_progress' => $allTodos->where('status', 'in_progress')->count(),
            'completed' => $allTodos->where('status', 'completed')->count(),
        ];

        // Query for filtered/recent tasks
        $query = $user->todos();

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['pending', 'in_progress', 'completed'])) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority') && in_array($request->priority, ['low', 'medium', 'high'])) {
            $query->where('priority', $request->priority);
        }

        // Filter by due date
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }

        // Sorting
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'due_date_asc':
                $query->orderByRaw('due_date IS NULL, due_date ASC');
                break;
            case 'due_date_desc':
                $query->orderByRaw('due_date IS NULL, due_date DESC');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $todos = $query->take(20)->get();

        return view('dashboard', compact('todos', 'stats'));
    }
}
