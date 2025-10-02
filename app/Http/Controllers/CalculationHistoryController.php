<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantCalculation;
use App\Models\ExportLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class CalculationHistoryController extends Controller
{
    /**
     * Display calculation history
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get filters from request
        $dateFilter = $request->get('date_filter', 'all');
        $calculationType = $request->get('calculation_type', 'all');
        $search = $request->get('search');
        
        // Base query
        $query = PlantCalculation::where('user_id', $user->id);
        
        // Apply date filter
        switch ($dateFilter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }
        
        // Apply calculation type filter
        if ($calculationType !== 'all') {
            $query->where('calculation_type', $calculationType);
        }
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('plant_type', 'like', "%{$search}%")
                  ->orWhere('calculation_name', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }
        
        // Get calculations with pagination
        $calculations = $query->orderBy('created_at', 'desc')
                             ->paginate(10)
                             ->appends($request->query());
        
        // Get statistics for the filtered period
        $stats = [
            'total' => $query->count(),
            'total_plants' => $query->sum('total_plants'),
            'total_area' => $query->sum('total_area'),
            'avg_plants' => $query->avg('total_plants'),
        ];
        
        return view('calculations.history', compact('calculations', 'stats', 'dateFilter', 'calculationType', 'search'));
    }
    
    /**
     * Show saved calculations
     */
    public function saved(Request $request)
    {
        $user = auth()->user();
        
        $savedCalculations = PlantCalculation::where('user_id', $user->id)
                                           ->where('is_saved', true)
                                           ->orderBy('updated_at', 'desc')
                                           ->paginate(12);
        
        return view('calculations.saved', compact('savedCalculations'));
    }
    
    /**
     * Save a calculation with a name
     */
    public function save(Request $request, $id)
    {
        $request->validate([
            'calculation_name' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $calculation = PlantCalculation::findOrFail($id);
        
        // Ensure user owns the calculation
        if ($calculation->user_id !== auth()->id()) {
            abort(403, 'You do not have permission to save this calculation.');
        }
        
        $calculation->update([
            'calculation_name' => $request->calculation_name,
            'notes' => $request->notes,
            'is_saved' => true
        ]);
        
        return redirect()->back()->with('success', 'Calculation saved successfully!');
    }
    
    /**
     * Delete a calculation
     */
    public function destroy($id)
    {
        $calculation = PlantCalculation::findOrFail($id);
        
        // Ensure user owns the calculation
        if ($calculation->user_id !== auth()->id()) {
            abort(403, 'You do not have permission to delete this calculation.');
        }
        
        $calculation->delete();
        
        return redirect()->back()->with('success', 'Calculation deleted successfully!');
    }
    
    /**
     * Show export page
     */
    public function exportPage()
    {
        $user = auth()->user();
        
        // Get count of saved calculations for display
        $savedCalculationsCount = PlantCalculation::where('user_id', $user->id)
                                                 ->where('is_saved', true)
                                                 ->count();
        
        // TEMPORARY: Also get total calculations count for debugging
        $totalCalculationsCount = PlantCalculation::where('user_id', $user->id)->count();
        
        // Debug: Log the counts
        logger()->info('Export page debug:', [
            'user_id' => $user->id,
            'total_calculations' => PlantCalculation::where('user_id', $user->id)->count(),
            'saved_calculations' => $savedCalculationsCount,
            'all_calculations' => PlantCalculation::where('user_id', $user->id)->get(['id', 'calculation_name', 'is_saved'])->toArray()
        ]);
        
        // Get saved calculations for selection
        $savedCalculations = PlantCalculation::where('user_id', $user->id)
                                           ->where('is_saved', true)
                                           ->orderBy('created_at', 'desc')
                                           ->get();
        
        // Get recent exports for the user
        $recentExports = ExportLog::getRecentForUser($user->id, 5);

        return view('calculations.export', compact('savedCalculationsCount', 'totalCalculationsCount', 'savedCalculations', 'recentExports'));
    }
    
    /**
     * Export calculations
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        $dateFilter = $request->get('date_filter', 'all');
        $isPreview = $request->has('preview');
        
        $user = auth()->user();
        
        // Debug: Log the request
        logger()->info('Export request debug:', [
            'user_id' => $user->id,
            'format' => $format,
            'date_filter' => $dateFilter,
            'is_preview' => $isPreview,
            'request_data' => $request->all()
        ]);
        
        // Get specific calculation IDs if provided, otherwise get saved calculations
        if ($request->has('calculation_ids') && !empty($request->calculation_ids)) {
            // Export specific selected calculations
            $calculationIds = is_array($request->calculation_ids) ? $request->calculation_ids : explode(',', $request->calculation_ids);
            $query = PlantCalculation::where('user_id', $user->id)
                                   ->where('is_saved', true) // Only allow exporting saved calculations
                                   ->whereIn('id', $calculationIds);
        } else {
            // Export all saved calculations (default behavior)
            $query = PlantCalculation::where('user_id', $user->id)
                                   ->where('is_saved', true);
        }
        
        // Apply same date filter as history
        switch ($dateFilter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
        }
        
        $calculations = $query->orderBy('created_at', 'desc')->get();
        
        // Debug: Log the results
        logger()->info('Export query results:', [
            'calculations_count' => $calculations->count(),
            'calculations_data' => $calculations->toArray()
        ]);
        
        // If preview request, return JSON data
        if ($isPreview) {
            return response()->json([
                'success' => true,
                'data' => $calculations->toArray(),
                'count' => $calculations->count()
            ]);
        }
        
        // Create export log before performing export
        $exportLog = ExportLog::create([
            'user_id' => auth()->id(),
            'format' => $format,
            'record_count' => $calculations->count(),
            'status' => 'completed',
            'filters' => [
                'date_filter' => $dateFilter,
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
            ]
        ]);
        
        if ($format === 'csv') {
            $response = $this->exportCsv($calculations);
            
            // Update export log with file size if possible
            $this->updateExportLogFileSize($exportLog, $response);
            
            return $response;
        } elseif ($format === 'pdf') {
            $response = $this->exportPdf($calculations);
            
            // Update export log with file size if possible
            $this->updateExportLogFileSize($exportLog, $response);
            
            return $response;
        }
        
        // If we get here, mark the export as failed
        $exportLog->update(['status' => 'failed']);
        
        return redirect()->back()->with('error', 'Invalid export format');
    }
    
    /**
     * Export as CSV
     */
    private function exportCsv($calculations)
    {
        $filename = 'calculations_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($calculations) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'Date',
                'Calculation Name',
                'Plant Type',
                'Area Length',
                'Area Width', 
                'Plant Spacing',
                'Total Plants',
                'Total Area (m²)',
                'Calculation Type',
                'Notes'
            ]);
            
            // Data
            foreach ($calculations as $calc) {
                fputcsv($file, [
                    $calc->created_at->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s'),
                    $calc->calculation_name ?? 'Unnamed',
                    $calc->plant_type ?? 'Not specified',
                    $calc->area_length,
                    $calc->area_width,
                    $calc->plant_spacing,
                    $calc->total_plants,
                    $calc->total_area,
                    $calc->calculation_type ?? 'Square',
                    $calc->notes ?? ''
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Export as PDF (placeholder - would need a PDF library like DOMPDF)
     */
    private function exportPdf($calculations)
    {
        // For now, return CSV until PDF library is installed
        return $this->exportCsv($calculations);
    }
    
    /**
     * Update export log with file size information
     */
    private function updateExportLogFileSize($exportLog, $response)
    {
        try {
            // For streamed responses, we can estimate the size
            $estimatedSize = $exportLog->record_count * 150; // Rough estimate: 150 bytes per record
            
            if ($estimatedSize < 1024) {
                $fileSize = $estimatedSize . ' B';
            } elseif ($estimatedSize < 1024 * 1024) {
                $fileSize = round($estimatedSize / 1024, 1) . ' KB';
            } else {
                $fileSize = round($estimatedSize / (1024 * 1024), 1) . ' MB';
            }
            
            $exportLog->update(['file_size' => $fileSize]);
        } catch (\Exception $e) {
            // If we can't determine file size, that's okay - leave it null
            logger()->warning('Could not update export log file size: ' . $e->getMessage());
        }
    }
}
