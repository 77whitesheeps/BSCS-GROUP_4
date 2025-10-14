<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Report - Plant-O-Matic</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom CSS from Dashboard -->
    <style>
        :root {
            --plant-green: #68af2c;
            --plant-green-dark: #5a9625;
            --plant-green-light: #eaf5e1;
            --sidebar-width: 250px;
            --header-height: 60px;
            --footer-height: 50px;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header Styles */
        .main-header {
            height: var(--header-height);
            background: linear-gradient(135deg, var(--plant-green), var(--plant-green-dark));
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .main-header .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .main-header .navbar-nav .nav-link {
            color: white !important;
        }

        .main-header .navbar-nav .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Sidebar Styles (not directly used here, but variables are) */
        .main-sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: white;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
            z-index: 1020;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .main-sidebar {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #f1f3f4;
        }

        .sidebar-menu li a {
            display: block;
            padding: 15px 20px;
            color: #495057;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li.active a {
            background: var(--plant-green-light);
            color: var(--plant-green);
            border-right: 3px solid var(--plant-green);
        }

        .sidebar-menu li a i {
            width: 20px;
            margin-right: 10px;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 0; /* No sidebar on this page */
            margin-top: var(--header-height);
            min-height: calc(100vh - var(--header-height) - var(--footer-height));
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* Footer Styles */
        .main-footer {
            margin-left: 0; /* No sidebar on this page */
            margin-top: 0;
            height: var(--footer-height);
            background: white;
            border-top: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        /* Custom Components */
        .card-dashboard {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .card-dashboard:hover {
            transform: translateY(-2px);
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

        .alert-dismissible .btn-close {
            padding: 0.5rem 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <main class="main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <h1 class="h2">Monthly Report</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="downloadPdf">
                                <i class="fas fa-download"></i> Download PDF
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Report Generation Form -->
                <div class="card mb-4">
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
                                <button type="submit" class="btn btn-primary me-2">Generate Report</button>
                                <button type="submit" name="download" value="1" class="btn btn-success">
                                    Download PDF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Monthly Report Content -->
                <div class="row">
                    <!-- Executive Summary -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">Plant-O-Matic Monthly Report</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Month:</strong> {{ $reportData['month'] }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Generated for:</strong> {{ $reportData['user'] }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Status:</strong> 
                                        <span class="badge bg-success">{{ $reportData['status'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Key Metrics -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h3>{{ $reportData['total_area_planned'] }}</h3>
                                <p class="text-muted">Total Area Planned</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h3>{{ $reportData['plants_calculated'] }}</h3>
                                <p class="text-muted">Plants Calculated</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h3>{{ $reportData['plant_types_used'] }}</h3>
                                <p class="text-muted">Plant Types Used</p>
                            </div>
                        </div>
                    </div>

                    <!-- Calculation Overview -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Calculation Overview</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td>Total Calculations</td>
                                        <td class="text-end">{{ $reportData['total_calculations'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Square Planting</td>
                                        <td class="text-end">{{ $reportData['square_planting_calculations'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quincunx Planting</td>
                                        <td class="text-end">{{ $reportData['quincunx_planting_calculations'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Triangular Planting</td>
                                        <td class="text-end">{{ $reportData['triangular_planting_calculations'] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Summary -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Activity Summary</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Most Used Tool:</strong> {{ $reportData['most_used_tool'] }}</p>
                                <p><strong>Reports Generated:</strong> {{ $reportData['reports_generated'] }}</p>
                                <p><strong>Garden Plans Created:</strong> {{ $reportData['garden_plans_created'] }}</p>
                                
                                @if(!empty($reportData['recent_calculations']))
                                <h6 class="mt-3">Recent Calculations:</h6>
                                <ul class="list-unstyled">
                                    @foreach($reportData['recent_calculations'] as $calculation)
                                    <li class="mb-1">
                                        <small>{{ $calculation['date'] }} - {{ $calculation['type'] }} ({{ $calculation['area'] }})</small>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Popular Plants -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Popular Plants This Month</h6>
                            </div>
                            <div class="card-body">
                                @if(!empty($reportData['popular_plants']))
                                <ol class="list-group list-group-numbered">
                                    @foreach($reportData['popular_plants'] as $plant)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ $plant['name'] }}</div>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $plant['calculations'] }}</span>
                                    </li>
                                    @endforeach
                                </ol>
                                @else
                                <p class="text-muted">No plant data available for this period.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tips & Tricks -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Tips & Tricks</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    @foreach($reportData['tips'] as $tip)
                                    <li class="mb-2">
                                        <i class="fas fa-lightbulb text-warning me-2"></i>
                                        {{ $tip }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Downloads Section -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h4>{{ $reportData['total_downloads'] }} Downloads</h4>
                                <p class="text-muted">Total plans downloaded this month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.getElementById('downloadPdf').addEventListener('click', function() {
            const element = document.querySelector('.main-content');
            const opt = {
                margin:       0.5,
                filename:     'monthly-report.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        });

        // Auto-refresh report data
        setInterval(function() {
            fetch("{{ route('monthly-report.api') }}")
                .then(response => response.json())
                .then(data => {
                    // Update metrics dynamically
                    console.log('Report data updated:', data);
                });
        }, 30000); // Refresh every 30 seconds
    </script>
</body>
</html>