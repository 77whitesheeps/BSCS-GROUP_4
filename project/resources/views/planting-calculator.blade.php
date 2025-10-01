<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Square Planting System Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color:  #2e7d32;
            --secondary-color: #4caf50;
            --accent-color: #8bc34a;
            --dark-color: #1b5e20; 
            --light-color: #c8e6c9; 
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
            max-width: 1000px;
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
            height: 300px;
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
        
        @media (max-width: 768px) {
            .calculator-container {
                padding: 1rem;
                margin: 1rem;
            }
            
            .visualization {
                height: 200px;
            }
            
            .plant {
                width: 15px;
                height: 15px;
                font-size: 0.5rem;
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
                    
                    <div class="mb-3">
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
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="plantSpacing" class="form-label">Plant Spacing</label>
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
                            <input type="checkbox" id="autoBorder" checked> 
                            <label for="autoBorder">Auto-calculate border spacing based on plant spacing</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button type="button" id="calculateBtn" class="btn btn-calculate btn-lg">Calculate</button>
            </div>
        </form>
        
        <div class="results-container" id="resultsContainer" style="display: none;">
            <h3 class="mb-4">Calculation Results</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Number of Plants:</span>
                        <span class="result-value" id="totalPlants">0</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Plants per Row:</span>
                        <span class="result-value" id="plantsPerRow">0</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Number of Rows:</span>
                        <span class="result-value" id="numberOfRows">0</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Effective Area:</span>
                        <span class="result-value" id="effectiveArea">0 m²</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Planting Density:</span>
                        <span class="result-value" id="plantingDensity">0 plants/m²</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Space Utilization:</span>
                        <span class="result-value" id="spaceUtilization">0%</span>
                    </div>
                </div>
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
    </div>
    
    <footer>
        <p>Square Planting System Calculator &copy; {{ date('Y') }}</p>
    </footer>

    <script>
        document.getElementById('calculateBtn').addEventListener('click', function() {
            // Get input values
            const areaLength = parseFloat(document.getElementById('areaLength').value);
            const areaWidth = parseFloat(document.getElementById('areaWidth').value);
            const plantSpacing = parseFloat(document.getElementById('plantSpacing').value);
            const rowSpacing = parseFloat(document.getElementById('rowSpacing').value);
            let borderSpacing = parseFloat(document.getElementById('borderSpacing').value);
            const autoBorder = document.getElementById('autoBorder').checked;
            
            // Validate inputs
            if (areaLength <= 0 || areaWidth <= 0 || plantSpacing <= 0 || rowSpacing <= 0 || borderSpacing < 0) {
                alert('Please enter valid positive values for all fields.');
                return;
            }
            
            // Auto-calculate border spacing if enabled
            if (autoBorder) {
                borderSpacing = Math.max(plantSpacing, rowSpacing) / 2;
                document.getElementById('borderSpacing').value = borderSpacing.toFixed(2);
            }
            
            if (borderSpacing * 2 >= areaLength || borderSpacing * 2 >= areaWidth) {
                alert('Border spacing is too large. It must be less than half of the area length and width.');
                return;
            }
            
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
            const spaceUtilization = (totalPlants * Math.PI * Math.pow(Math.min(plantSpacing, rowSpacing)/4, 2)) / effectiveArea * 100;
            
            // Update results
            document.getElementById('totalPlants').textContent = totalPlants;
            document.getElementById('plantsPerRow').textContent = plantsPerRow;
            document.getElementById('numberOfRows').textContent = numberOfRows;
            document.getElementById('effectiveArea').textContent = effectiveArea.toFixed(2) + ' m²';
            document.getElementById('plantingDensity').textContent = plantingDensity.toFixed(2) + ' plants/m²';
            document.getElementById('spaceUtilization').textContent = spaceUtilization.toFixed(1) + '%';
            
            // Show results container
            document.getElementById('resultsContainer').style.display = 'block';
            
            // Show legend
            document.getElementById('patternLegend').style.display = 'flex';
            
            // Generate visualization
            generateVisualization(plantsPerRow, numberOfRows, plantSpacing, rowSpacing, borderSpacing, effectiveLength, effectiveWidth);
        });
        
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
            
            // Add grid lines for better visualization of the pattern
            const gridLines = document.createElement('div');
            gridLines.className = 'grid-lines';
            
            // Add horizontal lines (rows)
            for (let row = 0; row <= numberOfRows; row++) {
                const yPos = row * scaledRowSpacing;
                if (yPos <= visHeight) {
                    const line = document.createElement('div');
                    line.className = 'grid-line horizontal';
                    line.style.top = yPos + 'px';
                    gridLines.appendChild(line);
                }
            }
            
            // Add vertical lines (columns)
            for (let col = 0; col <= plantsPerRow; col++) {
                const xPos = col * scaledPlantSpacing;
                if (xPos <= visWidth) {
                    const line = document.createElement('div');
                    line.className = 'grid-line vertical';
                    line.style.left = xPos + 'px';
                    gridLines.appendChild(line);
                }
            }
            
            container.appendChild(gridLines);
            
            // Add plants - only show a representative pattern (max 6x6 grid)
            const maxRowsToShow = Math.min(numberOfRows, 6);
            const maxColsToShow = Math.min(plantsPerRow, 6);
            
            for (let row = 0; row < maxRowsToShow; row++) {
                const yPos = row * scaledRowSpacing;
                
                for (let col = 0; col < maxColsToShow; col++) {
                    const xPos = col * scaledPlantSpacing;
                    
                    const plant = document.createElement('div');
                    plant.className = 'plant';
                    plant.style.left = xPos + 'px';
                    plant.style.top = yPos + 'px';
                    
                    container.appendChild(plant);
                }
            }
            
            // Add info text about the pattern
            const infoText = document.createElement('div');
            infoText.className = 'visualization-info';
            infoText.innerHTML = `Showing ${maxRowsToShow} rows × ${maxColsToShow} plants pattern`;
            container.appendChild(infoText);
        }
        
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
    </script>
</body>
</html>