<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateUserTotalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update totals for all users
        User::all()->each(function ($user) {
            $user->updateUserTotals();
            $this->command->info("Updated totals for user: {$user->name}");
        });
    }
}