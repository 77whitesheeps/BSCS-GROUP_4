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

    protected static function booted()
    {
        static::created(function ($plan) {
            $plan->updateUserTotals();
        });

        static::updated(function ($plan) {
            $plan->updateUserTotals();
        });

        static::deleted(function ($plan) {
            $plan->updateUserTotals();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    private function updateUserTotals()
    {
        $user = $this->user;

        $plans = $user->gardenPlans;

        $user->total_plans = $plans->count();
        $user->total_garden_area_planned = $plans->sum('total_area');

        $user->save();
    }
}
