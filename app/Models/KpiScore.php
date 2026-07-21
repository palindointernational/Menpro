<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'indicator_id',
        'user_id',
        'raw_value',
        'score',
        'notes'
    ];

    public function period()
    {
        return $this->belongsTo(KpiPeriod::class, 'period_id');
    }

    public function indicator()
    {
        return $this->belongsTo(KpiIndicator::class, 'indicator_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
