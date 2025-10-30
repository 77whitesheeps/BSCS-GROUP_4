<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quincunx Planting System Calculator</title>
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
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e9ecef;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .quincunx-pattern {
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        .plant {
            position: absolute;
            width: 22px;
            height: 22px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 3px 6px rgba(0,0,0,0.16);
            transform: translate(-50%, -50%);
            z-index: 2;
            font-size: 0.7rem;
            transition: all 0.3s ease;
        }
        
        .plant:hover {
            transform: translate(-50%, -50%) scale(1.2);
            z-index: 3;
        }
        
        .grid-lines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .grid-line {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        .grid-line.vertical {
            width: 1px;
            height: 100%;
        }
        
        .grid-line.horizontal {
            height: 1px;
            width: 100%;
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
        
        .visualization-info {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.8rem;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            font-size: 0.8rem;
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
        
        .plant-grid {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .plant-dot {
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            position: absolute;
            transform: translate(-50%, -50%);
            background-color: var(--secondary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .plant-dot:hover {
            transform: translate(-50%, -50%) scale(1.2);
            z-index: 2;
            background-color: var(--dark-color);
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
        
        .plant-icon {
            color: white;
            font-size: 0.7em;
        }
        
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
        
        @media (max-width: 768px) {
            .calculator-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            .header {
                padding: 1.5rem;
            }
            .visualization {
                height: 250px;
                padding: 1rem;
            }
            .plant {
                width: 18px;
                height: 18px;
                font-size: 0.6rem;
            }
            .spacing-inputs {
                flex-direction: column;
                gap: 10px;
            }
            .btn-calculate {
                width: 100%;
                margin-bottom: 1rem;
            }
            /* Header action buttons wrap under title on small screens */
            .header .d-flex.justify-content-between {
                flex-direction: column;
                align-items: stretch !important;
                gap: .75rem;
            }
            .header .d-flex.gap-2 {
                width: 100%;
                justify-content: stretch;
            }
            .header .d-flex.gap-2 > * { flex: 1 1 auto; }
            /* Make input groups wrap better on small screens */
            .input-group { flex-wrap: wrap; }
            .input-group .form-control { flex: 1 1 100%; }
            .input-group .form-select, .input-group .input-group-text { flex: 0 0 auto; margin-top: .5rem; }
            /* Tighter footer spacing */
            footer { padding: 1rem; }
        }
        @media (max-width: 420px) {
            .visualization { height: 220px; }
            .header h1 { font-size: 1.25rem; }
            .header p { font-size: .9rem; }
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

        body.dark-theme .input-group-text {
            background-color: #3d3d3d !important;
            color: #ffffff !important;
            border-color: #555555 !important;
        }
    </style>
</head>
<body class="{{ auth()->check() && auth()->user()->theme === 'dark' ? 'dark-theme' : '' }}">
    <div class="container">
        <div class="calculator-container">
            <div class="header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="mb-2"><i class="fas fa-seedling me-2"></i>Quincunx Planting System Calculator</h1>
                        <p class="mb-0">Optimize your planting layout with staggered quincunx pattern</p>
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
                <h5><i class="fas fa-info-circle me-2"></i>About Quincunx Planting</h5>
                <p class="mb-0">The quincunx pattern arranges plants in a staggered formation, with each plant positioned between two plants in the adjacent row. This pattern can increase planting density by up to 15% compared to square planting while maintaining good air circulation.</p>
            </div>
            
            <form id="quincunxForm">
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
                            <div class="spacing-inputs">
                                <div class="spacing-input">
                                    <label class="form-label small">Between Plants</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" required value="0.3">
                                        <select class="form-select" id="spacingUnit" name="spacingUnit">
                                            <option value="m" selected>Meters (m)</option>
                                            <option value="ft">Feet (ft)</option>
                                            <option value="cm">Centimeters (cm)</option>
                                            <option value="in">Inches (in)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="spacing-input">
                                    <label class="form-label small">Between Rows</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="rowSpacing" name="rowSpacing" step="0.01" min="0.01" required value="0.3">
                                        <select class="form-select" id="rowSpacingUnit" name="rowSpacingUnit">
                                            <option value="m" selected>Meters (m)</option>
                                            <option value="ft">Feet (ft)</option>
                                            <option value="cm">Centimeters (cm)</option>
                                            <option value="in">Inches (in)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                                    <input class="form-check-input" type="radio" name="pattern" id="quincunxPattern" value="quincunx" checked>
                                    <label class="form-check-label" for="quincunxPattern">
                                        <i class="fas fa-diamond me-1"></i> Quincunx Pattern
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
            
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle me-2"></i><strong>Calculation completed successfully!</strong> The quincunx pattern can accommodate more plants in the same area.
                </div>
            </div>
        </div>
        
        <!-- Visualization Area -->
        <div class="visualization-container mt-4">
            <h4 class="mb-3"><i class="fas fa-project-diagram me-2"></i>Plant Layout Visualization</h4>
            <div class="visualization" id="visualization">
                <div class="visualization-content">
                    <div class="text-center text-muted p-5">
                        <i class="fas fa-calculator fa-3x mb-3"></i>
                        <p>Visualization will appear here after calculation</p>
                        <p class="small">The quincunx pattern arranges plants in a staggered formation</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>Quincunx Planting System Calculator &copy; 2023</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Plant type recommendations for quincunx pattern
        const plantRecommendations = {
            vegetable: { plantSpacing: 0.25, rowSpacing: 0.3 },
            fruit: { plantSpacing: 0.8, rowSpacing: 1.0 },
            herb: { plantSpacing: 0.15, rowSpacing: 0.2 },
            flower: { plantSpacing: 0.2, rowSpacing: 0.25 },
            tree: { plantSpacing: 2.5, rowSpacing: 3.0 },
            shrub: { plantSpacing: 1.2, rowSpacing: 1.5 },
            vine: { plantSpacing: 0.4, rowSpacing: 0.8 },
            custom: { plantSpacing: 0.3, rowSpacing: 0.3 }
        };
        
        // Auto-border functionality
        document.getElementById('autoBorder').addEventListener('change', function() {
            const borderInput = document.getElementById('borderSpacing');
            
            if (this.checked) {
                borderInput.readOnly = true;
                const plantSpacing = parseFloat(document.getElementById('plantSpacing').value) || 0.3;
                const rowSpacing = parseFloat(document.getElementById('rowSpacing').value) || 0.3;
                const borderSpacingValue = Math.max(plantSpacing, rowSpacing) / 2;
                borderInput.value = borderSpacingValue.toFixed(2);
            } else {
                borderInput.readOnly = false;
                borderInput.value = '0.5'; // Default value when unchecked
            }
        });
        
        // Plant type change handler
        document.getElementById('plantType').addEventListener('change', function() {
            const plantType = this.value;
            const recommendation = plantRecommendations[plantType];
            
            if (recommendation && plantType !== 'custom') {
                document.getElementById('plantSpacing').value = recommendation.plantSpacing;
                document.getElementById('rowSpacing').value = recommendation.rowSpacing;
                
                // Trigger auto-border update
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
                        document.getElementById('rowSpacing').value = (recommendation.rowSpacing * 1.15).toFixed(2);
                        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
                    }
                } else {
                    // Reset to quincunx recommendations
                    const plantType = document.getElementById('plantType').value;
                    if (plantType !== 'custom') {
                        const recommendation = plantRecommendations[plantType];
                        document.getElementById('plantSpacing').value = recommendation.plantSpacing;
                        document.getElementById('rowSpacing').value = recommendation.rowSpacing;
                        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
                    }
                }
            });
        });
        
        // Initialize auto-border state
        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        
        // Function to reset the form
        function resetForm() {
            document.getElementById('quincunxForm').reset();
            
            // Hide results
            document.getElementById('resultsContainer').classList.add('d-none');
            
            // Reset visualization
            document.getElementById('visualization').innerHTML = `
                <div class="visualization-content">
                    <div class="text-center text-muted p-5">
                        <i class="fas fa-calculator fa-3x mb-3"></i>
                        <p>Visualization will appear here after calculation</p>
                        <p class="small">The quincunx pattern arranges plants in a staggered formation</p>
                    </div>
                </div>
            `;
            
            // Re-trigger auto-border functionality
            document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        }
        
        // Calculate button handler
        document.getElementById('calculateBtn').addEventListener('click', function() {
            // Get form values
            const areaLength = parseFloat(document.getElementById('areaLength').value);
            const areaWidth = parseFloat(document.getElementById('areaWidth').value);
            const plantSpacing = parseFloat(document.getElementById('plantSpacing').value);
            const rowSpacing = parseFloat(document.getElementById('rowSpacing').value);
            const borderSpacing = parseFloat(document.getElementById('borderSpacing').value);
            const plantType = document.getElementById('plantType').value;
            const pattern = document.querySelector('input[name="pattern"]:checked').value;
            
            // Validate inputs
            const errors = [];
            if (!areaLength || areaLength <= 0) errors.push("Area length must be a positive number");
            if (!areaWidth || areaWidth <= 0) errors.push("Area width must be a positive number");
            if (!plantSpacing || plantSpacing <= 0) errors.push("Plant spacing must be a positive number");
            if (!rowSpacing || rowSpacing <= 0) errors.push("Row spacing must be a positive number");
            if (!borderSpacing || borderSpacing < 0) errors.push("Border spacing must be a non-negative number");
            
            if (errors.length > 0) {
                alert("Please fix the following errors:\n" + errors.join("\n"));
                return;
            }
            
            // Calculate results
            const effectiveLength = areaLength - (2 * borderSpacing);
            const effectiveWidth = areaWidth - (2 * borderSpacing);
            
            // Ensure effective dimensions are positive
            if (effectiveLength <= 0 || effectiveWidth <= 0) {
                alert("Border spacing is too large for the given area dimensions");
                return;
            }
            
            let plantsPerRow, numberOfRows, totalPlants;
            
            if (pattern === 'quincunx') {
                // Quincunx pattern calculation
                plantsPerRow = Math.floor(effectiveLength / plantSpacing);
                numberOfRows = Math.floor(effectiveWidth / rowSpacing);
                
                // For quincunx, we have the same number of plants in each row
                totalPlants = plantsPerRow * numberOfRows;
            } else {
                // Square pattern calculation
                plantsPerRow = Math.floor(effectiveLength / plantSpacing);
                numberOfRows = Math.floor(effectiveWidth / rowSpacing);
                totalPlants = plantsPerRow * numberOfRows;
            }
            
            const effectiveArea = effectiveLength * effectiveWidth;
            const plantingDensity = totalPlants / effectiveArea;
            const spaceUtilization = (totalPlants * plantSpacing * rowSpacing) / (areaLength * areaWidth) * 100;
            
            // Calculate pattern efficiency (quincunx vs square)
            const squarePlants = Math.floor(effectiveLength / plantSpacing) * Math.floor(effectiveWidth / rowSpacing);
            const patternEfficiency = pattern === 'quincunx' ? 
                ((totalPlants - squarePlants) / squarePlants * 100).toFixed(1) : 0;
            
            // Update results
            document.getElementById('totalPlants').textContent = totalPlants;
            document.getElementById('plantsPerRow').textContent = plantsPerRow;
            document.getElementById('numberOfRows').textContent = numberOfRows;
            document.getElementById('effectiveArea').textContent = effectiveArea.toFixed(2) + ' m²';
            document.getElementById('plantingDensity').textContent = plantingDensity.toFixed(2) + ' plants/m²';
            document.getElementById('spaceUtilization').textContent = spaceUtilization.toFixed(1) + '%';
            document.getElementById('patternEfficiency').textContent = pattern === 'quincunx' ? 
                `+${patternEfficiency}% more plants` : '0% (square pattern)';
            
            // Show results
            document.getElementById('resultsContainer').classList.remove('d-none');
            
            // Update visualization
            updateVisualization(plantsPerRow, numberOfRows, plantType, pattern);
            
            // Save calculation to server
            saveCalculationToServer({
                plantType: plantType,
                areaLength: areaLength,
                areaWidth: areaWidth,
                plantSpacing: plantSpacing,
                rowSpacing: rowSpacing,
                borderSpacing: borderSpacing,
                lengthUnit: document.getElementById('lengthUnit').value,
                widthUnit: document.getElementById('widthUnit').value,
                spacingUnit: document.getElementById('spacingUnit').value,
                rowSpacingUnit: document.getElementById('rowSpacingUnit').value,
                borderUnit: document.getElementById('borderUnit').value
            });
        });
        
        // Function to update visualization
        function updateVisualization(plantsPerRow, numberOfRows, plantType, pattern) {
            const visualization = document.getElementById('visualization');
            
            // Limit visualization to reasonable dimensions
            const maxRows = Math.min(numberOfRows, 8);
            const maxCols = Math.min(plantsPerRow, 12);
            
            // Calculate appropriate sizing
            const containerWidth = visualization.clientWidth - 40;
            const containerHeight = visualization.clientHeight - 40;
            
            // Calculate cell size based on pattern
            const cellWidth = containerWidth / (pattern === 'quincunx' ? maxCols + 0.5 : maxCols);
            const cellHeight = containerHeight / maxRows;
            const plantSize = Math.min(cellWidth, cellHeight) * 0.7;
            
            let visualizationHTML = `
                <div class="visualization-content">
                    <div class="text-center mb-2">
                        <h5 class="text-success">${plantsPerRow * numberOfRows} Plants</h5>
                        <p class="small text-muted">${pattern === 'quincunx' ? 'Quincunx' : 'Square'} Pattern</p>
                    </div>
                    <div class="visualization-grid">
            `;
            
            // Add plants based on pattern
            for(let row = 0; row < maxRows; row++) {
                for(let col = 0; col < maxCols; col++) {
                    let left, top;
                    
                    if (pattern === 'quincunx') {
                        // Fixed quincunx positioning - plants in even rows are offset
                        left = (col * cellWidth) + (row % 2 === 0 ? 0 : cellWidth / 2);
                        top = row * cellHeight + (cellHeight / 2);
                    } else {
                        // Square pattern positioning
                        left = col * cellWidth + (cellWidth / 2);
                        top = row * cellHeight + (cellHeight / 2);
                    }
                    
                    // Convert to percentage for responsive positioning
                    const leftPercent = (left / containerWidth) * 100;
                    const topPercent = (top / containerHeight) * 100;
                    
                    visualizationHTML += `
                        <div class="plant-dot" style="
                            width: ${plantSize}px; 
                            height: ${plantSize}px; 
                            left: ${leftPercent}%; 
                            top: ${topPercent}%;
                        " title="Plant ${row * maxCols + col + 1}">
                            <i class="fas fa-circle plant-icon"></i>
                        </div>
                    `;
                }
            }
            
            visualizationHTML += `</div>`;
            
            if (numberOfRows > maxRows || plantsPerRow > maxCols) {
                visualizationHTML += `
                    <p class="text-center text-muted small mt-2">
                        Showing ${maxCols} × ${maxRows} of ${plantsPerRow} × ${numberOfRows} total plants
                    </p>
                `;
            }
            
            visualizationHTML += `</div>`;
            
            visualization.innerHTML = visualizationHTML;
        }
        
        // Function to save calculation to server
        function saveCalculationToServer(data) {
            fetch('/calculate-quincunx', {
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
                    console.log('Quincunx calculation saved successfully');
                } else {
                    console.error('Failed to save quincunx calculation:', data.message);
                }
            })
            .catch(error => {
                console.error('Error saving quincunx calculation:', error);
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