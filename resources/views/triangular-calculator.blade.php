<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Triangular Planting System Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2e7d32;
            --secondary-color: #4caf50;
            --accent-color: #8bc34a;
            --dark-color: #1b5e20;
            --light-color: #c8e6c9;
            --success-light: #d4edda;
            --danger-light: #f8d7da;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        
        .calculator-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            margin: 2rem auto;
            padding: 2rem;
            max-width: 1000px;
            transition: all 0.3s ease;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.8rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .input-group {
            margin-bottom: 1.2rem;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            transition: all 0.2s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(139, 195, 74, 0.25);
        }
        
        .btn-calculate {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-calculate:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        .btn-outline-secondary {
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            transform: translateY(-1px);
        }
        
        .results-container {
            background-color: var(--light-color);
            border-radius: 12px;
            padding: 1.8rem;
            margin-top: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 5px solid var(--primary-color);
        }
        
        .result-value {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .results-container h3 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }
        
        .visualization {
            background-color: white;
            border-radius: 12px;
            padding: 1.8rem;
            margin-top: 2rem;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e9ecef;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .plant-grid {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .plant-circle {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: absolute;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
            filter: drop-shadow(0 2px 3px rgba(0,0,0,0.2));
        }
        
        .plant-circle:hover {
            transform: translate(-50%, -50%) scale(1.4);
            z-index: 3;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }
        
        .plant-circle:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            white-space: nowrap;
            z-index: 4;
        }
        
        .pattern-title {
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255,255,255,0.95);
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #2e7d32;
            text-align: center;
        }
        
        .visualization-info {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
            text-align: center;
        }
        
        .visualization-summary {
            background: rgba(255,255,255,0.95);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            color: #555;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .spacing-inputs {
            display: flex;
            gap: 15px;
        }
        
        .spacing-input {
            flex: 1;
        }
        
        .auto-border-info {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 8px;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .pattern-legend {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            justify-content: center;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--secondary-color);
        }
        
        footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1.5rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
        }
        
        .alert-success {
            background-color: var(--success-light);
            color: #155724;
        }
        
        .alert-danger {
            background-color: var(--danger-light);
            color: #721c24;
        }
        
        .alert ul {
            margin-bottom: 0;
        }
        
        .layout-details {
            background-color: rgba(248, 249, 250, 0.8);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .plant-type-icon {
            font-size: 1.2rem;
            margin-right: 8px;
        }
        
        .pattern-info {
            background-color: #e8f5e9;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            border-left: 4px solid var(--primary-color);
        }
        
        .visualization-container {
            position: relative;
        }
        
        .pattern-comparison {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            justify-content: center;
        }
        
        .comparison-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
            padding: 5px 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.1;
            z-index: 1;
        }
        
        @media (max-width: 768px) {
            .calculator-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .header {
                padding: 1.5rem;
            }
            
            .visualization {
                height: 300px;
                padding: 1rem;
            }
            
            .spacing-inputs {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn-calculate {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .pattern-title {
                font-size: 0.8rem;
                padding: 8px 15px;
            }
        }

        /* Dark Theme Styles */
        body.dark-theme {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-theme .calculator-container {
            background-color: #1e1e1e;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
        }

        body.dark-theme .header {
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
        }

        body.dark-theme .form-label {
            color: #e0e0e0;
        }

        body.dark-theme .form-control,
        body.dark-theme .form-select {
            background-color: #2c2c2c;
            color: #e0e0e0;
            border-color: #444;
        }

        body.dark-theme .form-control:focus,
        body.dark-theme .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(139, 195, 74, 0.3);
            background-color: #333;
        }

        body.dark-theme .results-container {
            background-color: #2c2c2c;
            border-left-color: var(--accent-color);
        }

        body.dark-theme .results-container h3 {
            color: #fff;
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-theme .result-value {
            color: var(--accent-color);
        }

        body.dark-theme .visualization {
            background-color: #2c2c2c;
            border-color: #444;
        }
        
        body.dark-theme .visualization .text-muted {
             color: #a0a0a0 !important;
        }

        body.dark-theme .grid-line {
            background-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-theme .visualization-info {
            background: rgba(44, 44, 44, 0.9);
            color: #e0e0e0;
        }

        body.dark-theme .btn-outline-light {
            color: #f8f9fa;
            border-color: #f8f9fa;
        }

        body.dark-theme .btn-outline-light:hover {
            color: #121212;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }
        
        body.dark-theme .pattern-info {
            background-color: #2c2c2c;
            border-left-color: var(--accent-color);
        }
        
        body.dark-theme .pattern-info p, body.dark-theme .pattern-info h5 {
            color: #e0e0e0;
        }

        body.dark-theme .form-text {
            color: #a0a0a0;
        }

        body.dark-theme .auto-border-info, body.dark-theme .form-check-label {
            color: #a0a0a0;
        }

        body.dark-theme .alert-success {
            background-color: #2e7d32;
            color: #d4edda;
        }

        body.dark-theme .alert-danger {
            background-color: #721c24;
            color: #f8d7da;
        }

        body.dark-theme footer {
            color: #a0a0a0;
        }
        
        body.dark-theme .text-muted {
            color: #a0a0a0 !important;
        }
        
        body.dark-theme .border-bottom {
            border-bottom: 1px solid #444 !important;
        }

        body.dark-theme .plant-dot:hover {
            background-color: var(--accent-color);
        }
        
        body.dark-theme .plant-grid {
            background: linear-gradient(135deg, #2a2a2a, #1e1e1e);
        }
        
        body.dark-theme .pattern-title {
            background: rgba(44, 44, 44, 0.95);
            color: #e0e0e0;
        }
        
        body.dark-theme .visualization-summary {
            background: rgba(44, 44, 44, 0.95);
            color: #e0e0e0;
        }
        
        body.dark-theme .comparison-item {
            background: #2c2c2c;
            color: #e0e0e0;
        }
        
        body.dark-theme .alert-success {
            background-color: #2e7d32;
            color: #d4edda;
        }
        
        body.dark-theme .alert-danger {
            background-color: #721c24;
            color: #f8d7da;
        }
        
        /* Visualization layout fixes */
        .visualization-content {
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .visualization-grid {
            position: relative;
            width: 90%;
            height: 80%;
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }
        
        body.dark-theme .visualization-grid {
            background: #2c2c2c;
        }
    </style>
</head>
<body class="@if(Auth::check() && Auth::user()->theme === 'dark') dark-theme @endif">
    <div class="container calculator-container">
        <div class="header">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="mb-2"><i class="fas fa-play me-2"></i>Triangular Planting System Calculator</h1>
                    <p class="mb-0">Maximize planting density with triangular hexagonal pattern</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" onclick="resetForm()" class="btn btn-outline-light">
                        <i class="fas fa-redo-alt me-1"></i> Reset
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt me-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <div class="pattern-info">
            <h5><i class="fas fa-info-circle me-2"></i>About Triangular Planting</h5>
            <p class="mb-0">The triangular pattern arranges plants in equilateral triangles, creating a hexagonal layout. This is the most space-efficient planting pattern, allowing up to 15% more plants than square pattern and 30% more than rectangular pattern while maintaining optimal air circulation and light exposure.</p>
        </div>
        
        <!-- Success/Error Messages -->
        <div class="alert alert-success alert-dismissible fade show d-none" id="successAlert" role="alert">
            <i class="fas fa-check-circle me-2"></i><span id="successMessage">Calculation completed successfully!</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="alert alert-danger alert-dismissible fade show d-none" id="errorAlert" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0" id="errorList"></ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <form id="triangularForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="areaLength" class="form-label">Area Length</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="areaLength" name="areaLength" step="0.01" min="0.01" required value="10">
                            <select class="form-select" id="lengthUnit" name="lengthUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="areaWidth" class="form-label">Area Width</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="areaWidth" name="areaWidth" step="0.01" min="0.01" required value="8">
                            <select class="form-select" id="widthUnit" name="widthUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="plantType" class="form-label">Plant Type</label>
                        <select class="form-select" id="plantType" name="plantType">
                            <option value="vegetable">Vegetables</option>
                            <option value="fruit">Fruits</option>
                            <option value="herb">Herbs</option>
                            <option value="flower">Flowers</option>
                            <option value="tree">Trees</option>
                            <option value="shrub">Shrubs</option>
                            <option value="vine">Vines</option>
                            <option value="custom">Custom</option>
                        </select>
                        <div class="form-text">Selecting a plant type may suggest optimal spacing values</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="plantSpacing" class="form-label">Plant Spacing</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" required value="0.3">
                            <span class="input-group-text">m</span>
                        </div>
                        <input type="hidden" name="spacingUnit" value="m">
                        <div class="form-text">Distance between plants in triangular pattern</div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="borderSpacing" class="form-label">Border Spacing</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="borderSpacing" name="borderSpacing" step="0.01" min="0" value="0.5" required>
                            <select class="form-select" id="borderUnit" name="borderUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                        <div class="auto-border-info">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autoBorder" name="autoBorder" value="1" checked>
                                <label class="form-check-label" for="autoBorder">
                                    Auto-calculate border spacing based on plant spacing
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Planting Pattern</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pattern" id="triangularPattern" value="triangular" checked>
                                <label class="form-check-label" for="triangularPattern">
                                    <i class="fas fa-play me-1"></i> Triangular Pattern
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pattern" id="squarePattern" value="square">
                                <label class="form-check-label" for="squarePattern">
                                    <i class="fas fa-th-large me-1"></i> Square Pattern
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button type="button" id="calculateBtn" class="btn btn-calculate btn-lg">
                    <i class="fas fa-calculator me-2"></i> Calculate
                </button>
            </div>
        </form>
        
        <div class="results-container mt-4 d-none" id="resultsContainer">
            <h3 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Calculation Results</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><i class="fas fa-seedling me-2 text-success"></i>Number of Plants:</span>
                        <span class="result-value" id="totalPlants">0</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><i class="fas fa-list me-2 text-success"></i>Plants per Row:</span>
                        <span class="result-value" id="plantsPerRow">0</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><i class="fas fa-bars me-2 text-success"></i>Number of Rows:</span>
                        <span class="result-value" id="numberOfRows">0</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><i class="fas fa-ruler-combined me-2 text-success"></i>Effective Area:</span>
                        <span class="result-value" id="effectiveArea">0 m²</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><i class="fas fa-chart-pie me-2 text-success"></i>Planting Density:</span>
                        <span class="result-value" id="plantingDensity">0 plants/m²</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><i class="fas fa-percentage me-2 text-success"></i>Space Utilization:</span>
                        <span class="result-value" id="spaceUtilization">0%</span>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><i class="fas fa-leaf me-2 text-success"></i>Pattern Efficiency:</span>
                        <span class="result-value" id="patternEfficiency">0%</span>
                    </div>
                    <small class="text-muted">Compared to square planting pattern</small>
                </div>
            </div>
        </div>
        
        <!-- Visualization Area -->
        <div class="visualization-container mt-4">
            <h4 class="mb-3"><i class="fas fa-project-diagram me-2"></i>Plant Layout Visualization</h4>
            <div class="visualization" id="visualization">
                <div class="visualization-content">
                    <div class="text-center text-muted p-5">
                        <i class="fas fa-seedling fa-3x mb-3"></i>
                        <p>Enter your planting parameters and click Calculate</p>
                        <p class="small">Visualization will show the planting pattern with circle icons</p>
                    </div>
                </div>
            </div>
            <div class="pattern-comparison">
                <div class="comparison-item">
                    <div style="width: 12px; height: 12px; background: #28a745; border-radius: 50%;"></div>
                    <span>Plant Position</span>
                </div>
                <div class="comparison-item">
                    <i class="fas fa-play text-primary"></i>
                    <span>Triangular Pattern</span>
                </div>
                <div class="comparison-item">
                    <i class="fas fa-th-large text-secondary"></i>
                    <span>Square Pattern</span>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>Triangular Planting System Calculator &copy; 2023</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Plant type recommendations for triangular pattern
        const plantRecommendations = {
            vegetable: { plantSpacing: 0.25 },
            fruit: { plantSpacing: 0.8 },
            herb: { plantSpacing: 0.15 },
            flower: { plantSpacing: 0.2 },
            tree: { plantSpacing: 2.5 },
            shrub: { plantSpacing: 1.2 },
            vine: { plantSpacing: 0.4 },
            custom: { plantSpacing: 0.3 }
        };
        
        // Auto-border functionality
        document.getElementById('autoBorder').addEventListener('change', function() {
            const borderInput = document.getElementById('borderSpacing');
            if (this.checked) {
                borderInput.disabled = true;
                const plantSpacing = parseFloat(document.getElementById('plantSpacing').value) || 0.3;
                const borderSpacingValue = plantSpacing / 2;
                borderInput.value = borderSpacingValue.toFixed(2);
            } else {
                borderInput.disabled = false;
            }
        });
        
        // Plant type change handler
        document.getElementById('plantType').addEventListener('change', function() {
            const plantType = this.value;
            const recommendation = plantRecommendations[plantType];
            
            if (recommendation && plantType !== 'custom') {
                document.getElementById('plantSpacing').value = recommendation.plantSpacing;
                document.getElementById('autoBorder').dispatchEvent(new Event('change'));
            }
        });
        
        // Pattern change handler
        document.querySelectorAll('input[name="pattern"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'square') {
                    // Adjust recommendations for square pattern
                    const plantType = document.getElementById('plantType').value;
                    if (plantType !== 'custom') {
                        const recommendation = plantRecommendations[plantType];
                        document.getElementById('plantSpacing').value = (recommendation.plantSpacing * 1.15).toFixed(2);
                        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
                    }
                } else {
                    // Reset to triangular recommendations
                    const plantType = document.getElementById('plantType').value;
                    if (plantType !== 'custom') {
                        const recommendation = plantRecommendations[plantType];
                        document.getElementById('plantSpacing').value = recommendation.plantSpacing;
                        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
                    }
                }
            });
        });
        
        // Initialize auto-border state
        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        
        // Function to reset the form
        function resetForm() {
            document.getElementById('triangularForm').reset();
            document.getElementById('resultsContainer').classList.add('d-none');
            document.getElementById('successAlert').classList.add('d-none');
            document.getElementById('errorAlert').classList.add('d-none');
            
            document.getElementById('visualization').innerHTML = `
                <div class="visualization-content">
                    <div class="text-center text-muted p-5">
                        <i class="fas fa-seedling fa-3x mb-3"></i>
                        <p>Enter your planting parameters and click Calculate</p>
                        <p class="small">Visualization will show the planting pattern with circle icons</p>
                    </div>
                </div>
            `;
            
            document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        }
        
        // Calculate button handler
        document.getElementById('calculateBtn').addEventListener('click', function() {
            // Get form values
            const areaLength = parseFloat(document.getElementById('areaLength').value);
            const areaWidth = parseFloat(document.getElementById('areaWidth').value);
            const plantSpacing = parseFloat(document.getElementById('plantSpacing').value);
            const borderSpacing = parseFloat(document.getElementById('borderSpacing').value);
            const plantType = document.getElementById('plantType').value;
            const pattern = document.querySelector('input[name="pattern"]:checked').value;
            
            // Validate inputs
            const errors = [];
            if (!areaLength || areaLength <= 0) errors.push("Area length must be a positive number");
            if (!areaWidth || areaWidth <= 0) errors.push("Area width must be a positive number");
            if (!plantSpacing || plantSpacing <= 0) errors.push("Plant spacing must be a positive number");
            if (!borderSpacing || borderSpacing < 0) errors.push("Border spacing must be a non-negative number");
            
            if (errors.length > 0) {
                document.getElementById('errorList').innerHTML = errors.map(error => `<li>${error}</li>`).join('');
                document.getElementById('errorAlert').classList.remove('d-none');
                document.getElementById('successAlert').classList.add('d-none');
                document.getElementById('resultsContainer').classList.add('d-none');
                return;
            }
            
            // Calculate results
            const effectiveLength = areaLength - (2 * borderSpacing);
            const effectiveWidth = areaWidth - (2 * borderSpacing);
            
            // Ensure effective dimensions are positive
            if (effectiveLength <= 0 || effectiveWidth <= 0) {
                errors.push("Border spacing is too large for the given area dimensions");
                document.getElementById('errorList').innerHTML = errors.map(error => `<li>${error}</li>`).join('');
                document.getElementById('errorAlert').classList.remove('d-none');
                document.getElementById('successAlert').classList.add('d-none');
                document.getElementById('resultsContainer').classList.add('d-none');
                return;
            }
            
            let plantsPerRow, numberOfRows, totalPlants;
            
            if (pattern === 'triangular') {
                // Triangular pattern calculation
                const verticalSpacing = plantSpacing * Math.sqrt(3) / 2;
                
                plantsPerRow = Math.floor(effectiveLength / plantSpacing);
                numberOfRows = Math.floor(effectiveWidth / verticalSpacing);
                
                totalPlants = 0;
                for (let row = 0; row < numberOfRows; row++) {
                    if (row % 2 === 0) {
                        totalPlants += plantsPerRow;
                    } else {
                        totalPlants += Math.max(plantsPerRow - 1, 0);
                    }
                }
            } else {
                // Square pattern calculation
                plantsPerRow = Math.floor(effectiveLength / plantSpacing);
                numberOfRows = Math.floor(effectiveWidth / plantSpacing);
                totalPlants = plantsPerRow * numberOfRows;
            }
            
            const effectiveArea = effectiveLength * effectiveWidth;
            const plantingDensity = totalPlants / effectiveArea;
            
            // Calculate space utilization
            let spaceUtilization;
            if (pattern === 'triangular') {
                const areaPerPlant = (Math.sqrt(3) / 2) * plantSpacing * plantSpacing;
                spaceUtilization = (totalPlants * areaPerPlant) / (areaLength * areaWidth) * 100;
            } else {
                spaceUtilization = (totalPlants * plantSpacing * plantSpacing) / (areaLength * areaWidth) * 100;
            }
            
            // Calculate pattern efficiency
            const squarePlants = Math.floor(effectiveLength / plantSpacing) * Math.floor(effectiveWidth / plantSpacing);
            const patternEfficiency = pattern === 'triangular' ? 
                ((totalPlants - squarePlants) / squarePlants * 100).toFixed(1) : 0;
            
            // Update results
            document.getElementById('totalPlants').textContent = totalPlants;
            document.getElementById('plantsPerRow').textContent = plantsPerRow;
            document.getElementById('numberOfRows').textContent = numberOfRows;
            document.getElementById('effectiveArea').textContent = effectiveArea.toFixed(2) + ' m²';
            document.getElementById('plantingDensity').textContent = plantingDensity.toFixed(2) + ' plants/m²';
            document.getElementById('spaceUtilization').textContent = spaceUtilization.toFixed(1) + '%';
            document.getElementById('patternEfficiency').textContent = pattern === 'triangular' ? 
                `+${patternEfficiency}% more plants` : '0% (square pattern)';
            
            // Show results
            document.getElementById('resultsContainer').classList.remove('d-none');
            document.getElementById('successAlert').classList.remove('d-none');
            document.getElementById('errorAlert').classList.add('d-none');
            
            // Update visualization
            updateVisualization(plantsPerRow, numberOfRows, plantType, pattern, plantSpacing);
            
            // Save calculation to server
            saveCalculationToServer({
                plantType: plantType,
                areaLength: areaLength,
                areaWidth: areaWidth,
                plantSpacing: plantSpacing,
                borderSpacing: borderSpacing,
                lengthUnit: document.getElementById('lengthUnit').value,
                widthUnit: document.getElementById('widthUnit').value,
                spacingUnit: 'm', // Triangular calculator uses fixed meter units for spacing
                borderUnit: document.getElementById('borderUnit').value
            });
        });
        
        // Function to update visualization with circle icons
        function updateVisualization(plantsPerRow, numberOfRows, plantType, pattern, plantSpacing) {
            const visualization = document.getElementById('visualization');
            
            // Clear previous visualization
            visualization.innerHTML = '';
            
            // Create the plant grid container
            const plantGrid = document.createElement('div');
            plantGrid.className = 'plant-grid';
            
            // Add pattern title
            const patternTitle = document.createElement('div');
            patternTitle.className = 'pattern-title';
            patternTitle.innerHTML = `
                <i class="fas fa-${pattern === 'triangular' ? 'play' : 'th-large'} me-2"></i>
                <strong>${pattern === 'triangular' ? 'Triangular' : 'Square'} Pattern</strong>
                <div class="small mt-1">${plantsPerRow} × ${numberOfRows} = ${plantsPerRow * numberOfRows} plants</div>
            `;
            plantGrid.appendChild(patternTitle);
            
            // Limit visualization to reasonable dimensions
            const maxRows = Math.min(numberOfRows, 12);
            const maxCols = Math.min(plantsPerRow, 16);
            
            // Get container dimensions
            const containerWidth = visualization.clientWidth - 60;
            const containerHeight = visualization.clientHeight - 80;
            
            // Calculate spacing for visualization
            let cellWidth, cellHeight;
            
            if (pattern === 'triangular') {
                // Triangular pattern: hexagonal packing
                cellWidth = containerWidth / (maxCols + 0.5);
                cellHeight = containerHeight / (maxRows * 0.866); // √3/2 ≈ 0.866
            } else {
                // Square pattern
                cellWidth = containerWidth / maxCols;
                cellHeight = containerHeight / maxRows;
            }
            
            // Plant size - make it responsive
            const plantSize = Math.min(cellWidth, cellHeight) * 0.5;
            
            let totalPlants = 0;
            
            // Add plants based on pattern
            for(let row = 0; row < maxRows; row++) {
                let plantsInThisRow = maxCols;
                if (pattern === 'triangular' && row % 2 === 1) {
                    plantsInThisRow = Math.max(maxCols - 1, 1);
                }
                
                for(let col = 0; col < plantsInThisRow; col++) {
                    totalPlants++;
                    
                    // Calculate position
                    let x, y;
                    
                    if (pattern === 'triangular') {
                        // Triangular pattern positioning
                        if (row % 2 === 0) {
                            x = col * cellWidth + (cellWidth / 2) + 30;
                        } else {
                            x = col * cellWidth + cellWidth + 30;
                        }
                        y = row * cellHeight * 0.866 + (cellHeight / 2) + 40;
                    } else {
                        // Square pattern positioning
                        x = col * cellWidth + (cellWidth / 2) + 30;
                        y = row * cellHeight + (cellHeight / 2) + 40;
                    }
                    
                    // Create plant element with Font Awesome circle
                    const plant = document.createElement('div');
                    plant.className = 'plant-circle';
                    plant.innerHTML = '<i class="fas fa-circle"></i>';
                    plant.title = `Row ${row + 1}, Position ${col + 1}`;
                    
                    // Style the plant
                    plant.style.cssText = `
                        left: ${x}px;
                        top: ${y}px;
                        width: ${plantSize}px;
                        height: ${plantSize}px;
                        color: #28a745;
                        font-size: ${plantSize}px;
                    `;
                    
                    plantGrid.appendChild(plant);
                }
            }
            
            visualization.appendChild(plantGrid);
            
            // Add summary information
            const summary = document.createElement('div');
            summary.className = 'visualization-info';
            summary.innerHTML = `
                <div class="visualization-summary">
                    <i class="fas fa-info-circle me-1"></i>
                    Showing ${maxCols} × ${maxRows} of ${plantsPerRow} × ${numberOfRows} total plants
                    ${pattern === 'triangular' ? '• Hexagonal packing' : '• Grid pattern'}
                </div>
            `;
            plantGrid.appendChild(summary);
        }
        
        // Function to save calculation to server
        function saveCalculationToServer(data) {
            fetch('/triangular-calculator/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Triangular calculation saved successfully');
                } else {
                    console.error('Failed to save triangular calculation:', data.message);
                }
            })
            .catch(error => {
                console.error('Error saving triangular calculation:', error);
            });
        }
        
        // Add subtle animations to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('.form-control, .form-select, .btn');
            
            formElements.forEach(element => {
                element.addEventListener('focus', function() {
                    this.parentElement.classList.add('focus');
                });
                
                element.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focus');
                });
            });
        });
    </script>
</body>
</html>