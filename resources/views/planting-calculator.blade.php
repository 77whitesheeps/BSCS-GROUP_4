<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
        .square-pattern {
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
        }
        
        .plant-dot {
            transition: all 0.3s ease;
        }
        
        .plant-dot:hover {
            transform: scale(1.2);
            z-index: 2;
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
    </style>

    <!-- Dark Mode Styles -->
    <style>
        .dark-mode {
            background-color: #121212;
            color: #ffffff;
        }
        .dark-mode .calculator-container {
            background-color: #1e1e1e;
        }
        .dark-mode .form-control, .dark-mode .form-select {
            background-color: #333;
            color: #ffffff;
            border-color: #555;
        }
        .dark-mode .form-label {
            color: #ffffff;
        }
        .dark-mode .results-container {
            background-color: #333;
            border-left-color: var(--accent-color);
        }
        .dark-mode .result-value {
            color: var(--accent-color);
        }
        .dark-mode .results-container h3 {
            color: #ffffff;
        }
        .dark-mode .visualization {
            background-color: #333;
            border-color: #555;
        }
        .dark-mode .visualization-info {
            background: rgba(0, 0, 0, 0.7);
            color: #ffffff;
        }
        .dark-mode .header {
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
        }
        .dark-mode .text-muted {
            color: #a0a0a0 !important;
        }
        .dark-mode .layout-details {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .dark-mode .input-group-text {
            background-color: #3d3d3d !important;
            color: #ffffff !important;
            border-color: #555555 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="calculator-container">
            <div class="header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="mb-2">🌱 Square Planting System Calculator</h1>
                        <p class="mb-0">Optimize your planting layout with square spacing pattern</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" onclick="resetForm()" class="btn btn-outline-light">
                            <i class="fas fa-redo-alt me-1"></i> Reset
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            
            <!-- Success/Error Messages -->
            <div class="alert alert-success alert-dismissible fade show d-none" role="alert" id="successAlert">
                <i class="fas fa-check-circle me-2"></i>Calculation completed successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    
            <div class="alert alert-danger alert-dismissible fade show d-none" role="alert" id="errorAlert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0" id="errorList">
                    <!-- Errors will be populated here -->
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            
            <form id="squareForm">
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
                                <option value="vegetable">🥬 Vegetables</option>
                                <option value="fruit">🍓 Fruits</option>
                                <option value="herb">🌿 Herbs</option>
                                <option value="flower">🌺 Flowers</option>
                                <option value="tree">🌳 Trees</option>
                                <option value="shrub">🌿 Shrubs</option>
                                <option value="vine">🍇 Vines</option>
                                <option value="custom">🔧 Custom</option>
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
                                        <span class="input-group-text">m</span>
                                    </div>
                                </div>
                                <div class="spacing-input">
                                    <label class="form-label small">Between Rows</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="rowSpacing" name="rowSpacing" step="0.01" min="0.01" required value="0.3">
                                        <span class="input-group-text">m</span>
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
                                    <input class="form-check-input" type="radio" name="pattern" id="squarePattern" value="square" checked>
                                    <label class="form-check-label" for="squarePattern">
                                        <i class="fas fa-th-large me-1"></i> Square Pattern
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pattern" id="rectangularPattern" value="rectangular">
                                    <label class="form-check-label" for="rectangularPattern">
                                        <i class="fas fa-th me-1"></i> Rectangular Pattern
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="button" id="calculateBtn" class="btn btn-calculate btn-lg text-white">
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
                
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle me-2"></i><strong>Calculation completed successfully!</strong> Results saved to your history.
                </div>
            </div>
            
            <!-- Visualization Area -->
            <div class="visualization-container mt-4">
                <h4 class="mb-3"><i class="fas fa-project-diagram me-2"></i>Plant Layout Visualization</h4>
                <div class="visualization" id="visualization">
                    <div class="text-center text-muted p-5">
                        <i class="fas fa-calculator fa-3x mb-3"></i>
                        <p>Visualization will appear here after calculation</p>
                        <p class="small">The square pattern arranges plants in straight rows and columns</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>Square Planting System Calculator &copy; 2023</p>
    </footer>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const theme = "{{ auth()->user()->theme ?? 'light' }}";
            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
            }
        });

        // Plant type recommendations
        const plantRecommendations = {
            vegetable: { plantSpacing: 0.3, rowSpacing: 0.4 },
            fruit: { plantSpacing: 1.0, rowSpacing: 1.5 },
            herb: { plantSpacing: 0.2, rowSpacing: 0.3 },
            flower: { plantSpacing: 0.25, rowSpacing: 0.3 },
            tree: { plantSpacing: 3.0, rowSpacing: 4.0 },
            shrub: { plantSpacing: 1.5, rowSpacing: 2.0 },
            vine: { plantSpacing: 0.5, rowSpacing: 1.0 },
            custom: { plantSpacing: 0.3, rowSpacing: 0.3 }
        };
        
        // Auto-border functionality
        document.getElementById('autoBorder').addEventListener('change', function() {
            const borderInput = document.getElementById('borderSpacing');
            borderInput.disabled = this.checked;
            
            if (this.checked) {
                const plantSpacing = parseFloat(document.getElementById('plantSpacing').value) || 0.3;
                const rowSpacing = parseFloat(document.getElementById('rowSpacing').value) || 0.3;
                const borderSpacing = Math.max(plantSpacing, rowSpacing) / 2;
                borderInput.value = borderSpacing.toFixed(2);
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
        
        // Initialize auto-border state
        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        
        // Function to reset the form
        function resetForm() {
            document.getElementById('squareForm').reset();
            
            // Hide results
            document.getElementById('resultsContainer').classList.add('d-none');
            document.getElementById('successAlert').classList.add('d-none');
            document.getElementById('errorAlert').classList.add('d-none');
            
            // Reset visualization
            document.getElementById('visualization').innerHTML = `
                <div class="text-center text-muted p-5">
                    <i class="fas fa-calculator fa-3x mb-3"></i>
                    <p>Visualization will appear here after calculation</p>
                    <p class="small">The square pattern arranges plants in straight rows and columns</p>
                </div>
            `;
            
            // Re-trigger auto-border functionality
            document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        }
        
        // Function to save calculation to server
        function saveCalculationToServer(data) {
            fetch('/calculate-plants', {
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
                    console.log('Calculation saved successfully');
                } else {
                    console.error('Failed to save calculation:', data.message);
                }
            })
            .catch(error => {
                console.error('Error saving calculation:', error);
            });
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

            // Validate inputs
            const errors = [];
            if (!areaLength || areaLength <= 0) errors.push("Area length must be a positive number");
            if (!areaWidth || areaWidth <= 0) errors.push("Area width must be a positive number");
            if (!plantSpacing || plantSpacing <= 0) errors.push("Plant spacing must be a positive number");
            if (!rowSpacing || rowSpacing <= 0) errors.push("Row spacing must be a positive number");
            if (!borderSpacing || borderSpacing < 0) errors.push("Border spacing must be a non-negative number");

            if (errors.length > 0) {
                // Show errors
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

            const plantsPerRow = Math.floor(effectiveLength / plantSpacing);
            const numberOfRows = Math.floor(effectiveWidth / rowSpacing);
            const totalPlants = plantsPerRow * numberOfRows;
            const effectiveArea = effectiveLength * effectiveWidth;
            const plantingDensity = totalPlants / effectiveArea;
            const spaceUtilization = (totalPlants * plantSpacing * rowSpacing) / (areaLength * areaWidth) * 100;

            // Update results
            document.getElementById('totalPlants').textContent = totalPlants;
            document.getElementById('plantsPerRow').textContent = plantsPerRow;
            document.getElementById('numberOfRows').textContent = numberOfRows;
            document.getElementById('effectiveArea').textContent = effectiveArea.toFixed(2) + ' m²';
            document.getElementById('plantingDensity').textContent = plantingDensity.toFixed(2) + ' plants/m²';
            document.getElementById('spaceUtilization').textContent = spaceUtilization.toFixed(1) + '%';

            // Show results
            document.getElementById('resultsContainer').classList.remove('d-none');
            document.getElementById('successAlert').classList.remove('d-none');
            document.getElementById('errorAlert').classList.add('d-none');

            // Update visualization
            updateVisualization(plantsPerRow, numberOfRows, plantType);

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
                borderUnit: document.getElementById('borderUnit').value,
                autoBorder: document.getElementById('autoBorder').checked ? 1 : 0
            });
        });
        
        // Function to update visualization
        function updateVisualization(plantsPerRow, numberOfRows, plantType) {
            const visualization = document.getElementById('visualization');
            
            // Determine plant icon based on type
            let plantIcon = '🌱'; // default
            switch(plantType) {
                case 'vegetable': plantIcon = '🥬'; break;
                case 'fruit': plantIcon = '🍓'; break;
                case 'herb': plantIcon = '🌿'; break;
                case 'flower': plantIcon = '🌺'; break;
                case 'tree': plantIcon = '🌳'; break;
                case 'shrub': plantIcon = '🌿'; break;
                case 'vine': plantIcon = '🍇'; break;
                default: plantIcon = '🌱';
            }
            
            // Limit visualization to reasonable dimensions
            const maxRows = Math.min(numberOfRows, 10);
            const maxCols = Math.min(plantsPerRow, 15);
            const cellSize = Math.min(400 / maxCols, 200 / maxRows);
            
            let visualizationHTML = `
                <div class="text-center mb-3">
                    <h5 class="text-success">${plantsPerRow * numberOfRows} Plants Layout</h5>
                    <p class="small text-muted">${plantsPerRow} plants per row × ${numberOfRows} rows</p>
                </div>
                
                <div class="plant-grid mx-auto" style="max-width: 400px; max-height: 200px; overflow: hidden;">
                    <div class="grid-container" style="display: grid; grid-template-columns: repeat(${maxCols}, ${cellSize}px); grid-template-rows: repeat(${maxRows}, ${cellSize}px); gap: 2px; justify-content: center;">
            `;
            
            for(let row = 0; row < maxRows; row++) {
                for(let col = 0; col < maxCols; col++) {
                    visualizationHTML += `
                        <div class="plant-dot" style="width: ${cellSize - 2}px; height: ${cellSize - 2}px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: ${Math.max(8, cellSize / 3)}px;">
                            ${plantIcon}
                        </div>
                    `;
                }
            }
            
            visualizationHTML += `
                    </div>
            `;
            
            if (numberOfRows > 10 || plantsPerRow > 15) {
                visualizationHTML += `
                    <p class="text-center text-muted small mt-2">
                        Showing ${maxCols} × ${maxRows} of ${plantsPerRow} × ${numberOfRows} total plants
                    </p>
                `;
            }
            
            visualizationHTML += `
                </div>
                
                <div class="layout-details mt-3 text-center">
                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-muted">Plant Spacing</small>
                            <p class="mb-1"><strong>${document.getElementById('plantSpacing').value}m</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Row Spacing</small>
                            <p class="mb-1"><strong>${document.getElementById('rowSpacing').value}m</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Plant Type</small>
                            <p class="mb-1"><strong>${document.getElementById('plantType').options[document.getElementById('plantType').selectedIndex].text}</strong></p>
                        </div>
                    </div>
                </div>
            `;
            
            visualization.innerHTML = visualizationHTML;
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