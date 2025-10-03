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
        'plant_spacing_unit',
        'row_spacing',
        'border_spacing',
        'total_plants',
        'plants_per_row',
        'number_of_rows',
        'effective_area',
        'planting_density',
        'space_utilization',
        'input_units'
        'rows',
        'columns',
        'effective_length',
        'effective_width',
        'total_area',
        'calculation_name',
        'calculation_type',
        'notes',
        'is_saved',
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
        'effective_length' => 'decimal:2',
        'effective_width' => 'decimal:2',
        'total_area' => 'decimal:4',
        'is_saved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}