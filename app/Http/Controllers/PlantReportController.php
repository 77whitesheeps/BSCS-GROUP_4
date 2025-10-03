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
        // Start with empty data - will be populated via JavaScript
        $plants = [];
        
        return view('reports.monthly-plants', compact('plants'));
    }
    
    /**
     * Display print report summary
     */
    public function printReport(): View
    {
        // Start with empty data for print version
        $plants = [];
        
        return view('reports.print-plant-report', compact('plants'));
    }
}