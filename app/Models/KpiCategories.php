<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'weight'
    ];

    public function indicators()
    {
        return $this->hasMany(KpiIndicator::class);
    }
}
