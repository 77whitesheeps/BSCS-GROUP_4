<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Square Planting System Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2e7d32;
            --secondary-color: #4caf50;
            --accent-color: #8bc34a;
            --dark-color: #1b5e20; 
            --light-color: #c8e6c9; 
            --warning-color: #ff9800;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .calculator-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            padding: 2rem;
            max-width: 1100px;
        }
        
        .header {
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 1rem;
            margin-bottom: 1.2rem;
        }
        
        .btn-calculate {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 2rem;
            font-weight: 600;
        }
        
        .btn-calculate:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
        }
        
        .form-label {
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .input-group-text {
            background-color: var(--light-color);
            border-color: #ced4da;
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        
        .results-container {
            background: linear-gradient(135deg, var(--light-color), #e8f5e8);
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .result-card {
            background-color: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .result-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .result-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .spacing-inputs {
            display: flex;
            gap: 1rem;
        }
        
        .spacing-input {
            flex: 1;
        }
        
        .auto-border-info {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .visualization-container {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .plant-dot {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .plant-dot:hover {
            transform: scale(1.2);
            z-index: 10;
        }
        
        .plant-row {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .plant-row:nth-child(even) {
            animation-delay: 0.1s;
        }
        
        .plant-row:nth-child(odd) {
            animation-delay: 0.2s;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
            
            .spacing-inputs {
                flex-direction: column;
            }
            
            .export-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container calculator-container">
        <div class="header">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="mb-1">🌱 Square Planting System Calculator</h1>
                    <p class="text-muted mb-0">Optimize your planting layout with square spacing pattern</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" onclick="resetForm()" class="btn btn-outline-secondary">
                        Reset
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-success">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(isset($success))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ $success }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Calculator Form -->
        <form method="POST" action="{{ route('calculate.plants') }}" id="plantingForm">
            @csrf
            
            <!-- Plant Type Field -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="plantType" class="form-label">Plant Type</label>
                        <select class="form-select" id="plantType" name="plantType" required>
                            <option value="">Select plant type</option>
                            <option value="Vegetables" {{ old('plantType', isset($inputs) ? $inputs['plantType'] : '') == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                            <option value="Fruits" {{ old('plantType', isset($inputs) ? $inputs['plantType'] : '') == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                            <option value="Herbs" {{ old('plantType', isset($inputs) ? $inputs['plantType'] : '') == 'Herbs' ? 'selected' : '' }}>Herbs</option>
                            <option value="Flowers" {{ old('plantType', isset($inputs) ? $inputs['plantType'] : '') == 'Flowers' ? 'selected' : '' }}>Flowers</option>
                            <option value="Trees" {{ old('plantType', isset($inputs) ? $inputs['plantType'] : '') == 'Trees' ? 'selected' : '' }}>Trees</option>
                            <option value="Shrubs" {{ old('plantType', isset($inputs) ? $inputs['plantType'] : '') == 'Shrubs' ? 'selected' : '' }}>Shrubs</option>
                            <option value="Grains" {{ old('plantType', isset($inputs) ? $inputs['plantType'] : '') == 'Grains' ? 'selected' : '' }}>Grains</option>
                            <option value="Other" {{ old('plantType', isset($inputs) ? $inputs['plantType'] : '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="areaLength" class="form-label">
                            Area Length
                            <span class="info-tooltip">
                                <i class="bi bi-info-circle info-icon"></i>
                                <span class="tooltip-text">The total length of your planting area</span>
                            </span>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="areaLength" name="areaLength" step="0.01" min="0.01" required value="{{ old('areaLength', isset($inputs) ? $inputs['areaLength'] : '10') }}">
                            <select class="form-select" id="lengthUnit" name="lengthUnit">
                                <option value="m" {{ old('lengthUnit', isset($inputs) ? $inputs['lengthUnit'] : 'm') == 'm' ? 'selected' : '' }}>Meters (m)</option>
                                <option value="ft" {{ old('lengthUnit', isset($inputs) ? $inputs['lengthUnit'] : 'm') == 'ft' ? 'selected' : '' }}>Feet (ft)</option>
                                <option value="cm" {{ old('lengthUnit', isset($inputs) ? $inputs['lengthUnit'] : 'm') == 'cm' ? 'selected' : '' }}>Centimeters (cm)</option>
                                <option value="in" {{ old('lengthUnit', isset($inputs) ? $inputs['lengthUnit'] : 'm') == 'in' ? 'selected' : '' }}>Inches (in)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="areaWidth" class="form-label">
                            Area Width
                            <span class="info-tooltip">
                                <i class="bi bi-info-circle info-icon"></i>
                                <span class="tooltip-text">The total width of your planting area</span>
                            </span>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="areaWidth" name="areaWidth" step="0.01" min="0.01" required value="{{ old('areaWidth', isset($inputs) ? $inputs['areaWidth'] : '8') }}">
                            <select class="form-select" id="widthUnit" name="widthUnit">
                                <option value="m" {{ old('widthUnit', isset($inputs) ? $inputs['widthUnit'] : 'm') == 'm' ? 'selected' : '' }}>Meters (m)</option>
                                <option value="ft" {{ old('widthUnit', isset($inputs) ? $inputs['widthUnit'] : 'm') == 'ft' ? 'selected' : '' }}>Feet (ft)</option>
                                <option value="cm" {{ old('widthUnit', isset($inputs) ? $inputs['widthUnit'] : 'm') == 'cm' ? 'selected' : '' }}>Centimeters (cm)</option>
                                <option value="in" {{ old('widthUnit', isset($inputs) ? $inputs['widthUnit'] : 'm') == 'in' ? 'selected' : '' }}>Inches (in)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="plantSpacing" class="form-label">
                            Plant Spacing
                            <span class="info-tooltip">
                                <i class="bi bi-info-circle info-icon"></i>
                                <span class="tooltip-text">Distance between plants in the same row and between rows (square pattern)</span>
                            </span>
                        </label>
                        <div class="spacing-inputs">
                            <div class="spacing-input">
                                <label class="form-label small">Between Plants</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" required value="{{ old('plantSpacing', isset($inputs) ? $inputs['plantSpacing'] : '0.3') }}">
                                    <span class="input-group-text">m</span>
                                </div>
                            </div>
                            <div class="spacing-input">
                                <label class="form-label small">Between Rows</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="rowSpacing" name="rowSpacing" step="0.01" min="0.01" required value="{{ old('rowSpacing', isset($inputs) ? $inputs['rowSpacing'] : '0.3') }}">
                                    <span class="input-group-text">m</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="borderSpacing" class="form-label">
                            Border Spacing
                            <span class="info-tooltip">
                                <i class="bi bi-info-circle info-icon"></i>
                                <span class="tooltip-text">Space to leave around the edges of the planting area</span>
                            </span>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="borderSpacing" name="borderSpacing" step="0.01" min="0" value="{{ old('borderSpacing', isset($inputs) ? $inputs['borderSpacing'] : '0.5') }}" required>
                            <select class="form-select" id="borderUnit" name="borderUnit">
                                <option value="m" {{ old('borderUnit', isset($inputs) ? $inputs['borderUnit'] : 'm') == 'm' ? 'selected' : '' }}>Meters (m)</option>
                                <option value="ft" {{ old('borderUnit', isset($inputs) ? $inputs['borderUnit'] : 'm') == 'ft' ? 'selected' : '' }}>Feet (ft)</option>
                                <option value="cm" {{ old('borderUnit', isset($inputs) ? $inputs['borderUnit'] : 'm') == 'cm' ? 'selected' : '' }}>Centimeters (cm)</option>
                                <option value="in" {{ old('borderUnit', isset($inputs) ? $inputs['borderUnit'] : 'm') == 'in' ? 'selected' : '' }}>Inches (in)</option>
                            </select>
                        </div>
                        <div class="auto-border-info">
                            <input type="checkbox" id="autoBorder" name="autoBorder" value="1" {{ old('autoBorder', isset($inputs) ? $inputs['autoBorder'] : true) ? 'checked' : '' }}> 
                            <label for="autoBorder">Auto-calculate border spacing based on plant spacing</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-calculate btn-lg">
                    <i class="fas fa-calculator me-2"></i>Calculate Plants
                </button>
            </div>
        </form>
        
        <!-- Results Section -->
        @if(isset($results))
        <div class="results-container">
            <h3 class="text-center mb-4">🌱 Calculation Results</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="result-card text-center">
                        <div class="result-label">Total Plants</div>
                        <div class="result-value">{{ number_format($results['totalPlants']) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="result-card text-center">
                        <div class="result-label">Plants per Row</div>
                        <div class="result-value">{{ $results['plantsPerRow'] }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="result-card text-center">
                        <div class="result-label">Number of Rows</div>
                        <div class="result-value">{{ $results['numberOfRows'] }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="result-card text-center">
                        <div class="result-label">Effective Area</div>
                        <div class="result-value">{{ $results['effectiveArea'] }}m²</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="result-card text-center">
                        <div class="result-label">Plant Density</div>
                        <div class="result-value">{{ $results['plantingDensity'] }}/m²</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="result-card text-center">
                        <div class="result-label">Space Utilization</div>
                        <div class="result-value">{{ $results['spaceUtilization'] }}%</div>
                    </div>
                </div>
                <div class="result-card">
                    <div class="card-label">Effective Area</div>
                    <div class="card-value" id="effectiveArea">0 m²</div>
                </div>
                <div class="result-card">
                    <div class="card-label">Planting Density</div>
                    <div class="card-value" id="plantingDensity">0 plants/m²</div>
                </div>
                <div class="result-card">
                    <div class="card-label">Space Utilization</div>
                    <div class="card-value" id="spaceUtilization">0%</div>
                </div>
            </div>
            
            <div class="export-buttons">
                <button type="button" id="exportPdfBtn" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Export as PDF
                </button>
                <button type="button" id="exportCsvBtn" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export as CSV
                </button>
                <button type="button" id="printBtn" class="btn btn-outline-primary">
                    <i class="bi bi-printer"></i> Print Results
                </button>
            </div>
        </div>

        <!-- Visualization Area -->
        <div class="visualization-container mt-4">
            <h4 class="mb-3">Plant Layout Visualization</h4>
            <div class="visualization" id="visualization" style="min-height: 300px; border: 2px solid #28a745; border-radius: 8px; position: relative; background: linear-gradient(45deg, #f0f8f0 25%, #e8f5e8 25%, #e8f5e8 50%, #f0f8f0 50%, #f0f8f0 75%, #e8f5e8 75%), linear-gradient(45deg, #f0f8f0 25%, #e8f5e8 25%, #e8f5e8 50%, #f0f8f0 50%, #f0f8f0 75%, #e8f5e8 75%); background-size: 20px 20px; background-position: 0 0, 10px 10px; padding: 20px;">
                <div class="text-center mb-3">
                    <h5 class="text-success">{{ $results['totalPlants'] }} Plants Layout</h5>
                    <p class="small text-muted">{{ $results['plantsPerRow'] }} plants per row × {{ $results['numberOfRows'] }} rows</p>
                </div>
                
                <div class="plant-grid mx-auto" style="max-width: 600px; max-height: 400px; overflow: auto; border: 1px solid #e0e0e0; border-radius: 8px; padding: 10px;">
                    @php
                        // Show the full grid - no artificial limits like other calculators
                        $totalRows = $results['numberOfRows'];
                        $totalCols = $results['plantsPerRow'];
                        
                        // Calculate appropriate dot size based on available space and number of plants
                        $maxWidth = 580; // Available width minus padding
                        $maxHeight = 380; // Available height minus padding
                        
                        $dotSize = min(
                            floor($maxWidth / ($totalCols + 1)), // Space based on width
                            floor($maxHeight / ($totalRows + 1)), // Space based on height
                            20 // Maximum dot size
                        );
                        $dotSize = max($dotSize, 4); // Minimum dot size
                        
                        $gapX = max($dotSize * 0.3, 2);
                        $gapY = max($dotSize * 0.3, 2);
                    @endphp
                    
                    <div class="grid-container" style="display: flex; flex-direction: column; gap: {{ $gapY }}px; align-items: center; justify-content: center;">
                        @for($row = 0; $row < $totalRows; $row++)
                            <div class="plant-row" style="display: flex; gap: {{ $gapX }}px; align-items: center;">
                                @for($col = 0; $col < $totalCols; $col++)
                                    @if($row % 2 == 0)
                                        <!-- Regular Row - Green dots -->
                                        <div class="plant-dot" style="width: {{ $dotSize }}px; height: {{ $dotSize }}px; background: #28a745; border-radius: 50%; border: 1px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); flex-shrink: 0;"></div>
                                    @else
                                        <!-- Offset Row - Blue dots -->
                                        <div class="plant-dot" style="width: {{ $dotSize }}px; height: {{ $dotSize }}px; background: #007bff; border-radius: 50%; border: 1px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); flex-shrink: 0;"></div>
                                    @endif
                                @endfor
                            </div>
                        @endfor
                    </div>
                    
                    <!-- Full grid information -->
                    <p class="text-center text-muted small mt-3">
                        Complete layout: {{ $totalCols }} × {{ $totalRows }} = {{ $results['totalPlants'] }} plants
                    </p>
                    
                    <!-- Legend -->
                    <div class="mt-3 d-flex justify-content-center gap-3">
                        <div class="d-flex align-items-center gap-1">
                            <div style="width: 12px; height: 12px; background: #28a745; border-radius: 50%; border: 1px solid #fff;"></div>
                            <small class="text-muted">Regular Row</small>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <div style="width: 12px; height: 12px; background: #007bff; border-radius: 50%; border: 1px solid #fff;"></div>
                            <small class="text-muted">Offset Row</small>
                        </div>
                    </div>
                </div>
                
                <div class="layout-details mt-3 text-center">
                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-muted">Plant Spacing</small>
                            <p class="mb-1"><strong>{{ $results['plantSpacing'] }}m</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Row Spacing</small>
                            <p class="mb-1"><strong>{{ $results['rowSpacing'] }}m</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Effective Area</small>
                            <p class="mb-1"><strong>{{ $results['effectiveArea'] }}m²</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="visualization-container mt-4">
            <h4 class="mb-3">Plant Layout Visualization</h4>
            <div class="visualization" id="visualization" style="min-height: 300px; border: 2px dashed #ccc; border-radius: 8px; position: relative; background: #f8f9fa;">
                <div class="text-center text-muted p-5">
                    <i class="fas fa-calculator fa-3x mb-3"></i>
                    <p>Visualization will appear here after calculation</p>
                    <p class="small">The square pattern arranges plants in straight rows and columns</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function resetForm() {
            document.getElementById('plantingForm').reset();
            // Reset to default values
            document.getElementById('areaLength').value = '10';
            document.getElementById('areaWidth').value = '8';
            document.getElementById('plantSpacing').value = '0.3';
            document.getElementById('rowSpacing').value = '0.3';
            document.getElementById('borderSpacing').value = '0.5';
            document.getElementById('autoBorder').checked = true;
        }

        // Auto border calculation
        document.getElementById('autoBorder').addEventListener('change', function() {
            if (this.checked) {
                const plantSpacing = parseFloat(document.getElementById('plantSpacing').value) || 0.3;
                document.getElementById('borderSpacing').value = plantSpacing;
            }
        });

        // Update border spacing when plant spacing changes
        document.getElementById('plantSpacing').addEventListener('input', function() {
            if (document.getElementById('autoBorder').checked) {
                document.getElementById('borderSpacing').value = this.value;
            }
        });
    </script>
</body>
</html>