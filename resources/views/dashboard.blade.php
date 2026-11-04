@extends('layouts.app')

@section('title', 'Dashboard - Todo List')

@section('content')
    <!-- Dashboard Welcome Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-dark);">Welcome back, {{ Auth::user()->name }}!</h2>
            <p class="text-muted mb-0">Here is what is currently on your list.</p>
        </div>
        <div>
            <a href="{{ route('todos.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span>Add Task</span>
            </a>
        </div>
    </div>

    <!-- Dashboard Statistics Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium text-uppercase">Total Tasks</span>
                            <h2 class="fw-bold mb-0 mt-1" style="color: var(--text-dark);">{{ $stats['total'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper rounded-4 bg-primary-subtle text-primary">
                            <i class="bi bi-card-checklist fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium text-uppercase">Pending</span>
                            <h2 class="fw-bold mb-0 mt-1 text-secondary">{{ $stats['pending'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper rounded-4 bg-secondary-subtle text-secondary">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium text-uppercase">In Progress</span>
                            <h2 class="fw-bold mb-0 mt-1" style="color: #2563EB;">{{ $stats['in_progress'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper rounded-4 text-primary" style="background-color: #DBEAFE; color: #2563EB !important;">
                            <i class="bi bi-arrow-repeat fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium text-uppercase">Completed</span>
                            <h2 class="fw-bold mb-0 mt-1" style="color: var(--success-color);">{{ $stats['completed'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper rounded-4" style="background-color: #DCFCE7; color: var(--success-color);">
                            <i class="bi bi-check2-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Todo List & Filter Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <!-- Header with Title and View All Tasks Button -->
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-0" style="color: var(--text-dark);">
                    <i class="bi bi-list-task me-2 text-primary"></i>Recent Tasks
                </h5>
                <small class="text-muted">Tasks you have worked on recently</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('todos.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-medium">
                    View All Tasks <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Filter & Search Controls -->
        <div class="bg-light p-3 p-md-4 border-bottom">
            <form action="{{ route('dashboard') }}" method="GET" class="row g-2 g-md-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-secondary">Search</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Type to search..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold text-secondary">Status</label>
                    <select name="status" class="form-select bg-white">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold text-secondary">Priority</label>
                    <select name="priority" class="form-select bg-white">
                        <option value="">All Priorities</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold text-secondary">Due Date</label>
                    <input type="date" name="due_date" class="form-control bg-white" value="{{ request('due_date') }}">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold text-secondary">Sort By</label>
                    <select name="sort" class="form-select bg-white">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="due_date_asc" {{ request('sort') === 'due_date_asc' ? 'selected' : '' }}>Due Date (Asc)</option>
                        <option value="due_date_desc" {{ request('sort') === 'due_date_desc' ? 'selected' : '' }}>Due Date (Desc)</option>
                    </select>
                </div>

                <div class="col-12 col-md-1 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100" title="Filter">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    @if(request()->hasAny(['search', 'status', 'priority', 'due_date', 'sort']))
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill" title="Clear">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Task Table / Cards Body -->
        <div class="card-body p-0">
            @if($todos->isEmpty())
                <div class="text-center py-5 px-3">
                    <div class="empty-state-icon mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center bg-light">
                        <i class="bi bi-inbox text-muted fs-1"></i>
                    </div>
                    @if(request()->hasAny(['search', 'status', 'priority', 'due_date']))
                        <h5 class="fw-bold" style="color: var(--text-dark);">No tasks found</h5>
                        <p class="text-muted mb-4 max-w-sm mx-auto">No tasks match your search or filter options.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Clear Filters
                        </a>
                    @else
                        <h5 class="fw-bold" style="color: var(--text-dark);">No tasks yet</h5>
                        <p class="text-muted mb-4 max-w-sm mx-auto">You don't have any tasks on your list yet.</p>
                        <a href="{{ route('todos.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Create Task
                        </a>
                    @endif
                </div>
            @else
                <!-- Responsive Table for Tablet & Desktop -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 px-4 py-3 text-secondary small fw-semibold text-uppercase">Task</th>
                                <th class="border-0 py-3 text-secondary small fw-semibold text-uppercase">Priority</th>
                                <th class="border-0 py-3 text-secondary small fw-semibold text-uppercase">Status</th>
                                <th class="border-0 py-3 text-secondary small fw-semibold text-uppercase">Due Date</th>
                                <th class="border-0 py-3 text-secondary small fw-semibold text-uppercase">Created</th>
                                <th class="border-0 px-4 py-3 text-secondary small fw-semibold text-uppercase text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todos as $todo)
                                <tr>
                                    <td class="px-4 py-3" style="max-width: 320px;">
                                        <div class="fw-semibold text-dark text-truncate {{ $todo->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}" title="{{ $todo->title }}">
                                            {{ $todo->title }}
                                        </div>
                                        @if($todo->description)
                                            <div class="text-muted small text-truncate" title="{{ $todo->description }}">
                                                {{ $todo->description }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-priority-{{ $todo->priority }} rounded-pill px-3 py-1 fw-medium">
                                            @if($todo->priority === 'high')
                                                High
                                            @elseif($todo->priority === 'medium')
                                                Medium
                                            @else
                                                Low
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('todos.updateStatus', $todo) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm status-select status-badge-{{ $todo->status }}" onchange="this.form.submit()">
                                                <option value="pending" {{ $todo->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in_progress" {{ $todo->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed" {{ $todo->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        @if($todo->due_date)
                                            <span class="small {{ $todo->due_date->isPast() && $todo->status !== 'completed' ? 'text-danger fw-semibold' : 'text-muted' }}">
                                                <i class="bi bi-calendar3 me-1"></i>{{ $todo->due_date->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ $todo->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('todos.edit', $todo) }}" class="btn btn-outline-secondary rounded-pill me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-pill" title="Delete" onclick="return confirm('Delete this task?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Responsive Card Layout for Mobile -->
                <div class="d-block d-md-none p-3">
                    @foreach($todos as $todo)
                        <div class="card border rounded-3 mb-3 shadow-none task-card-mobile">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h6 class="fw-bold mb-0 {{ $todo->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                        {{ $todo->title }}
                                    </h6>
                                    <span class="badge badge-priority-{{ $todo->priority }} rounded-pill px-2 py-1 flex-shrink-0">
                                        {{ ucfirst($todo->priority) }}
                                    </span>
                                </div>

                                @if($todo->description)
                                    <p class="text-muted small mb-2">{{ Str::limit($todo->description, 100) }}</p>
                                @endif

                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-2 border-top">
                                    <form action="{{ route('todos.updateStatus', $todo) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm status-select status-badge-{{ $todo->status }}" onchange="this.form.submit()">
                                            <option value="pending" {{ $todo->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $todo->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $todo->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </form>

                                    <div class="d-flex align-items-center gap-2">
                                        @if($todo->due_date)
                                            <span class="small text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>{{ $todo->due_date->format('M d') }}
                                            </span>
                                        @endif
                                        <a href="{{ route('todos.edit', $todo) }}" class="btn btn-outline-secondary btn-sm rounded-circle p-1" style="width: 28px; height: 28px;" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle p-1" style="width: 28px; height: 28px;" title="Delete" onclick="return confirm('Delete this task?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
