@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-dashboard text-white" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">{{ $data['totalCalculations'] ?? 156 }}</h4>
                            <p class="card-text mb-0">Total Calculations</p>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-calculator fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-dashboard text-white" style="background: linear-gradient(135deg, #17a2b8, #6f42c1);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">{{ $data['plantTypes'] ?? 23 }}</h4>
                            <p class="card-text mb-0">Plant Types</p>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-seedling fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-dashboard text-white" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">{{ number_format($data['plantsCalculated'] ?? 12450) }}</h4>
                            <p class="card-text mb-0">Plants Calculated</p>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-leaf fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-dashboard text-white" style="background: linear-gradient(135deg, #dc3545, #e83e8c);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">{{ $data['totalAreaPlanned'] ?? '8.5 ha' }}</h4>
                            <p class="card-text mb-0">Total Area Planned</p>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-map-marked-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-8 mb-4">
            <div class="card card-dashboard">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('planting.calculator') }}" class="btn btn-plant btn-lg">
                                    <i class="fas fa-calculator me-2"></i>
                                    <div>Square Planting</div>
                                    <small>Standard grid calculator</small>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('quincunx.calculator') }}" class="btn btn-success btn-lg">
                                    <i class="fas fa-th-large me-2"></i>
                                    <div>Quincunx Planting</div>
                                    <small>Optimized spacing pattern</small>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('triangular.calculator') }}" class="btn btn-info btn-lg">
                                    <i class="fas fa-play me-2"></i>
                                    <div>Triangular Planting</div>
                                    <small>Hexagonal pattern layout</small>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-outline-info btn-lg">
                                    <i class="fas fa-map me-2"></i>
                                    <div>Garden Planner</div>
                                    <small>Design your garden</small>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-history me-2"></i>
                                    <div>Recent Calculations</div>
                                    <small>View calculation history</small>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-outline-warning btn-lg">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    <div>Reports</div>
                                    <small>Generate reports</small>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-tools me-2"></i>
                                    <div>Tools</div>
                                    <small>Additional tools</small>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mb-4">
            <div class="card card-dashboard">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock text-primary me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        @forelse($data['recentCalculations'] ?? [] as $calculation)
                        <div class="activity-item d-flex align-items-start mb-3">
                            <div class="activity-icon me-3 mt-1">
                                <i class="fas fa-calculator text-success"></i>
                            </div>
                            <div class="activity-content">
                                <p class="mb-1">
                                    @if($calculation->plant_type)
                                        {{ $calculation->plant_type }} calculation
                                    @else
                                        New calculation
                                    @endif
                                    ({{ number_format($calculation->total_plants) }} plants)
                                </p>
                                <small class="text-muted">{{ $calculation->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-calculator fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No calculations yet</p>
                            <a href="{{ route('planting.calculator') }}" class="btn btn-plant btn-sm">
                                <i class="fas fa-plus me-1"></i>Start Calculating
                            </a>
                        </div>
                        @endforelse
                    </div>
                    
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-primary btn-sm">
                            View All Activity
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Content Row -->
    <div class="row">
        <!-- Popular Plants -->
        <div class="col-lg-6 mb-4">
            <div class="card card-dashboard">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-star text-warning me-2"></i>Popular Plants
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                @forelse($data['popularPlants'] ?? [] as $index => $plant)
                                    @php
                                        $colors = ['success', 'info', 'warning', 'primary', 'secondary'];
                                        $color = $colors[$index % count($colors)];
                                    @endphp
                                    <tr>
                                        <td class="align-middle">
                                            <i class="fas fa-seedling text-{{ $color }} me-2"></i>
                                            {{ $plant->plant_type ?? 'Unknown Plant' }}
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-{{ $color }}">{{ $plant->calculations_count }} calculations</span>
                                            <br><small class="text-muted">{{ number_format($plant->total_plants) }} plants</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4">
                                            <i class="fas fa-seedling fa-2x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">No plant calculations yet</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips & Tricks -->
        <div class="col-lg-6 mb-4">
            <div class="card card-dashboard">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb text-warning me-2"></i>Tips & Tricks
                    </h5>
                </div>
                <div class="card-body">
                    <div class="tip-item mb-3 p-3 bg-light rounded">
                        <h6 class="mb-2"><i class="fas fa-info-circle text-info me-2"></i>Optimal Spacing</h6>
                        <p class="mb-0 small">Consider plant mature size when calculating spacing to ensure proper growth.</p>
                    </div>
                    
                    <div class="tip-item mb-3 p-3 bg-light rounded">
                        <h6 class="mb-2"><i class="fas fa-chart-line text-success me-2"></i>Border Planning</h6>
                        <p class="mb-0 small">Leave adequate border space for maintenance and harvesting access.</p>
                    </div>
                    
                    <div class="tip-item p-3 bg-light rounded">
                        <h6 class="mb-2"><i class="fas fa-calendar text-primary me-2"></i>Seasonal Planning</h6>
                        <p class="mb-0 small">Plan your garden layout considering seasonal planting schedules.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.activity-item {
    border-left: 3px solid transparent;
    padding-left: 15px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background-color: #f8f9fa;
    border-left-color: var(--plant-green);
}

.tip-item {
    transition: transform 0.2s ease;
}

.tip-item:hover {
    transform: translateY(-2px);
}

.btn-lg {
    height: auto;
    padding: 15px;
    text-align: center;
}

.btn-lg div {
    font-weight: 600;
    margin-bottom: 5px;
}

.btn-lg small {
    font-size: 0.8rem;
    opacity: 0.8;
}
</style>
@endpush
@endsection
