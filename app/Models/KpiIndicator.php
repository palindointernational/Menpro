<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'kpi_categories_id',
        'name',
        'description',
        'formula',
        'weight',
        'max_score',
        'is_auto'
    ];

    protected $casts = [
        'is_auto' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(KpiCategories::class, 'kpi_categories_id');
    }

    public function scores()
    {
        return $this->hasMany(KpiScore::class, 'indicator_id');
    }
}
