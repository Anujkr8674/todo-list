<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->todos();

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

        $todos = $query->paginate(10)->withQueryString();

        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'due_date' => ['nullable', 'date'],
        ]);

        Auth::user()->todos()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    public function edit($id)
    {
        $todo = Auth::user()->todos()->findOrFail($id);

        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $todo = Auth::user()->todos()->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'due_date' => ['nullable', 'date'],
        ]);

        $todo->update($validated);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }

    public function destroy($id)
    {
        $todo = Auth::user()->todos()->findOrFail($id);

        $todo->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $todo = Auth::user()->todos()->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $todo->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
}
