<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    protected $fillable = [
        'task_id',
        'name',
        'status',
        'assigned_role',
        'user_id',
        'completed_at',
        'due_date',
    ];

    public static array $workflowOrder = [
        'surveyor' => 1,
        'desainer' => 2,
        'drafter' => 3,
        'estimator' => 4,
        'supervisor' => 5,
        'furchasing' => 6,
        'keuangan' => 7,
        'konten kreator' => 8,
        'admin' => 9,
    ];
    public function canUpload(): bool
    {
        $user =  Filament::auth()->user();

        if (! $user) {
            return false;
        }

        $role = $user->role;
        $order = self::$workflowOrder;

        if (! isset($order[$role])) {
            return false;
        }
        if ($this->assigned_role !== $role) {
            return false;
        }
        if ($order[$role] === min($order)) {
            return true;
        }


        $prevRoles = array_keys(array_filter($order, fn($step) => $step < $order[$role]));


        $pendingExists = TaskItem::query()
            ->whereIn('task_id', function ($q) {
                $q->select('id')
                    ->from('tasks')
                    ->where('project_id', $this->task->project_id);
            })
            ->whereIn('assigned_role', $prevRoles)
            ->where('status', '!=', 'done')
            ->exists();


        return ! $pendingExists;
    }
    protected static function booted(): void
    {
        static::updating(function (TaskItem $taskItem) {

            if (
                $taskItem->isDirty('status') &&
                $taskItem->status === 'done' &&
                is_null($taskItem->completed_at)
            ) {
                $taskItem->completed_at = now();
            }
        });
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function results()
    {
        return $this->hasMany(TaskResult::class, 'task_item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
