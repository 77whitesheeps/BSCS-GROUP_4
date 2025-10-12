<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_notifications',
        'theme',
        'default_garden_size',
        'auto_save_calculations',
        'export_format',
        'total_calculations',
        'total_plant_types',
        'total_plants_calculated',
        'total_area_planned',
        'total_plans',
        'total_garden_area_planned',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'total_calculations' => 'integer',
            'total_plant_types' => 'integer',
            'total_plants_calculated' => 'integer',
            'total_area_planned' => 'decimal:2',
            'total_plans' => 'integer',
            'total_garden_area_planned' => 'decimal:2',
        ];
    }

    /**
     * Get the plant calculations for the user.
     */
    public function plantCalculations()
    {
        return $this->hasMany(PlantCalculation::class);
    }

    /**
     * Get the garden plans for the user.
     */
    public function gardenPlans()
    {
        return $this->hasMany(GardenPlan::class);
    }

    /**
     * Update user totals based on calculations and plans.
     */
    public function updateUserTotals()
    {
        $calculations = $this->plantCalculations;
        $plans = $this->gardenPlans;

        $this->total_calculations = $calculations->count();
        $this->total_plant_types = $calculations->whereNotNull('plant_type')->unique('plant_type')->count();
        $this->total_plants_calculated = $calculations->sum('total_plants');
        $this->total_area_planned = $calculations->sum('total_area');
        $this->total_plans = $plans->count();
        $this->total_garden_area_planned = $plans->sum('total_area');

        $this->save();
    }
}
