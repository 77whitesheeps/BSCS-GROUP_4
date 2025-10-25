@extends('layouts.app')

@section('title', 'Saved Calculations')
@section('page-title', 'Saved Calculations')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Saved Calculations</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">
                                <i class="fas fa-save text-success me-2"></i>
                                Your Saved Calculations
                            </h4>
                            <p class="text-muted mb-0 mt-1">Access your important calculations anytime</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('calculations.history') }}" class="btn btn-outline-primary">
                                <i class="fas fa-history"></i> View All History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Saved Calculations Grid -->
    <div class="row">
        @if($savedCalculations->count() > 0)
            @foreach($savedCalculations as $calculation)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-dashboard h-100">
                        <div class="card-header border-0 d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $calculation->calculation_name }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i>
                                    {{ $calculation->created_at->setTimezone('Asia/Singapore')->format('M j, Y g:i A') }}
                                </small>
                            </div>
                            <span class="badge bg-{{ $calculation->calculation_type === 'square' ? 'primary' : ($calculation->calculation_type === 'quincunx' ? 'info' : 'warning') }}">
                                {{ ucfirst($calculation->calculation_type ?? 'Square') }}
                            </span>
                        </div>
                        
                        <div class="card-body">
                            <!-- Calculation Details -->
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="h5 mb-0 text-primary">{{ number_format($calculation->total_plants) }}</div>
                                        <small class="text-muted">Plants</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="h5 mb-0 text-success">{{ number_format($calculation->total_area, 1) }}m²</div>
                                        <small class="text-muted">Area</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Area Dimensions -->
                            <div class="mb-3">
                                <small class="text-muted d-block">Dimensions</small>
                                <span class="fw-bold">{{ $calculation->area_length }} × {{ $calculation->area_width }}{{ $calculation->area_length_unit ?? 'm' }}</span>
                            </div>
                            
                            <!-- Plant Type -->
                            @if($calculation->plant_type)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Plant Type</small>
                                    <span class="fw-bold">{{ $calculation->plant_type }}</span>
                                </div>
                            @endif
                            
                            <!-- Spacing -->
                            <div class="mb-3">
                                <small class="text-muted d-block">Plant Spacing</small>
                                <span class="fw-bold">{{ $calculation->plant_spacing }}{{ $calculation->plant_spacing_unit ?? 'm' }}</span>
                            </div>
                            
                            <!-- Notes -->
                            @if($calculation->notes)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Notes</small>
                                    <p class="small mb-0">{{ $calculation->notes }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-footer border-0">
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-outline-primary" onclick="viewDetails({{ $calculation->id }})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="duplicateCalculation({{ $calculation->id }})">
                                    <i class="fas fa-copy"></i> Duplicate
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCalculation({{ $calculation->id }})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card card-dashboard">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-save fa-4x text-muted mb-4"></i>
                        <h4>No Saved Calculations</h4>
                        <p class="text-muted mb-4">You haven't saved any calculations yet. Create and save calculations to access them quickly later.</p>
                        <a href="{{ route('calculations.history') }}" class="btn btn-primary me-2">
                            <i class="fas fa-history"></i> View History
                        </a>
                        <a href="{{ route('planting.calculator') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus"></i> Create New Calculation
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if($savedCalculations->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                        {{ $savedCalculations->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Calculation Details Modal -->
<div class="modal fade" id="calculationDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Calculation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="calculationDetailsContent">
                <!-- Content loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewDetails(id) {
    // For now, show basic details. Can be enhanced to show full calculation details
    const calculation = @json($savedCalculations);
    const calc = calculation.data.find(c => c.id === id);
    
    if (calc) {
        let content = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Basic Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Name:</strong></td><td>${calc.calculation_name}</td></tr>
                        <tr><td><strong>Type:</strong></td><td>${calc.calculation_type || 'Square'}</td></tr>
                        <tr><td><strong>Created:</strong></td><td>${new Date(calc.created_at).toLocaleDateString()}</td></tr>
                        <tr><td><strong>Plant Type:</strong></td><td>${calc.plant_type || 'Not specified'}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Measurements</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Area:</strong></td><td>${calc.area_length} × ${calc.area_width}${calc.area_length_unit || 'm'}</td></tr>
                        <tr><td><strong>Plant Spacing:</strong></td><td>${calc.plant_spacing}${calc.plant_spacing_unit || 'm'}</td></tr>
                        <tr><td><strong>Total Plants:</strong></td><td>${calc.total_plants.toLocaleString()}</td></tr>
                        <tr><td><strong>Total Area:</strong></td><td>${calc.total_area}m²</td></tr>
                    </table>
                </div>
            </div>
        `;
        
        if (calc.notes) {
            content += `
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Notes</h6>
                        <p>${calc.notes}</p>
                    </div>
                </div>
            `;
        }
        
        document.getElementById('calculationDetailsContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('calculationDetailsModal')).show();
    }
}

function duplicateCalculation(id) {
    // This would redirect to calculator with pre-filled values
    alert('Duplicate functionality will be implemented to redirect to calculator with pre-filled values.');
}

function deleteCalculation(id) {
    if (confirm('Are you sure you want to delete this saved calculation?')) {
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