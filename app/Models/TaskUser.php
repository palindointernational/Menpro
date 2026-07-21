<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    protected $fillable = ['task_id', 'user_id', 'role'];

    public function task()
    {
        return $this->belongsTo(TaskItem::class, 'task_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
