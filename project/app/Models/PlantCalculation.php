<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantCalculation extends Model
{
    protected $fillable = [
        'user_id',
        'plant_type',
        'area_length',
        'area_length_unit',
        'area_width',
        'area_width_unit',
        'plant_spacing',
        'plant_spacing_unit',
        'border_spacing',
        'border_spacing_unit',
        'total_plants',
        'rows',
        'columns',
        'effective_length',
        'effective_width',
        'total_area',
        'calculation_name',
        'notes',
    ];

    protected $casts = [
        'area_length' => 'decimal:2',
        'area_width' => 'decimal:2',
        'plant_spacing' => 'decimal:2',
        'border_spacing' => 'decimal:2',
        'effective_length' => 'decimal:2',
        'effective_width' => 'decimal:2',
        'total_area' => 'decimal:4',
    ];

    /**
     * Get the user that owns the calculation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted area display
     */
    public function getFormattedAreaAttribute(): string
    {
        if ($this->total_area >= 10000) {
            return number_format($this->total_area / 10000, 2) . ' ha';
        } else {
            return number_format($this->total_area, 2) . ' m²';
        }
    }

    /**
     * Get the most popular plant types
     */
    public static function getPopularPlantTypes($limit = 5)
    {
        return self::select('plant_type')
            ->whereNotNull('plant_type')
            ->selectRaw('count(*) as calculations_count')
            ->groupBy('plant_type')
            ->orderBy('calculations_count', 'desc')
            ->limit($limit)
            ->get();
    }
}
