<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triangular Planting System Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color:  #2e7d32;
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
            max-width: 1200px;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .input-group {
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
        
        .btn-reset {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 0.5rem 2rem;
            font-weight: 600;
        }
        
        .btn-reset:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }
        
        .btn-back {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }
        
        .btn-back:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
        }
        
        .results-container {
            background-color: var(--light-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .result-value {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .visualization {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            overflow: hidden;
            position: relative;
        }
        
        .triangular-pattern {
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        .plant {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 3px 5px rgba(0,0,0,0.2);
            transform: translate(-50%, -50%);
            z-index: 2;
            font-size: 0.7rem;
            transition: all 0.3s ease;
        }
        
        .plant.alternating {
            background-color: #3b82f6;
        }
        
        .plant:hover {
            transform: translate(-50%, -50%) scale(1.3);
            z-index: 3;
            background-color: var(--dark-color);
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
        
        .triangle-connectors {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .connector {
            stroke: #81c784;
            stroke-width: 1;
            stroke-dasharray: 3,3;
        }
        
        .spacing-inputs {
            display: flex;
            gap: 10px;
        }
        
        .spacing-input {
            flex: 1;
        }
        
        .auto-border-info {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .visualization-info {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.8);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            z-index: 10;
        }
        
        .pattern-legend {
            display: flex;
            gap: 15px;
            margin-top: 10px;
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
        }
        
        .legend-color.regular {
            background-color: var(--secondary-color);
        }
        
        .legend-color.alternating {
            background-color: #3b82f6;
        }
        
        footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem;
            color: #6c757d;
        }
        
        .info-icon {
            color: var(--primary-color);
            cursor: pointer;
            margin-left: 5px;
        }
        
        .info-tooltip {
            position: relative;
            display: inline-block;
        }
        
        .info-tooltip .tooltip-text {
            visibility: hidden;
            width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 10px;
            position: absolute;
            z-index: 100;
            bottom: 125%;
            left: 50%;
            margin-left: -125px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.8rem;
            font-weight: normal;
        }
        
        .info-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .result-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-left: 4px solid var(--secondary-color);
        }
        
        .result-card .card-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 5px 0;
        }
        
        .result-card .card-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .warning-message {
            background-color: #fff3cd;
            border: 1px solid #ffecb5;
            color: #856404;
            padding: 10px 15px;
            border-radius: 4px;
            margin-top: 15px;
            display: none;
        }
        
        .export-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .planting-tips {
            background-color: #e8f5e9;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .planting-tips h5 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .planting-tips ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
        
        .planting-tips li {
            margin-bottom: 5px;
        }
        
        .example-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #e3f2fd;
            border-radius: 8px;
        }
        
        .example-section h5 {
            color: #1565c0;
            margin-bottom: 10px;
        }
        
        .example-button {
            background: none;
            border: none;
            color: #1565c0;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
            margin-right: 15px;
        }
        
        .example-button:hover {
            color: #0d47a1;
        }
        
        .controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .zoom-controls button {
            margin-left: 5px;
            padding: 5px 10px;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .pattern-explanation {
            margin-top: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 8px;
        }
        
        @media (max-width: 768px) {
            .calculator-container {
                padding: 1rem;
                margin: 1rem;
            }
            
            .visualization {
                height: 300px;
            }
            
            .plant {
                width: 15px;
                height: 15px;
                font-size: 0.5rem;
            }
            
            .spacing-inputs {
                flex-direction: column;
            }
            
            .export-buttons {
                flex-direction: column;
            }
            
            .controls {
                flex-direction: column;
            }
            
            .zoom-controls {
                margin-top: 10px;
            }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container calculator-container">
        <div class="header text-center">
            <h1>Triangular Planting System Calculator</h1>
            <p class="mb-0">Optimize your planting layout with triangular spacing pattern</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mb-4">
            <button type="button" id="resetBtn" class="btn btn-reset">
                <i class="bi bi-arrow-clockwise"></i> Reset Form
            </button>
            <button type="button" id="backBtn" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                    <a href="{{ route('dashboard') }}" class="btn btn-plant">
                    <i class="fas fa-home me-2"></i>
                    </a>
            </button>
        </div>
        
        <!-- Error/Success Messages -->
        <div class="warning-message" id="warningMessage">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span id="warningText"></span>
        </div>
        
        <div class="alert alert-success fade-in" id="successMessage" style="display: none;">
            <i class="bi bi-check-circle-fill"></i>
            <span id="successText"></span>
        </div>
        
        <form id="triangularForm">
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
                            <input type="number" class="form-control" id="areaLength" name="areaLength" step="0.01" min="0.01" required value="10">
                            <select class="form-select" id="lengthUnit" name="lengthUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
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
                            <input type="number" class="form-control" id="areaWidth" name="areaWidth" step="0.01" min="0.01" required value="8">
                            <select class="form-select" id="widthUnit" name="widthUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
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
                                <span class="tooltip-text">Distance between plant centers in the triangular pattern</span>
                            </span>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" required value="1.5">
                            <select class="form-select" id="spacingUnit" name="spacingUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                        <p class="text-muted small mt-1">Distance between plant centers in the triangular pattern</p>
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
                            <input type="number" class="form-control" id="borderSpacing" name="borderSpacing" step="0.01" min="0" value="0.5" required>
                            <select class="form-select" id="borderUnit" name="borderUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                        <div class="auto-border-info">
                            <input type="checkbox" id="autoBorder" checked> 
                            <label for="autoBorder">Auto-calculate border spacing based on plant spacing</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button type="button" id="calculateBtn" class="btn btn-calculate btn-lg">
                    <i class="bi bi-calculator"></i> Calculate Triangular Layout
                </button>
            </div>
        </form>
        
        <!-- Quick Examples -->
        <div class="example-section">
            <h5><i class="bi bi-lightning"></i> Quick Examples:</h5>
            <div>
                <button type="button" class="example-button" onclick="setExample('orchard')">
                    <i class="bi bi-apple"></i> Apple Orchard (10m × 8m, 3m spacing)
                </button>
                <button type="button" class="example-button" onclick="setExample('garden')">
                    <i class="bi bi-flower1"></i> Herb Garden (5m × 3m, 0.5m spacing)
                </button>
                <button type="button" class="example-button" onclick="setExample('vineyard')">
                    <i class="bi bi-grapes"></i> Vineyard (20m × 15m, 2.5m spacing)
                </button>
            </div>
        </div>
        
        <div class="results-container" id="resultsContainer" style="display: none;">
            <h3 class="mb-4">Calculation Results</h3>
            
            <div class="results-grid">
                <div class="result-card">
                    <div class="card-label">Total Plants</div>
                    <div class="card-value" id="totalPlants">0</div>
                </div>
                <div class="result-card">
                    <div class="card-label">Plants per Row</div>
                    <div class="card-value" id="plantsPerRow">0</div>
                </div>
                <div class="result-card">
                    <div class="card-label">Number of Rows</div>
                    <div class="card-value" id="numberOfRows">0</div>
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
        
        <div class="visualization" id="visualization">
            <div class="text-center text-muted">
                <p>Visualization will appear here after calculation</p>
                <p class="small">The triangular pattern arranges plants in staggered rows for optimal space utilization</p>
            </div>
        </div>
        
        <div class="controls" id="visualizationControls" style="display: none;">
            <div>
                <label for="showConnectors">
                    <input type="checkbox" id="showConnectors" checked> Show triangular connections
                </label>
            </div>
            <div class="zoom-controls">
                <button id="zoomIn">Zoom In</button>
                <button id="zoomOut">Zoom Out</button>
                <button id="resetView">Reset View</button>
            </div>
        </div>
        
        <div class="pattern-legend" id="patternLegend" style="display: none;">
            <div class="legend-item">
                <div class="legend-color regular"></div>
                <span>Regular Plant</span>
            </div>
            <div class="legend-item">
                <div class="legend-color alternating"></div>
                <span>Alternating Plant</span>
            </div>
        </div>
        
        <div class="pattern-explanation" id="patternExplanation" style="display: none;">
            <h5><i class="bi bi-info-circle"></i> Triangular Pattern Explanation</h5>
            <p class="mb-2">
                The triangular planting pattern arranges plants in offset rows, creating equilateral triangles between plants. 
                This pattern maximizes space utilization and allows each plant to have equal access to resources like sunlight, 
                water, and nutrients. It's approximately 15% more efficient than square planting patterns.
            </p>
            
            <div class="row">
                <div class="col-md-6">
                    <h6>Key Features:</h6>
                    <ul>
                        <li>Staggered row arrangement forming equilateral triangles</li>
                        <li>More efficient space utilization than square patterns</li>
                        <li>Ideal for orchards, vineyards, and perennial crops</li>
                        <li>Provides better light penetration and air circulation</li>
                        <li>Approximately 15% more efficient than square grid</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Best For:</h6>
                    <ul>
                        <li>Fruit trees and orchards</li>
                        <li>Vineyards and berry bushes</li>
                        <li>Perennial crops and ornamentals</li>
                        <li>Any planting where maximum density is desired</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="planting-tips" id="plantingTips" style="display: none;">
            <h5><i class="bi bi-lightbulb"></i> Triangular Planting Tips</h5>
            <ul>
                <li>Triangular planting maximizes space utilization compared to traditional square planting</li>
                <li>This pattern provides better light distribution and air circulation</li>
                <li>Consider plant size at maturity when setting spacing distances</li>
                <li>Leave adequate border space for access and maintenance</li>
                <li>Mark planting positions carefully to maintain the triangular pattern</li>
            </ul>
        </div>
    </div>
    
    <footer>
        <p>Triangular Planting System Calculator &copy; <span id="currentYear"></span></p>
    </footer>

    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
        
        // Conversion factors to meters
        const conversionRates = {
            'm': 1,
            'ft': 0.3048,
            'cm': 0.01,
            'in': 0.0254
        };
        
        let currentScale = 1;
        let currentOffsetX = 0;
        let currentOffsetY = 0;
        let isDragging = false;
        let startX, startY;
        
        // Calculate button event listener
        document.getElementById('calculateBtn').addEventListener('click', function() {
            calculatePlanting();
        });
        
        // Reset button event listener
        document.getElementById('resetBtn').addEventListener('click', function() {
            resetForm();
        });
        
        // Back button event listener
        document.getElementById('backBtn').addEventListener('click', function() {
            alert('Back to Dashboard functionality would be implemented here');
            // In a real implementation, this would navigate back to the dashboard
        });
        
        // Export buttons event listeners
        document.getElementById('exportPdfBtn').addEventListener('click', function() {
            alert('PDF export functionality would be implemented here');
            // In a real implementation, this would generate a PDF with the results
        });
        
        document.getElementById('exportCsvBtn').addEventListener('click', function() {
            exportToCsv();
        });
        
        document.getElementById('printBtn').addEventListener('click', function() {
            window.print();
        });
        
        // Auto-border functionality
        document.getElementById('autoBorder').addEventListener('change', function() {
            const borderInput = document.getElementById('borderSpacing');
            borderInput.disabled = this.checked;
            
            if (this.checked) {
                const plantSpacing = parseFloat(document.getElementById('plantSpacing').value) || 1.5;
                const borderSpacing = plantSpacing / 2;
                borderInput.value = borderSpacing.toFixed(2);
            }
        });
        
        // Visualization controls
        document.getElementById('showConnectors').addEventListener('change', toggleConnectors);
        document.getElementById('zoomIn').addEventListener('click', zoomIn);
        document.getElementById('zoomOut').addEventListener('click', zoomOut);
        document.getElementById('resetView').addEventListener('click', resetView);
        
        // Initialize auto-border state
        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        
        // Main calculation function
        function calculatePlanting() {
            // Get input values
            const areaLength = parseFloat(document.getElementById('areaLength').value);
            const areaWidth = parseFloat(document.getElementById('areaWidth').value);
            const plantSpacing = parseFloat(document.getElementById('plantSpacing').value);
            let borderSpacing = parseFloat(document.getElementById('borderSpacing').value);
            const autoBorder = document.getElementById('autoBorder').checked;
            
            // Get selected units
            const lengthUnit = document.getElementById('lengthUnit').value;
            const widthUnit = document.getElementById('widthUnit').value;
            const spacingUnit = document.getElementById('spacingUnit').value;
            const borderUnit = document.getElementById('borderUnit').value;
            
            // Validate inputs
            if (areaLength <= 0 || areaWidth <= 0 || plantSpacing <= 0 || borderSpacing < 0) {
                showWarning('Please enter valid positive values for all fields.');
                return;
            }
            
            // Auto-calculate border spacing if enabled
            if (autoBorder) {
                borderSpacing = plantSpacing / 2;
                document.getElementById('borderSpacing').value = borderSpacing.toFixed(2);
            }
            
            // Check if border spacing is too large
            if (borderSpacing * 2 >= areaLength || borderSpacing * 2 >= areaWidth) {
                showWarning('Border spacing is too large. It must be less than half of the area length and width.');
                return;
            }
            
            // Check if spacing values are appropriate for the area
            if (plantSpacing > areaLength || plantSpacing > areaWidth) {
                showWarning('Plant spacing is larger than the area dimensions. Please adjust values.');
                return;
            }
            
            // Hide any previous warnings
            hideWarning();
            
            // Convert all values to meters
            const areaLengthM = areaLength * conversionRates[lengthUnit];
            const areaWidthM = areaWidth * conversionRates[widthUnit];
            const plantSpacingM = plantSpacing * conversionRates[spacingUnit];
            const borderSpacingM = borderSpacing * conversionRates[borderUnit];
            
            // Calculate effective planting area
            const effectiveLength = Math.max(0, areaLengthM - 2 * borderSpacingM);
            const effectiveWidth = Math.max(0, areaWidthM - 2 * borderSpacingM);
            
            if (effectiveLength <= 0 || effectiveWidth <= 0) {
                showWarning('Border spacing is too large for the given area.');
                return;
            }
            
            // Calculate plants per row and number of rows (triangular pattern)
            const plantsPerRow = Math.floor(effectiveLength / plantSpacingM) + 1;
            const rowSpacing = plantSpacingM * Math.sqrt(3) / 2; // Height of equilateral triangle
            const numberOfRows = Math.floor(effectiveWidth / rowSpacing) + 1;
            
            const totalPlants = plantsPerRow * numberOfRows;
            const effectiveArea = effectiveLength * effectiveWidth;
            const plantingDensity = effectiveArea > 0 ? totalPlants / effectiveArea : 0;
            const spaceUtilization = areaLengthM * areaWidthM > 0 ? (effectiveArea / (areaLengthM * areaWidthM)) * 100 : 0;
            
            // Update results
            document.getElementById('totalPlants').textContent = totalPlants.toLocaleString();
            document.getElementById('plantsPerRow').textContent = plantsPerRow.toLocaleString();
            document.getElementById('numberOfRows').textContent = numberOfRows.toLocaleString();
            document.getElementById('effectiveArea').textContent = effectiveArea.toFixed(2) + ' m²';
            document.getElementById('plantingDensity').textContent = plantingDensity.toFixed(2) + ' plants/m²';
            document.getElementById('spaceUtilization').textContent = spaceUtilization.toFixed(1) + '%';
            
            // Show results container
            document.getElementById('resultsContainer').style.display = 'block';
            
// Show visualization controls
            document.getElementById('visualizationControls').style.display = 'flex';
            
            // Show legend
            document.getElementById('patternLegend').style.display = 'flex';
            
            // Show pattern explanation
            document.getElementById('patternExplanation').style.display = 'block';
            
            // Show planting tips
            document.getElementById('plantingTips').style.display = 'block';
            
            // Generate visualization
            generateVisualization(plantsPerRow, numberOfRows, plantSpacingM, rowSpacing, effectiveLength, effectiveWidth);
            
            // Show success message
            showSuccess('Triangular layout calculated successfully!');
        }
        
        function generateVisualization(plantsPerRow, numberOfRows, plantSpacing, rowSpacing, effectiveLength, effectiveWidth) {
            const visualization = document.getElementById('visualization');
            visualization.innerHTML = '';
            
            // Create container for the pattern
            const container = document.createElement('div');
            container.className = 'triangular-pattern';
            visualization.appendChild(container);
            
            // Calculate scaling factors to fit visualization
            const visWidth = visualization.clientWidth - 40;
            const visHeight = visualization.clientHeight - 40;
            
            const scaleX = visWidth / effectiveLength;
            const scaleY = visHeight / effectiveWidth;
            const scale = Math.min(scaleX, scaleY) * 0.8; // 80% to add some padding
            
            // Create SVG for connectors
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.classList.add('triangle-connectors');
            svg.setAttribute('width', '100%');
            svg.setAttribute('height', '100%');
            container.appendChild(svg);
            
            // Create plants
            const plants = [];
            
            for (let row = 0; row < numberOfRows; row++) {
                const isEvenRow = row % 2 === 0;
                const rowOffset = isEvenRow ? plantSpacing / 2 : 0;
                
                for (let col = 0; col < plantsPerRow; col++) {
                    const plant = document.createElement('div');
                    plant.classList.add('plant');
                    if ((row + col) % 2 === 0) plant.classList.add('alternating');
                    
                    // Position plant
                    const x = (col * plantSpacing + rowOffset) * scale;
                    const y = (row * rowSpacing) * scale;
                    
                    plant.style.left = x + 'px';
                    plant.style.top = y + 'px';
                    plant.title = `Row ${row + 1}, Plant ${col + 1}`;
                    
                    container.appendChild(plant);
                    plants.push({x: x, y: y, element: plant, row: row, col: col});
                }
            }
            
            // Set container dimensions
            container.style.width = (effectiveLength * scale) + 'px';
            container.style.height = (effectiveWidth * scale) + 'px';
            
            // Center the container
            container.style.transform = `translate(${-effectiveLength * scale / 2}px, ${-effectiveWidth * scale / 2}px)`;
            
            // Draw connectors between plants to form triangles
            drawConnectors(plants, plantsPerRow, numberOfRows, svg, scale);
            
            // Reset view
            resetView();
            
            // Add panning functionality
            visualization.addEventListener('mousedown', startDragging);
            visualization.addEventListener('mousemove', drag);
            visualization.addEventListener('mouseup', stopDragging);
            visualization.addEventListener('mouseleave', stopDragging);
        }
        
        function drawConnectors(plants, plantsPerRow, numberOfRows, svg, scale) {
            // Clear previous connectors
            svg.innerHTML = '';
            
            if (!document.getElementById('showConnectors').checked) return;
            
            // Draw lines to form triangles
            for (let i = 0; i < plants.length; i++) {
                const plant = plants[i];
                
                // Connect to plant to the right (if exists)
                if (plant.col < plantsPerRow - 1) {
                    const rightPlant = plants[i + 1];
                    drawLine(svg, plant.x, plant.y, rightPlant.x, rightPlant.y);
                }
                
                // Connect to plant below (if exists)
                if (plant.row < numberOfRows - 1) {
                    const belowPlant = plants[i + plantsPerRow];
                    drawLine(svg, plant.x, plant.y, belowPlant.x, belowPlant.y);
                    
                    // Connect diagonally based on row parity
                    if (plant.row % 2 === 0 && plant.col > 0) {
                        // Even row: connect to bottom-left plant
                        const diagPlant = plants[i + plantsPerRow - 1];
                        drawLine(svg, plant.x, plant.y, diagPlant.x, diagPlant.y);
                    } else if (plant.row % 2 === 1 && plant.col < plantsPerRow - 1) {
                        // Odd row: connect to bottom-right plant
                        const diagPlant = plants[i + plantsPerRow + 1];
                        drawLine(svg, plant.x, plant.y, diagPlant.x, diagPlant.y);
                    }
                }
            }
        }
        
        function drawLine(svg, x1, y1, x2, y2) {
            const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
            line.setAttribute('x1', x1);
            line.setAttribute('y1', y1);
            line.setAttribute('x2', x2);
            line.setAttribute('y2', y2);
            line.classList.add('connector');
            svg.appendChild(line);
        }
        
        function toggleConnectors() {
            const plantsPerRow = parseInt(document.getElementById('plantsPerRow').textContent.replace(/,/g, '')) || 5;
            const numberOfRows = parseInt(document.getElementById('numberOfRows').textContent.replace(/,/g, '')) || 4;
            const plantSpacing = 1.5; // Default value
            const rowSpacing = plantSpacing * Math.sqrt(3) / 2;
            
            const svg = document.querySelector('.triangle-connectors');
            if (svg) {
                const plants = Array.from(document.querySelectorAll('.plant')).map(plant => {
                    const style = window.getComputedStyle(plant);
                    return {
                        x: parseFloat(style.left) + 10, // Half of plant width
                        y: parseFloat(style.top) + 10,  // Half of plant height
                        element: plant,
                        row: parseInt(plant.textContent) % numberOfRows,
                        col: Math.floor(parseInt(plant.textContent) / numberOfRows)
                    };
                });
                
                drawConnectors(plants, plantsPerRow, numberOfRows, svg, 1);
            }
        }
        
        function startDragging(e) {
            isDragging = true;
            startX = e.clientX - currentOffsetX;
            startY = e.clientY - currentOffsetY;
            document.getElementById('visualization').style.cursor = 'grabbing';
            e.preventDefault();
        }
        
        function drag(e) {
            if (!isDragging) return;
            
            currentOffsetX = e.clientX - startX;
            currentOffsetY = e.clientY - startY;
            
            updateTransform();
        }
        
        function stopDragging() {
            isDragging = false;
            document.getElementById('visualization').style.cursor = 'grab';
        }
        
        function zoomIn() {
            currentScale *= 1.2;
            updateTransform();
        }
        
        function zoomOut() {
            currentScale /= 1.2;
            updateTransform();
        }
        
        function resetView() {
            currentScale = 1;
            currentOffsetX = 0;
            currentOffsetY = 0;
            updateTransform();
        }
        
        function updateTransform() {
            const plantingArea = document.querySelector('.triangular-pattern');
            if (plantingArea) {
                plantingArea.style.transform = `translate(${currentOffsetX}px, ${currentOffsetY}px) scale(${currentScale})`;
            }
        }
        
        function resetForm() {
            document.getElementById('triangularForm').reset();
            document.getElementById('resultsContainer').style.display = 'none';
            document.getElementById('visualizationControls').style.display = 'none';
            document.getElementById('patternLegend').style.display = 'none';
            document.getElementById('patternExplanation').style.display = 'none';
            document.getElementById('plantingTips').style.display = 'none';
            document.getElementById('visualization').innerHTML = `
                <div class="text-center text-muted">
                    <p>Visualization will appear here after calculation</p>
                    <p class="small">The triangular pattern arranges plants in staggered rows for optimal space utilization</p>
                </div>
            `;
            hideWarning();
            hideSuccess();
            
            // Reset auto-border
            document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        }
        
        function setExample(type) {
            const examples = {
                orchard: { length: 10, width: 8, spacing: 3 },
                garden: { length: 5, width: 3, spacing: 0.5 },
                vineyard: { length: 20, width: 15, spacing: 2.5 }
            };
            
            const example = examples[type];
            if (example) {
                document.getElementById('areaLength').value = example.length;
                document.getElementById('areaWidth').value = example.width;
                document.getElementById('plantSpacing').value = example.spacing;
                document.getElementById('borderSpacing').value = example.spacing / 2;
                
                // Trigger auto-border update
                document.getElementById('autoBorder').dispatchEvent(new Event('change'));
            }
        }
        
        function showWarning(message) {
            document.getElementById('warningText').textContent = message;
            document.getElementById('warningMessage').style.display = 'block';
            hideSuccess();
        }
        
        function hideWarning() {
            document.getElementById('warningMessage').style.display = 'none';
        }
        
        function showSuccess(message) {
            document.getElementById('successText').textContent = message;
            document.getElementById('successMessage').style.display = 'block';
            hideWarning();
        }
        
        function hideSuccess() {
            document.getElementById('successMessage').style.display = 'none';
        }
        
        function exportToCsv() {
            const totalPlants = document.getElementById('totalPlants').textContent;
            const plantsPerRow = document.getElementById('plantsPerRow').textContent;
            const numberOfRows = document.getElementById('numberOfRows').textContent;
            const effectiveArea = document.getElementById('effectiveArea').textContent;
            const plantingDensity = document.getElementById('plantingDensity').textContent;
            const spaceUtilization = document.getElementById('spaceUtilization').textContent;
            
            const csvContent = 
                "Triangular Planting System Calculation Results\n\n" +
                "Parameter,Value\n" +
                `Total Plants,${totalPlants}\n` +
                `Plants per Row,${plantsPerRow}\n` +
                `Number of Rows,${numberOfRows}\n` +
                `Effective Area,${effectiveArea}\n` +
                `Planting Density,${plantingDensity}\n` +
                `Space Utilization,${spaceUtilization}\n\n` +
                "Calculation Date," + new Date().toLocaleDateString();
            
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'triangular_planting_results.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
        
        // Add Enter key support for form submission
        document.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                calculatePlanting();
            }
        });
        
        // Calculate on page load with default values
        calculatePlanting();
    </script>
</body>
</html>