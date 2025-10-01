<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triangular Planting Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .calculator-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        header {
            border-bottom: 1px solid #eaeaea;
            margin-bottom: 25px;
            padding-bottom: 15px;
        }
        
        .btn-calculate {
            background-color: #28a745;
            color: white;
            padding: 10px 30px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .btn-calculate:hover {
            background-color: #218838;
        }
        
        .btn-dashboard {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-dashboard:hover {
            background-color: #5a6268;
            color: white;
        }
        
        .results-container {
            background-color: #f1f8e9;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .result-value {
            font-weight: bold;
            color: #2e7d32;
        }
        
        .visualization-container {
            margin-top: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            background-color: #fafafa;
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
        
        .visualization {
            position: relative;
            width: 100%;
            height: 400px;
            border: 1px solid #ddd;
            background-color: #f0f8f0;
            overflow: hidden;
            cursor: grab;
        }
        
        .planting-area {
            position: absolute;
            top: 50%;
            left: 50%;
            transform-origin: center;
            transition: transform 0.2s;
        }
        
        .plant {
            position: absolute;
            width: 25px;
            height: 25px;
            background-color: #4caf50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
            font-weight: bold;
            transform: translate(-50%, -50%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .plant.alternating {
            background-color: #388e3c;
        }
        
        .row-label, .col-label {
            position: absolute;
            font-size: 10px;
            color: #666;
        }
        
        .row-label {
            left: -40px;
            transform: translateY(-50%);
        }
        
        .col-label {
            top: -25px;
            transform: translateX(-50%);
        }
        
        .triangle-connectors {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
        }
        
        .connector {
            stroke: #81c784;
            stroke-width: 1;
            stroke-dasharray: 3,3;
        }
        
        .pattern-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #e8f5e9;
            border-radius: 8px;
            border-left: 4px solid #4caf50;
        }
        
        footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            color: #6c757d;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .controls {
                flex-direction: column;
            }
            
            .zoom-controls {
                margin-top: 10px;
            }
            
            .visualization {
                height: 300px;
            }
            
            .header-buttons {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container calculator-container">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="text-2xl font-bold text-green-700">🌱 Triangular Planting Calculator</h1>
                    <div class="d-flex gap-3 header-buttons">
                        <button onclick="resetForm()" class="btn btn-outline-secondary">
                            Reset
                        </button>
                        <button onclick="goToDashboard()" class="btn-dashboard">
                          <a href="{{ route('dashboard') }}"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200">
                                ← Back to Dashboard
                          </a>

                        </button>
                    </div>
                </div>
            </div>
        </header>
        
        <form id="triangleForm">
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
                        <div class="input-group">
                            <input type="number" class="form-control" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" required value="1.5">
                            <select class="form-select" id="spacingUnit" name="spacingUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
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
        
        <div class="visualization-container" id="visualizationContainer" style="display: none;">
            <div class="controls">
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
            <div class="visualization" id="visualization">
                <!-- Visualization will be generated here -->
            </div>
        </div>
        
        <div class="pattern-info">
            <h5>About Triangular Planting Pattern</h5>
            <p class="mb-0">The triangular planting pattern arranges plants in offset rows, creating equilateral triangles between plants. This pattern maximizes space utilization and allows each plant to have equal access to resources like sunlight, water, and nutrients.</p>
        </div>
    </div>
    
    <footer>
        <p>Triangular Planting System Calculator &copy; 2023</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calculateBtn = document.getElementById('calculateBtn');
            const form = document.getElementById('triangleForm');
            const resultsContainer = document.getElementById('resultsContainer');
            const visualizationContainer = document.getElementById('visualizationContainer');
            const showConnectorsCheckbox = document.getElementById('showConnectors');
            const zoomInBtn = document.getElementById('zoomIn');
            const zoomOutBtn = document.getElementById('zoomOut');
            const resetViewBtn = document.getElementById('resetView');
            
            let currentScale = 1;
            let currentOffsetX = 0;
            let currentOffsetY = 0;
            let isDragging = false;
            let startX, startY;
            
            // Conversion factors to meters
            const conversionRates = {
                'm': 1,
                'ft': 0.3048,
                'cm': 0.01,
                'in': 0.0254
            };
            
            calculateBtn.addEventListener('click', calculate);
            showConnectorsCheckbox.addEventListener('change', toggleConnectors);
            zoomInBtn.addEventListener('click', zoomIn);
            zoomOutBtn.addEventListener('click', zoomOut);
            resetViewBtn.addEventListener('click', resetView);
            
            // Add panning functionality
            const visualization = document.getElementById('visualization');
            visualization.addEventListener('mousedown', startDragging);
            visualization.addEventListener('mousemove', drag);
            visualization.addEventListener('mouseup', stopDragging);
            visualization.addEventListener('mouseleave', stopDragging);
            
            function calculate() {
                // Get input values
                const areaLength = parseFloat(document.getElementById('areaLength').value);
                const areaWidth = parseFloat(document.getElementById('areaWidth').value);
                const plantSpacing = parseFloat(document.getElementById('plantSpacing').value);
                const borderSpacing = parseFloat(document.getElementById('borderSpacing').value);
                
                // Get selected units
                const lengthUnit = document.getElementById('lengthUnit').value;
                const widthUnit = document.getElementById('widthUnit').value;
                const spacingUnit = document.getElementById('spacingUnit').value;
                const borderUnit = document.getElementById('borderUnit').value;
                
                // Validate inputs
                if (isNaN(areaLength) || isNaN(areaWidth) || isNaN(plantSpacing) || isNaN(borderSpacing) ||
                    areaLength <= 0 || areaWidth <= 0 || plantSpacing <= 0 || borderSpacing < 0) {
                    alert('Please enter valid positive values for all fields.');
                    return;
                }
                
                if (borderSpacing * 2 >= areaLength || borderSpacing * 2 >= areaWidth) {
                    alert('Border spacing is too large. It must be less than half of the area length and width.');
                    return;
                }
                
                // Convert all values to meters
                const areaLengthM = areaLength * conversionRates[lengthUnit];
                const areaWidthM = areaWidth * conversionRates[widthUnit];
                const plantSpacingM = plantSpacing * conversionRates[spacingUnit];
                const borderSpacingM = borderSpacing * conversionRates[borderUnit];
                
                // Calculate effective planting area
                const effectiveLength = Math.max(0, areaLengthM - 2 * borderSpacingM);
                const effectiveWidth = Math.max(0, areaWidthM - 2 * borderSpacingM);
                
                if (effectiveLength <= 0 || effectiveWidth <= 0) {
                    alert('Border spacing is too large for the given area.');
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
                document.getElementById('totalPlants').textContent = totalPlants;
                document.getElementById('plantsPerRow').textContent = plantsPerRow;
                document.getElementById('numberOfRows').textContent = numberOfRows;
                document.getElementById('effectiveArea').textContent = effectiveArea.toFixed(2) + ' m²';
                document.getElementById('plantingDensity').textContent = plantingDensity.toFixed(2) + ' plants/m²';
                document.getElementById('spaceUtilization').textContent = spaceUtilization.toFixed(1) + '%';
                
                // Show results and visualization
                resultsContainer.style.display = 'block';
                visualizationContainer.style.display = 'block';
                
                // Generate visualization
                generateVisualization(plantsPerRow, numberOfRows, plantSpacingM, rowSpacing, effectiveLength, effectiveWidth);
            }
            
            function generateVisualization(plantsPerRow, numberOfRows, plantSpacing, rowSpacing, areaLength, areaWidth) {
                const visualization = document.getElementById('visualization');
                visualization.innerHTML = '';
                
                // Create planting area container
                const plantingArea = document.createElement('div');
                plantingArea.classList.add('planting-area');
                visualization.appendChild(plantingArea);
                
                // Create SVG for connectors
                const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.classList.add('triangle-connectors');
                svg.setAttribute('width', '100%');
                svg.setAttribute('height', '100%');
                plantingArea.appendChild(svg);
                
                // Calculate scale to fit visualization
                const containerWidth = visualization.clientWidth;
                const containerHeight = visualization.clientHeight;
                
                const scaleX = containerWidth / areaLength;
                const scaleY = containerHeight / areaWidth;
                const scale = Math.min(scaleX, scaleY) * 0.8; // 80% to add some padding
                
                // Create plants
                const plants = [];
                
                for (let row = 0; row < numberOfRows; row++) {
                    const isEvenRow = row % 2 === 0;
                    const rowOffset = isEvenRow ? plantSpacing / 2 : 0;
                    
                    for (let col = 0; col < plantsPerRow; col++) {
                        const plant = document.createElement('div');
                        plant.classList.add('plant');
                        if ((row + col) % 2 === 0) plant.classList.add('alternating');
                        
                        plant.textContent = (row * plantsPerRow + col + 1);
                        
                        // Position plant
                        const x = (col * plantSpacing + rowOffset) * scale;
                        const y = (row * rowSpacing) * scale;
                        
                        plant.style.left = x + 'px';
                        plant.style.top = y + 'px';
                        
                        plantingArea.appendChild(plant);
                        plants.push({x: x, y: y, element: plant, row: row, col: col});
                    }
                }
                
                // Set planting area dimensions
                plantingArea.style.width = (areaLength * scale) + 'px';
                plantingArea.style.height = (areaWidth * scale) + 'px';
                
                // Center the planting area
                plantingArea.style.transform = `translate(${-areaLength * scale / 2}px, ${-areaWidth * scale / 2}px)`;
                
                // Create row and column labels
                createLabels(plantingArea, plantsPerRow, numberOfRows, plantSpacing, rowSpacing, scale);
                
                // Draw connectors between plants to form triangles
                drawConnectors(plants, plantsPerRow, numberOfRows, svg, scale);
                
                // Reset view
                resetView();
            }
            
            function createLabels(plantingArea, plantsPerRow, numberOfRows, plantSpacing, rowSpacing, scale) {
                // Add row labels
                for (let row = 0; row < numberOfRows; row++) {
                    const label = document.createElement('div');
                    label.classList.add('row-label');
                    label.textContent = `Row ${row + 1}`;
                    label.style.top = (row * rowSpacing * scale) + 'px';
                    plantingArea.appendChild(label);
                }
                
                // Add column labels
                for (let col = 0; col < plantsPerRow; col++) {
                    const label = document.createElement('div');
                    label.classList.add('col-label');
                    label.textContent = `Col ${col + 1}`;
                    label.style.left = (col * plantSpacing * scale) + 'px';
                    plantingArea.appendChild(label);
                }
            }
            
            function drawConnectors(plants, plantsPerRow, numberOfRows, svg, scale) {
                // Clear previous connectors
                svg.innerHTML = '';
                
                if (!showConnectorsCheckbox.checked) return;
                
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
                const plantsPerRow = parseInt(document.getElementById('plantsPerRow').textContent) || 5;
                const numberOfRows = parseInt(document.getElementById('numberOfRows').textContent) || 4;
                const plantSpacing = 1.5; // Default value
                const rowSpacing = plantSpacing * Math.sqrt(3) / 2;
                
                const svg = document.querySelector('.triangle-connectors');
                if (svg) {
                    const plants = Array.from(document.querySelectorAll('.plant')).map(plant => {
                        const style = window.getComputedStyle(plant);
                        return {
                            x: parseFloat(style.left) + 12.5, // Half of plant width
                            y: parseFloat(style.top) + 12.5,  // Half of plant height
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
                visualization.style.cursor = 'grabbing';
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
                visualization.style.cursor = 'grab';
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
                const plantingArea = document.querySelector('.planting-area');
                if (plantingArea) {
                    plantingArea.style.transform = `translate(${currentOffsetX}px, ${currentOffsetY}px) scale(${currentScale})`;
                }
            }
            
            function resetForm() {
                document.getElementById('triangleForm').reset();
                resultsContainer.style.display = 'none';
                visualizationContainer.style.display = 'none';
            }
            
            // Function to navigate back to dashboard
            function goToDashboard() {
                // You can replace this with your actual dashboard URL
                // For demonstration, we'll use a simple alert and history back
                if (confirm('Return to Dashboard? Any unsaved changes will be lost.')) {
                    // If this is part of a larger application, you would redirect to the dashboard
                    // window.location.href = '/dashboard';
                    
                    // For this demo, we'll just go back in history
                    window.history.back();
                }
            }
            
            // Calculate on page load with default values
            calculate();
        });
    </script>
</body>
</html>