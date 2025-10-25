@extends('layouts.app')

@section('title', 'Calculation History')
@section('page-title', 'Calculation History')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">History</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header with Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    <div class="row">
                        <!-- Total Calculations -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-primary text-white rounded">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-calculator fa-2x"></i>
                                </div>
                                <div>
                                    <div class="h5 mb-0">{{ $stats['total'] ?? 0 }}</div>
                                    <div class="small">Total Calculations</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Total Plants -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-success text-white rounded">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-seedling fa-2x"></i>
                                </div>
                                <div>
                                    <div class="h5 mb-0">{{ number_format($stats['total_plants'] ?? 0) }}</div>
                                    <div class="small">Plants Calculated</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Total Area -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-info text-white rounded">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-map fa-2x"></i>
                                </div>
                                <div>
                                    <div class="h5 mb-0">{{ number_format($stats['total_area'] ?? 0, 2) }}m²</div>
                                    <div class="small">Total Area Planned</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Average Plants -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-warning text-white rounded">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-chart-bar fa-2x"></i>
                                </div>
                                <div>
                                    <div class="h5 mb-0">{{ number_format($stats['avg_plants'] ?? 0) }}</div>
                                    <div class="small">Avg Plants/Calculation</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    <form method="GET" action="{{ route('calculations.history') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Date Filter</label>
                            <select name="date_filter" class="form-select">
                                <option value="all" {{ $dateFilter == 'all' ? 'selected' : '' }}>All Time</option>
                                <option value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ $dateFilter == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ $dateFilter == 'month' ? 'selected' : '' }}>This Month</option>
                                <option value="year" {{ $dateFilter == 'year' ? 'selected' : '' }}>This Year</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Calculation Type</label>
                            <select name="calculation_type" class="form-select">
                                <option value="all" {{ $calculationType == 'all' ? 'selected' : '' }}>All Types</option>
                                <option value="square" {{ $calculationType == 'square' ? 'selected' : '' }}>Square Planting</option>
                                <option value="quincunx" {{ $calculationType == 'quincunx' ? 'selected' : '' }}>Quincunx Planting</option>
                                <option value="triangular" {{ $calculationType == 'triangular' ? 'selected' : '' }}>Triangular Planting</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Search calculations..." value="{{ $search }}">
                        </div>
                        
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('calculations.history') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-refresh"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculations List -->
    <div class="row">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Recent Calculations
                    </h5>
                    <div>
                        <a href="{{ route('calculations.export') }}?format=csv&date_filter={{ $dateFilter }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($calculations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Plant Type</th>
                                        <th>Area</th>
                                        <th>Plants</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calculations as $calculation)
                                        <tr>
                                            <td>
                                                <div class="small text-muted">
                                                    {{ $calculation->created_at->setTimezone('Asia/Singapore')->format('M j, Y') }}
                                                </div>
                                                <div class="small">
                                                    {{ $calculation->created_at->setTimezone('Asia/Singapore')->format('g:i A') }}
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $calculation->calculation_name ?? 'Unnamed' }}</strong>
                                                @if($calculation->is_saved)
                                                    <span class="badge bg-success ms-1">Saved</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $calculation->calculation_type === 'square' ? 'primary' : ($calculation->calculation_type === 'quincunx' ? 'info' : 'warning') }}">
                                                    {{ ucfirst($calculation->calculation_type ?? 'Square') }}
                                                </span>
                                            </td>
                                            <td>{{ $calculation->plant_type ?? 'Not specified' }}</td>
                                            <td>
                                                {{ $calculation->area_length }}×{{ $calculation->area_width }}
                                                <small class="text-muted">({{ number_format($calculation->total_area, 2) }}m²)</small>
                                            </td>
                                            <td>
                                                <strong>{{ number_format($calculation->total_plants) }}</strong> plants
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    @if(!$calculation->is_saved)
                                                        <button type="button" class="btn btn-outline-success" onclick="saveCalculation({{ $calculation->id }})">
                                                            <i class="fas fa-save"></i>
                                                        </button>
                                                    @endif
                                                    <button type="button" class="btn btn-outline-danger" onclick="deleteCalculation({{ $calculation->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                                <div class="text-muted small order-2 order-md-1">
                                    @php
                                        $from = ($calculations->currentPage() - 1) * $calculations->perPage() + 1;
                                        $to = min($calculations->currentPage() * $calculations->perPage(), $calculations->total());
                                    @endphp
                                    Showing {{ $calculations->total() ? $from : 0 }} to {{ $calculations->total() ? $to : 0 }} of {{ $calculations->total() }} results
                                </div>
                                <div class="order-1 order-md-2">
                                    {{ $calculations->onEachSide(1)->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h5>No calculations found</h5>
                            <p class="text-muted">Start creating some calculations to see your history here.</p>
                            <a href="{{ route('planting.calculator') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Calculation
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save Calculation Modal -->
<div class="modal fade" id="saveCalculationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="saveCalculationForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Save Calculation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Calculation Name</label>
                        <input type="text" name="calculation_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Calculation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
/* Ensure pagination icons have sensible size and avoid huge SVGs */
.pagination .page-link { font-size: 0.95rem; line-height: 1.25; }
.pagination .page-item.disabled .page-link { color: #6c757d; }
</style>
<script>
function saveCalculation(id) {
    document.getElementById('saveCalculationForm').action = `/calculations/${id}/save`;
    new bootstrap.Modal(document.getElementById('saveCalculationModal')).show();
}

function deleteCalculation(id) {
    if (confirm('Are you sure you want to delete this calculation?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/calculations/${id}`;
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        // Add DELETE method
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush