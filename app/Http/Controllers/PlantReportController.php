<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PlantReportController extends Controller
{
    /**
     * Display monthly plant report
     */
    public function monthlyReport(): View
    {
        // Sample data - no database model required
        $plants = [
            [
                'type' => 'Tomato',
                'date_planted' => '2024-01-15',
                'number_of_plants' => 45
            ],
            [
                'type' => 'Lettuce',
                'date_planted' => '2024-01-18',
                'number_of_plants' => 32
            ],
            [
                'type' => 'Carrot',
                'date_planted' => '2024-01-20',
                'number_of_plants' => 28
            ],
            [
                'type' => 'Basil',
                'date_planted' => '2024-01-22',
                'number_of_plants' => 15
            ],
            [
                'type' => 'Rose',
                'date_planted' => '2024-01-25',
                'number_of_plants' => 12
            ]
        ];

        return view('reports.monthly-plants', compact('plants'));
    }
}