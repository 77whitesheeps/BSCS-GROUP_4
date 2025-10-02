@extends('layouts.dashboard')

@section('title', 'Export Calculations')
@section('page-title', 'Export Calculations')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('calculations.saved') }}">Saved Calculations</a></li>
    <li class="breadcrumb-item active">Export</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">
                                <i class="fas fa-download text-success me-2"></i>
                                Export Your Saved Calculations
                            </h4>
                            <p class="text-muted mb-0 mt-1">Download your saved calculation data in various formats</p>
                            <p class="small text-info mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Only calculations you've manually saved will be exported 
                                ({{ $savedCalculationsCount ?? 0 }} saved of {{ $totalCalculationsCount ?? 0 }} total calculations)
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('calculations.saved') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Back to Saved
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Export Options -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog"></i> Export Options
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($savedCalculationsCount) && $savedCalculationsCount > 0)
                    <form id="exportForm" method="POST" action="{{ route('calculations.export') }}">
                        @csrf
                        
                        <!-- Export Format -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Export Format</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="csv" value="csv" checked>
                                <label class="form-check-label" for="csv">
                                    <i class="fas fa-file-csv text-success"></i> CSV (Excel Compatible)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="pdf" value="pdf">
                                <label class="form-check-label" for="pdf">
                                    <i class="fas fa-file-pdf text-danger"></i> PDF Document
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="json" value="json">
                                <label class="form-check-label" for="json">
                                    <i class="fas fa-file-code text-info"></i> JSON Data
                                </label>
                            </div>
                        </div>
                        
                        <!-- Date Range -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Date Range</label>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">From Date</label>
                                    <input type="date" class="form-control" name="date_from" id="date_from" 
                                           value="{{ now()->subDays(30)->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">To Date</label>
                                    <input type="date" class="form-control" name="date_to" id="date_to" 
                                           value="{{ now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="setDateRange(7)">Last 7 days</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="setDateRange(30)">Last 30 days</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setDateRange(90)">Last 90 days</button>
                            </div>
                        </div>
                        
                        <!-- Select Specific Calculations -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-check-square text-primary"></i> Select Calculations to Export
                            </label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleAllCalculations()">
                                <label class="form-check-label fw-bold" for="selectAll">
                                    Select All ({{ $savedCalculations->count() }} saved calculations)
                                </label>
                            </div>
                            
                            @if($savedCalculations->count() > 0)
                                <div class="calculations-list" style="max-height: 300px; overflow-y: auto; border: 1px solid #e0e0e0; border-radius: 8px; padding: 15px;">
                                    @foreach($savedCalculations as $calculation)
                                        <div class="form-check mb-2 p-2" style="border-bottom: 1px solid #f0f0f0;">
                                            <input class="form-check-input calculation-checkbox" type="checkbox" name="calculation_ids[]" value="{{ $calculation->id }}" id="calc_{{ $calculation->id }}">
                                            <label class="form-check-label w-100" for="calc_{{ $calculation->id }}">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold text-dark">{{ $calculation->calculation_name ?? 'Calculation' }}</div>
                                                        <div class="small text-muted">
                                                            <i class="fas fa-seedling me-1"></i>{{ ucfirst($calculation->plant_type ?? 'Not specified') }}
                                                            <span class="mx-2">•</span>
                                                            <i class="fas fa-th me-1"></i>{{ ucfirst($calculation->calculation_type ?? 'square') }}
                                                            <span class="mx-2">•</span>
                                                            <i class="fas fa-calendar me-1"></i>{{ $calculation->created_at->setTimezone('Asia/Singapore')->format('M j, Y g:i A') }}
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="small text-success fw-bold">{{ number_format($calculation->total_plants) }} plants</div>
                                                        <div class="small text-muted">{{ number_format($calculation->total_area, 1) }}m²</div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-save fa-3x mb-3"></i>
                                    <p>No saved calculations available for export.</p>
                                    <a href="{{ route('calculations.history') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Save Some Calculations
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Calculation Type Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Calculation Types</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="types[]" value="square" id="square" checked>
                                <label class="form-check-label" for="square">Square Pattern</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="types[]" value="quincunx" id="quincunx" checked>
                                <label class="form-check-label" for="quincunx">Quincunx Pattern</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="types[]" value="triangular" id="triangular" checked>
                                <label class="form-check-label" for="triangular">Triangular Pattern</label>
                            </div>
                        </div>
                        
                        <!-- Additional Options -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Include</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_saved_only" id="include_saved_only">
                                <label class="form-check-label" for="include_saved_only">Saved calculations only</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_notes" id="include_notes" checked>
                                <label class="form-check-label" for="include_notes">Include notes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_timestamps" id="include_timestamps" checked>
                                <label class="form-check-label" for="include_timestamps">Include timestamps</label>
                            </div>
                        </div>
                        
                        <!-- Export Buttons -->
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" onclick="previewExport()">
                                <i class="fas fa-eye"></i> Preview Data
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-download"></i> Export Now
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-exclamation-triangle text-warning fa-3x"></i>
                        </div>
                        <h5 class="text-warning">No Saved Calculations Found</h5>
                        <p class="text-muted mb-3">
                            You need to save some calculations first before you can export them.
                        </p>
                        <a href="{{ route('calculations.history') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Go to History
                        </a>
                        <small class="d-block text-muted mt-2">
                            From the History page, use the Save button to save calculations you want to export later.
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Preview Area -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-table"></i> Data Preview
                        <span class="badge bg-secondary ms-2" id="recordCount">0 records</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div id="previewContainer">
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-table fa-3x mb-3"></i>
                            <p>Click "Preview Data" to see your calculations before exporting</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Export History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Recent Exports
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Format</th>
                                    <th>Records</th>
                                    <th>File Size</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentExports as $export)
                                <tr>
                                    <td>{{ $export->created_at->setTimezone('Asia/Singapore')->format('M j, Y g:i A') }}</td>
                                    <td>{{ strtoupper($export->format) }}</td>
                                    <td>{{ number_format($export->record_count) }}</td>
                                    <td>{{ $export->file_size ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Completed
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" disabled>
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox"></i> No recent exports
                                        <br><small class="text-muted">Export some data first to see history here</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setDateRange(days) {
    const today = new Date();
    const pastDate = new Date();
    pastDate.setDate(today.getDate() - days);
    
    document.getElementById('date_from').value = pastDate.toISOString().split('T')[0];
    document.getElementById('date_to').value = today.toISOString().split('T')[0];
}

function toggleAllCalculations() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const calculationCheckboxes = document.querySelectorAll('.calculation-checkbox');
    
    calculationCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

function previewExport() {
    const form = document.getElementById('exportForm');
    const formData = new FormData(form);
    formData.append('preview', '1');
    
    // Show loading state
    const previewBtn = document.querySelector('button[onclick="previewExport()"]');
    const originalText = previewBtn.innerHTML;
    previewBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading Preview...';
    previewBtn.disabled = true;
    
    fetch('{{ route("calculations.export") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            displayPreview(data.data);
            document.getElementById('recordCount').textContent = data.data.length + ' records';
        } else {
            alert('Error loading preview: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading preview: ' + error.message);
    })
    .finally(() => {
        // Restore button
        previewBtn.innerHTML = originalText;
        previewBtn.disabled = false;
    });
}

function displayPreview(data) {
    const container = document.getElementById('previewContainer');
    
    if (data.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 text-muted">
                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                <p>No calculations found for the selected criteria</p>
            </div>
        `;
        return;
    }
    
    let table = `
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Area (m²)</th>
                        <th>Plants</th>
                        <th>Spacing</th>
                        <th>Saved</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    data.forEach(calc => {
        table += `
            <tr>
                <td>${new Date(calc.created_at).toLocaleDateString()}</td>
                <td>${calc.calculation_name}</td>
                <td>
                    <span class="badge bg-${calc.calculation_type === 'square' ? 'primary' : (calc.calculation_type === 'quincunx' ? 'info' : 'warning')}">
                        ${calc.calculation_type || 'Square'}
                    </span>
                </td>
                <td>${parseFloat(calc.total_area).toFixed(1)}</td>
                <td>${parseInt(calc.total_plants).toLocaleString()}</td>
                <td>${calc.plant_spacing}${calc.plant_spacing_unit || 'm'}</td>
                <td>
                    ${calc.is_saved ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-muted"></i>'}
                </td>
            </tr>
        `;
    });
    
    table += `
                </tbody>
            </table>
        </div>
    `;
    
    container.innerHTML = table;
}

// Initialize form
document.getElementById('exportForm').addEventListener('submit', function(e) {
    // Check if any calculations are selected
    const selectedCalculations = document.querySelectorAll('.calculation-checkbox:checked');
    if (selectedCalculations.length === 0) {
        e.preventDefault();
        alert('Please select at least one saved calculation to export.');
        return false;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
    submitBtn.disabled = true;
    
    // Re-enable button after 3 seconds (in case of download)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});
</script>
@endpush