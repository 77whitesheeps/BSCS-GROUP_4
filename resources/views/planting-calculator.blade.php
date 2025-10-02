<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Square Planting System Calculator</title>
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
            max-width: 1100px;
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
        
        .square-pattern {
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
            background-color: var(--secondary-color);
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
        }
    </style>
</head>
<body>
    <div class="container calculator-container">
        <div class="header text-center">
            <h1>Square Planting System Calculator</h1>
            <p class="mb-0">Optimize your planting layout with square spacing pattern</p>
        </div>
        
        <form id="squareForm">
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
                <div class="text-center mt-3">
                    {{-- Remove this button group --}}
                    {{-- <button class="btn btn-primary me-2">Export PDF</button>
                    <button class="btn btn-success">Export CSV</button> --}}
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
                                    <input type="number" class="form-control" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" required value="1.5">
                                    <span class="input-group-text">m</span>
                                </div>
                            </div>
                            <div class="spacing-input">
                                <label class="form-label small">Between Rows</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="rowSpacing" name="rowSpacing" step="0.01" min="0.01" required value="1.5">
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
                <button type="button" id="calculateBtn" class="btn btn-calculate btn-lg">Calculate</button>
                <button type="button" id="resetBtn" class="btn btn-reset btn-lg ms-2">Reset</button>
            </div>
        </form>
        
        <div class="warning-message" id="warningMessage">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span id="warningText"></span>
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
                <p class="small">The square pattern arranges plants in straight rows and columns</p>
            </div>
        </div>
        
        <div class="pattern-legend" id="patternLegend" style="display: none;">
            <div class="legend-item">
                <div class="legend-color"></div>
                <span>Plant position</span>
            </div>
        </div>
        
        <div class="planting-tips" id="plantingTips" style="display: none;">
            <h5><i class="bi bi-lightbulb"></i> Square Planting Tips</h5>
            <ul>
                <li>Square planting maximizes space utilization compared to traditional row planting</li>
                <li>This pattern provides better light distribution and air circulation</li>
                <li>Consider plant size at maturity when setting spacing distances</li>
                <li>Leave adequate border space for access and maintenance</li>
            </ul>
        </div>
    </div>
    
    <footer>
        <p>Square Planting System Calculator &copy; <span id="currentYear"></span></p>
    </footer>

    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
        
        // Calculate button event listener
        document.getElementById('calculateBtn').addEventListener('click', function() {
            calculatePlanting();
        });
        
        // Reset button event listener
        document.getElementById('resetBtn').addEventListener('click', function() {
            resetForm();
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
                const rowSpacing = parseFloat(document.getElementById('rowSpacing').value) || 1.5;
                const borderSpacing = Math.max(plantSpacing, rowSpacing) / 2;
                borderInput.value = borderSpacing.toFixed(2);
            }
        });
        
        // Initialize auto-border state
        document.getElementById('autoBorder').dispatchEvent(new Event('change'));
        
        // Main calculation function
        function calculatePlanting() {
            // Get input values
            const areaLength = parseFloat(document.getElementById('areaLength').value);
            const areaWidth = parseFloat(document.getElementById('areaWidth').value);
            const plantSpacing = parseFloat(document.getElementById('plantSpacing').value);
            const rowSpacing = parseFloat(document.getElementById('rowSpacing').value);
            let borderSpacing = parseFloat(document.getElementById('borderSpacing').value);
            const autoBorder = document.getElementById('autoBorder').checked;
            
            // Validate inputs
            if (areaLength <= 0 || areaWidth <= 0 || plantSpacing <= 0 || rowSpacing <= 0 || borderSpacing < 0) {
                showWarning('Please enter valid positive values for all fields.');
                return;
            }
            
            // Auto-calculate border spacing if enabled
            if (autoBorder) {
                borderSpacing = Math.max(plantSpacing, rowSpacing) / 2;
                document.getElementById('borderSpacing').value = borderSpacing.toFixed(2);
            }
            
            // Check if border spacing is too large
            if (borderSpacing * 2 >= areaLength || borderSpacing * 2 >= areaWidth) {
                showWarning('Border spacing is too large. It must be less than half of the area length and width.');
                return;
            }
            
            // Check if spacing values are appropriate for the area
            if (plantSpacing > areaLength || rowSpacing > areaWidth) {
                showWarning('Plant spacing or row spacing is larger than the area dimensions. Please adjust values.');
                return;
            }
            
            // Hide any previous warnings
            hideWarning();
            
            // Calculate planting layout
            const effectiveLength = areaLength - 2 * borderSpacing;
            const effectiveWidth = areaWidth - 2 * borderSpacing;
            
            // Calculate plants per row and number of rows with square pattern
            const plantsPerRow = Math.floor(effectiveLength / plantSpacing) + 1;
            const numberOfRows = Math.floor(effectiveWidth / rowSpacing) + 1;
            
            // Calculate total plants
            const totalPlants = plantsPerRow * numberOfRows;
            
            // Calculate other metrics
            const effectiveArea = effectiveLength * effectiveWidth;
            const plantingDensity = totalPlants / effectiveArea;
            
            // Calculate space utilization (more accurate calculation)
            const plantArea = Math.PI * Math.pow(Math.min(plantSpacing, rowSpacing)/4, 2);
            const totalPlantArea = totalPlants * plantArea;
            const spaceUtilization = (totalPlantArea / effectiveArea) * 100;
            
            // Update results
            document.getElementById('totalPlants').textContent = totalPlants.toLocaleString();
            document.getElementById('plantsPerRow').textContent = plantsPerRow.toLocaleString();
            document.getElementById('numberOfRows').textContent = numberOfRows.toLocaleString();
            document.getElementById('effectiveArea').textContent = effectiveArea.toFixed(2) + ' m²';
            document.getElementById('plantingDensity').textContent = plantingDensity.toFixed(2) + ' plants/m²';
            document.getElementById('spaceUtilization').textContent = spaceUtilization.toFixed(1) + '%';
            
            // Show results container
            document.getElementById('resultsContainer').style.display = 'block';
            
            // Show legend
            document.getElementById('patternLegend').style.display = 'flex';
            
            // Show planting tips
            document.getElementById('plantingTips').style.display = 'block';
            
            // Generate visualization
            generateVisualization(plantsPerRow, numberOfRows, plantSpacing, rowSpacing, borderSpacing, effectiveLength, effectiveWidth);
        }
        
        function generateVisualization(plantsPerRow, numberOfRows, plantSpacing, rowSpacing, borderSpacing, effectiveLength, effectiveWidth) {
            const visualization = document.getElementById('visualization');
            visualization.innerHTML = '';
            
            // Create container for the pattern
            const container = document.createElement('div');
            container.className = 'square-pattern';
            visualization.appendChild(container);
            
            // Calculate scaling factors to fit visualization
            const visWidth = visualization.clientWidth - 40;
            const visHeight = visualization.clientHeight - 40;
            
            const scaleX = visWidth / effectiveLength;
            const scaleY = visHeight / effectiveWidth;
            const scale = Math.min(scaleX, scaleY);
            
            // Calculate scaled values
            const scaledPlantSpacing = plantSpacing * scale;
            const scaledRowSpacing = rowSpacing * scale;
            const scaledBorder = borderSpacing * scale;
            
            // Add grid lines for better visualization of the pattern
            const gridLines = document.createElement('div');
            gridLines.className = 'grid-lines';
            
            // Add horizontal lines (rows)
            for (let row = 0; row <= numberOfRows; row++) {
                const yPos = scaledBorder + row * scaledRowSpacing;
                if (yPos <= visHeight) {
                    const line = document.createElement('div');
                    line.className = 'grid-line horizontal';
                    line.style.top = yPos + 'px';
                    gridLines.appendChild(line);
                }
            }
            
            // Add vertical lines (columns)
            for (let col = 0; col <= plantsPerRow; col++) {
                const xPos = scaledBorder + col * scaledPlantSpacing;
                if (xPos <= visWidth) {
                    const line = document.createElement('div');
                    line.className = 'grid-line vertical';
                    line.style.left = xPos + 'px';
                    gridLines.appendChild(line);
                }
            }
            
            container.appendChild(gridLines);
            
            // Add plants - only show a representative pattern if there are too many plants
            let maxRowsToShow = numberOfRows;
            let maxColsToShow = plantsPerRow;
            
            if (plantsPerRow > 20 || numberOfRows > 20) {
                maxRowsToShow = Math.min(numberOfRows, 15);
                maxColsToShow = Math.min(plantsPerRow, 15);
            }
            
            for (let row = 0; row < maxRowsToShow; row++) {
                const yPos = scaledBorder + row * scaledRowSpacing;
                
                for (let col = 0; col < maxColsToShow; col++) {
                    const xPos = scaledBorder + col * scaledPlantSpacing;
                    
                    const plant = document.createElement('div');
                    plant.className = 'plant';
                    plant.style.left = xPos + 'px';
                    plant.style.top = yPos + 'px';
                    plant.title = `Plant ${row * maxColsToShow + col + 1} (Row ${row + 1}, Position ${col + 1})`;
                    
                    // Add plant number if there are not too many plants
                    if (maxRowsToShow <= 10 && maxColsToShow <= 10) {
                        plant.textContent = row * maxColsToShow + col + 1;
                    }
                    
                    container.appendChild(plant);
                }
            }
            
            // Add info text about the pattern
            const infoText = document.createElement('div');
            infoText.className = 'visualization-info';
            if (maxRowsToShow < numberOfRows || maxColsToShow < plantsPerRow) {
                infoText.innerHTML = `Showing ${maxRowsToShow} of ${numberOfRows} rows and ${maxColsToShow} of ${plantsPerRow} plants per row`;
            } else {
                infoText.innerHTML = `Showing all ${numberOfRows} rows and ${plantsPerRow} plants per row`;
            }
            container.appendChild(infoText);
            
            // Add border visualization
            const borderDiv = document.createElement('div');
            borderDiv.style.position = 'absolute';
            borderDiv.style.top = '0';
            borderDiv.style.left = '0';
            borderDiv.style.width = '100%';
            borderDiv.style.height = '100%';
            borderDiv.style.border = `${scaledBorder}px dashed rgba(0,0,0,0.3)`;
            borderDiv.style.pointerEvents = 'none';
            container.appendChild(borderDiv);
        }
        
        function resetForm() {
            document.getElementById('squareForm').reset();
            document.getElementById('resultsContainer').style.display = 'none';
            document.getElementById('patternLegend').style.display = 'none';
            document.getElementById('plantingTips').style.display = 'none';
            document.getElementById('visualization').innerHTML = `
                <div class="text-center text-muted">
                    <p>Visualization will appear here after calculation</p>
                    <p class="small">The square pattern arranges plants in straight rows and columns</p>
                </div>
            `;
            hideWarning();
        }
        
        function showWarning(message) {
            document.getElementById('warningText').textContent = message;
            document.getElementById('warningMessage').style.display = 'block';
        }
        
        function hideWarning() {
            document.getElementById('warningMessage').style.display = 'none';
        }
        
        function exportToCsv() {
            const totalPlants = document.getElementById('totalPlants').textContent;
            const plantsPerRow = document.getElementById('plantsPerRow').textContent;
            const numberOfRows = document.getElementById('numberOfRows').textContent;
            const effectiveArea = document.getElementById('effectiveArea').textContent;
            const plantingDensity = document.getElementById('plantingDensity').textContent;
            const spaceUtilization = document.getElementById('spaceUtilization').textContent;
            
            const csvContent = 
                "Square Planting System Calculation Results\n\n" +
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
            a.download = 'planting_calculation_results.csv';
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
    </script>
</body>
</html>