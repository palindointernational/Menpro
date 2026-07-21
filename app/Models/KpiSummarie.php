<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiSummarie extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'user_id',
        'total_score',
        'grade',
        'rank',
        'completed_task',
        'late_task',
        'approved_task',
        'revision_task'
    ];

    public function period()
    {
        return $this->belongsTo(KpiPeriod::class, 'period_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
