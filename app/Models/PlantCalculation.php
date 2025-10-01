<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calculation_type',
        'area_length',
        'area_width',
        'plant_spacing',
        'row_spacing',
        'border_spacing',
        'total_plants',
        'plants_per_row',
        'number_of_rows',
        'effective_area',
        'planting_density',
        'space_utilization',
        'input_units'
    ];

    protected $casts = [
        'area_length' => 'decimal:2',
        'area_width' => 'decimal:2',
        'plant_spacing' => 'decimal:2',
        'row_spacing' => 'decimal:2',
        'border_spacing' => 'decimal:2',
        'total_plants' => 'integer',
        'plants_per_row' => 'integer',
        'number_of_rows' => 'integer',
        'effective_area' => 'decimal:2',
        'planting_density' => 'decimal:2',
        'space_utilization' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}