<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiPeriod extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeClosed($query)
    {
        return $query->where('is_active', false);
    }

    public function getDateRangeAttribute(): string
    {
        return $this->start_date->format('d M Y') .
            ' - ' .
            $this->end_date->format('d M Y');
    }

    public function scores()
    {
        return $this->hasMany(KpiScore::class, 'period_id');
    }

    public function summaries()
    {
        return $this->hasMany(KpiSummarie::class, 'period_id');
    }
}
