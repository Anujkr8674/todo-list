@extends('layouts.app')

@section('title', 'Edit Task - Todo List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i>
                    <span>Back to Dashboard</span>
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h4 class="fw-bold mb-0" style="color: var(--text-dark);">
                        <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Task
                    </h4>
                    <p class="text-muted small mb-0 mt-1">Make changes to your task details below.</p>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('todos.update', $todo) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Task Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold text-secondary small">
                                Task Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $todo->title) }}" placeholder="e.g. Review invoice from supplier, Call dentist, Fix login bug" required autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Task Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold text-secondary small">
                                Description <span class="text-muted fw-normal">(Optional)</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4" placeholder="Add any extra notes, links, or context here...">{{ old('description', $todo->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Task Priority -->
                            <div class="col-md-4">
                                <label for="priority" class="form-label fw-semibold text-secondary small">
                                    Priority <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                    <option value="low" {{ old('priority', $todo->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', $todo->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', $todo->priority) === 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Task Status -->
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold text-secondary small">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="pending" {{ old('status', $todo->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ old('status', $todo->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ old('status', $todo->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div class="col-md-4">
                                <label for="due_date" class="form-label fw-semibold text-secondary small">
                                    Due Date <span class="text-muted fw-normal">(Optional)</span>
                                </label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                       id="due_date" name="due_date" value="{{ old('due_date', $todo->due_date ? $todo->due_date->format('Y-m-d') : '') }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center gap-2 pt-2 border-top">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Update Task
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 py-2 text-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone for Task Deletion -->
            <div class="card border border-danger-subtle rounded-4 overflow-hidden">
                <div class="card-body p-4 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    <div>
                        <h6 class="fw-bold text-danger mb-1">
                            <i class="bi bi-trash3 me-1"></i> Delete Task
                        </h6>
                        <p class="text-muted small mb-0">Permanently remove this task from your list.</p>
                    </div>
                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 fw-medium text-nowrap" onclick="return confirm('Delete this task? This action cannot be undone.')">
                            <i class="bi bi-trash me-1"></i> Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
