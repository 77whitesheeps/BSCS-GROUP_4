<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantCalculation; // Assuming your calculations are stored here
use Carbon\Carbon;

class UsageStatisticsController extends Controller
{
    public function index()
    {
        // Fetch data for monthly trends chart
        $monthlyTrends = $this->getMonthlyTrends();

        // Fetch data for distribution chart
        $distributionData = $this->getDistributionData();
        $squarePercentage = $distributionData['squarePercentage'];
        $quincunxPercentage = $distributionData['quincunxPercentage'];
        $triangularPercentage = $distributionData['triangularPercentage'];

        // You might also want to fetch other dashboard metrics here
        // For now, I'll use placeholder data or fetch from a simple source
        $totalCalculations = PlantCalculation::count();
        $todayCalculations = PlantCalculation::whereDate('created_at', Carbon::today())->count();
        // Example growth rate (you'll need to define your own logic for this)
        $growthRate = 10; // Placeholder

        return view('usage-statistics', compact(
            'monthlyTrends',
            'squarePercentage',
            'quincunxPercentage',
            'triangularPercentage',
            'totalCalculations',
            'todayCalculations',
            'growthRate'
        ));
    }

    public function getStatistics(Request $request)
    {
        // Fetch data for monthly trends chart
        $monthlyTrends = $this->getMonthlyTrends();

        // Fetch data for distribution chart
        $distributionData = $this->getDistributionData();
        $squarePercentage = $distributionData['squarePercentage'];
        $quincunxPercentage = $distributionData['quincunxPercentage'];
        $triangularPercentage = $distributionData['triangularPercentage'];

        // Summary Statistics (placeholders for now, you'll need to implement actual logic)
        $totalCalculations = PlantCalculation::count();
        $activeUsers = 0; // Placeholder
        $avgPlantsPerHectare = 0; // Placeholder
        $successRate = 0; // Placeholder

        // Performance Metrics (placeholders for now)
        $squareCalculations = PlantCalculation::where('calculation_type', 'square')->count();
        $quincunxCalculations = PlantCalculation::where('calculation_type', 'quincunx')->count();
        $triangularCalculations = PlantCalculation::where('calculation_type', 'triangular')->count();

        $squareGrowth = 0; // Placeholder
        $quincunxGrowth = 0; // Placeholder
        $triangularGrowth = 0; // Placeholder

        $squarePlantsPerHectare = 0; // Placeholder
        $quincunxPlantsPerHectare = 0; // Placeholder
        $triangularPlantsPerHectare = 0; // Placeholder

        $squareEfficiency = 0; // Placeholder
        $quincunxEfficiency = 0; // Placeholder
        $triangularEfficiency = 0; // Placeholder

        // Recent Activity & Insights (placeholders for now)
        $squareUsageIncrease = 0; // Placeholder
        $newUsersJoined = 0; // Placeholder
        $activeUserGrowth = 0; // Placeholder
        $quincunxEfficiencyIncrease = 0; // Placeholder
        $systemAccuracy = 0; // Placeholder
        $marginOfError = 0; // Placeholder

        // Quick Stats (placeholders for now)
        $avgSession = 0; // Placeholder
        $bounceRate = 0; // Placeholder
        $peakTime = "N/A"; // Placeholder
        $topRegion = "N/A"; // Placeholder


        return response()->json([
            'summaryStats' => [
                'totalCalculations' => $totalCalculations,
                'activeUsers' => $activeUsers,
                'avgPlantsPerHectare' => $avgPlantsPerHectare,
                'successRate' => $successRate,
            ],
            'monthlyTrends' => $monthlyTrends,
            'distributionData' => [
                'squarePercentage' => $squarePercentage,
                'quincunxPercentage' => $quincunxPercentage,
                'triangularPercentage' => $triangularPercentage,
                'otherPercentage' => 100 - ($squarePercentage + $quincunxPercentage + $triangularPercentage), // Assuming 'Other' makes up the rest
            ],
            'performanceMetrics' => [
                'square' => [
                    'calculations' => $squareCalculations,
                    'growth' => $squareGrowth,
                    'plantsPerHectare' => $squarePlantsPerHectare,
                    'efficiency' => $squareEfficiency,
                ],
                'quincunx' => [
                    'calculations' => $quincunxCalculations,
                    'growth' => $quincunxGrowth,
                    'plantsPerHectare' => $quincunxPlantsPerHectare,
                    'efficiency' => $quincunxEfficiency,
                ],
                'triangular' => [
                    'calculations' => $triangularCalculations,
                    'growth' => $triangularGrowth,
                    'plantsPerHectare' => $triangularPlantsPerHectare,
                    'efficiency' => $triangularEfficiency,
                ],
            ],
            'recentActivityInsights' => [
                'squareUsageIncrease' => $squareUsageIncrease,
                'newUsersJoined' => $newUsersJoined,
                'activeUserGrowth' => $activeUserGrowth,
                'quincunxEfficiencyIncrease' => $quincunxEfficiencyIncrease,
                'systemAccuracy' => $systemAccuracy,
                'marginOfError' => $marginOfError,
            ],
            'quickStats' => [
                'avgSession' => $avgSession,
                'bounceRate' => $bounceRate,
                'peakTime' => $peakTime,
                'topRegion' => $topRegion,
            ],
        ]);
    }

    /**
     * Fetches monthly trends data for the chart.
     * This is a placeholder and needs to be implemented based on your data structure.
     */
    private function getMonthlyTrends()
    {
        // Example: Fetch data for the last 6 months
        $months = [];
        $squareData = [];
        $quincunxData = [];
        $triangularData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');
            $months[] = $monthName;

            // Placeholder: Replace with actual data retrieval from your database
            $squareData[] = PlantCalculation::where('calculation_type', 'square')
                                            ->whereYear('created_at', $date->year)
                                            ->whereMonth('created_at', $date->month)
                                            ->count();
            $quincunxData[] = PlantCalculation::where('calculation_type', 'quincunx')
                                              ->whereYear('created_at', $date->year)
                                              ->whereMonth('created_at', $date->month)
                                              ->count();
            $triangularData[] = PlantCalculation::where('calculation_type', 'triangular')
                                                ->whereYear('created_at', $date->year)
                                                ->whereMonth('created_at', $date->month)
                                                ->count();
        }

        return [
            'labels' => $months,
            'square' => $squareData,
            'quincunx' => $quincunxData,
            'triangular' => $triangularData,
        ];
    }

    /**
     * Fetches distribution data for the chart.
     * This is a placeholder and needs to be implemented based on your data structure.
     */
    private function getDistributionData()
    {
        $totalSquare = PlantCalculation::where('calculation_type', 'square')->count();
        $totalQuincunx = PlantCalculation::where('calculation_type', 'quincunx')->count();
        $totalTriangular = PlantCalculation::where('calculation_type', 'triangular')->count();
        $grandTotal = $totalSquare + $totalQuincunx + $totalTriangular;

        $squarePercentage = $grandTotal > 0 ? round(($totalSquare / $grandTotal) * 100, 2) : 0;
        $quincunxPercentage = $grandTotal > 0 ? round(($totalQuincunx / $grandTotal) * 100, 2) : 0;
        $triangularPercentage = $grandTotal > 0 ? round(($totalTriangular / $grandTotal) * 100, 2) : 0;

        return [
            'squarePercentage' => $squarePercentage,
            'quincunxPercentage' => $quincunxPercentage,
            'triangularPercentage' => $triangularPercentage,
        ];
    }
}