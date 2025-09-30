<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenPlan extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'layout_data',
        'total_area',
    ];

    protected $casts = [
        'layout_data' => 'array',
        'total_area' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
