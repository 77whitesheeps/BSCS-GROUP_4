@extends('layouts.app')

@section('title', 'Monthly Report')
@section('page-title', 'Monthly Report')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Monthly Report</li>
@endsection

@push('styles')
    <!-- html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <style>
        /* Monthly Report Specific Styles */
        .report-header-card {
            background: linear-gradient(135deg, var(--plant-green), var(--plant-green-dark));
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .metric-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            background: var(--card-bg);
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .metric-card h3 {
            color: var(--plant-green);
            font-weight: bold;
            font-size: 2rem;
        }

        .card-dashboard {
            background: var(--card-bg);
            color: var(--text-color);
        }

        .card-header {
            background: var(--card-bg);
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
        }

        .card-header.bg-primary {
            background: linear-gradient(135deg, var(--plant-green), var(--plant-green-dark)) !important;
            color: white !important;
            border: none;
        }

        .list-group-item {
            background: var(--card-bg);
            color: var(--text-color);
            border-color: var(--border-color);
        }

        .table {
            color: var(--text-color);
        }

        .table td, .table th {
            border-color: var(--border-color);
        }

        .btn-plant {
            background-color: var(--plant-green);
            border-color: var(--plant-green);
            color: white;
        }

        .btn-plant:hover {
            background-color: var(--plant-green-dark);
            border-color: var(--plant-green-dark);
            color: white;
        }

        @media print {
            .btn-toolbar,
            .main-header,
            .main-sidebar,
            .main-footer,
            .breadcrumb {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0 !important;
                margin-top: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Action Toolbar -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Print
                </button>
                <button type="button" class="btn btn-sm btn-plant" id="downloadPdf">
                    <i class="fas fa-download me-1"></i> Download PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Report Generation Form -->
    <div class="card card-dashboard mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Report Configuration</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('monthly-report.generate') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="month" class="form-label">Select Month</label>
                    <input type="month" class="form-control" id="month" name="month" 
                           value="{{ date('Y-m') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Options</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeCharts" name="include_charts" value="1">
                        <label class="form-check-label" for="includeCharts">
                            Include Charts
                        </label>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-plant me-2">
                        <i class="fas fa-sync-alt me-1"></i>Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Monthly Report Content -->
    <div class="row report-section">
        <!-- Executive Summary -->
        <div class="col-12 mb-4">
            <div class="card card-dashboard report-header-card">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fas fa-chart-line me-2"></i>Plant-O-Matic Monthly Report</h4>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <strong><i class="fas fa-calendar-alt me-2"></i>Month:</strong> {{ $reportData['month'] }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong><i class="fas fa-user me-2"></i>Generated for:</strong> {{ $reportData['user'] }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong><i class="fas fa-check-circle me-2"></i>Status:</strong> 
                            <span class="badge bg-light text-dark">{{ $reportData['status'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="col-md-4 mb-4">
            <div class="card metric-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-map-marked-alt fa-3x mb-3" style="color: var(--plant-green);"></i>
                    <h3>{{ $reportData['total_area_planned'] }}</h3>
                    <p class="text-muted mb-0">Total Area Planned</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card metric-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-leaf fa-3x mb-3" style="color: var(--plant-green);"></i>
                    <h3>{{ $reportData['plants_calculated'] }}</h3>
                    <p class="text-muted mb-0">Plants Calculated</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card metric-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-seedling fa-3x mb-3" style="color: var(--plant-green);"></i>
                    <h3>{{ $reportData['plant_types_used'] }}</h3>
                    <p class="text-muted mb-0">Plant Types Used</p>
                </div>
            </div>
        </div>

        <!-- Calculation Overview -->
        <div class="col-md-6 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Calculation Overview</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <tbody>
                            <tr>
                                <td><i class="fas fa-list-ul me-2 text-muted"></i>Total Calculations</td>
                                <td class="text-end"><strong>{{ $reportData['total_calculations'] }}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-th me-2 text-success"></i>Square Planting</td>
                                <td class="text-end"><strong>{{ $reportData['square_planting_calculations'] }}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-th-large me-2 text-info"></i>Quincunx Planting</td>
                                <td class="text-end"><strong>{{ $reportData['quincunx_planting_calculations'] }}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-play me-2 text-primary"></i>Triangular Planting</td>
                                <td class="text-end"><strong>{{ $reportData['triangular_planting_calculations'] }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Activity Summary -->
        <div class="col-md-6 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Activity Summary</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-tools me-2 text-primary"></i>Most Used Tool:</strong> 
                        <span class="badge bg-success">{{ $reportData['most_used_tool'] }}</span>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-file-alt me-2 text-info"></i>Reports Generated:</strong> 
                        <span class="text-muted">{{ $reportData['reports_generated'] }}</span>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-map me-2 text-success"></i>Garden Plans Created:</strong> 
                        <span class="text-muted">{{ $reportData['garden_plans_created'] }}</span>
                    </div>
                    
                    @if(!empty($reportData['recent_calculations']))
                    <h6 class="mt-3 mb-2"><i class="fas fa-clock me-2"></i>Recent Calculations:</h6>
                    <ul class="list-unstyled small">
                        @foreach($reportData['recent_calculations'] as $calculation)
                        <li class="mb-2 pb-2 border-bottom">
                            <i class="fas fa-calendar-day me-2 text-muted"></i>{{ $calculation['date'] }} - 
                            <strong>{{ $calculation['type'] }}</strong> ({{ $calculation['area'] }})
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Popular Plants -->
        <div class="col-md-6 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-star me-2"></i>Popular Plants This Month</h6>
                </div>
                <div class="card-body">
                    @if(!empty($reportData['popular_plants']))
                    <ol class="list-group list-group-numbered">
                        @foreach($reportData['popular_plants'] as $plant)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $plant['name'] }}</div>
                            </div>
                            <span class="badge rounded-pill" style="background-color: var(--plant-green);">{{ $plant['calculations'] }}</span>
                        </li>
                        @endforeach
                    </ol>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>No plant data available for this period.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tips & Tricks -->
        <div class="col-md-6 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #ffc107, #fd7e14); color: white;">
                    <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips & Tricks</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach($reportData['tips'] as $tip)
                        <li class="mb-3 pb-3 border-bottom">
                            <i class="fas fa-check-circle me-2" style="color: var(--plant-green);"></i>
                            {{ $tip }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Downloads Section -->
        <div class="col-12 mb-4">
            <div class="card card-dashboard">
                <div class="card-body text-center py-4">
                    <i class="fas fa-download fa-3x mb-3" style="color: var(--plant-green);"></i>
                    <h3 class="mb-2" style="color: var(--plant-green);">{{ $reportData['total_downloads'] }}</h3>
                    <p class="text-muted mb-0">Total plans downloaded this month</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Toolbar PDF download functionality (clean version)
    const downloadBtn = document.getElementById('downloadPdf');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function() {
            const toolbar = document.querySelector('.btn-toolbar');
            const actionBar = document.querySelector('.d-flex.justify-content-between');
            const element = document.querySelector('.report-section');
                    
            // Hide toolbar and action bar temporarily
            if (toolbar) toolbar.style.display = 'none';
            if (actionBar) actionBar.style.display = 'none';

            const opt = {
                margin: 0.5,
                filename: 'monthly-report-' + new Date().toISOString().slice(0, 10) + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                // Restore toolbar and action bar after saving
                if (toolbar) toolbar.style.display = '';
                if (actionBar) actionBar.style.display = '';
            });
        });
    }

    // Auto-refresh report data (optional)
    const autoRefresh = false; // Set to true if you want auto-refresh
    if (autoRefresh) {
        setInterval(function() {
            fetch("{{ route('monthly-report.api') }}")
                .then(response => response.json())
                .then(data => {
                    console.log('Report data updated:', data);
                })
                .catch(error => {
                    console.log('Failed to refresh report data:', error);
                });
        }, 60000); // Refresh every 60 seconds
    }
</script>
@endpush