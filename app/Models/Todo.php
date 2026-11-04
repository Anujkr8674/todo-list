<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getPriorityBadgeClassAttribute(): string
    {
        return match($this->priority) {
            'high' => 'badge-danger',
            'medium' => 'badge-warning',
            'low' => 'badge-success',
            default => 'badge-secondary',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'completed' => 'badge-success',
            'in_progress' => 'badge-primary',
            'pending' => 'badge-secondary',
            default => 'badge-secondary',
        };
    }

    public function getFormattedStatusAttribute(): string
    {
        return match($this->status) {
            'in_progress' => 'In Progress',
            'pending' => 'Pending',
            'completed' => 'Completed',
            default => ucfirst($this->status),
        };
    }
}
