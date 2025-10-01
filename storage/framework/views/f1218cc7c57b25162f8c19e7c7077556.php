<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Square Planting Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-green-700">Square Planting Calculator</h1>
                    <a href="<?php echo e(route('dashboard')); ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Calculator Form -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Enter Planting Details</h2>
                    
                    <form id="plantingCalculatorForm">
                        <?php echo csrf_field(); ?>
                        <div class="space-y-4">
                            <!-- Area Dimensions -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="areaLength" class="block text-sm font-medium text-gray-700">Area Length (m)</label>
                                    <input type="number" id="areaLength" name="areaLength" step="0.01" min="0.01" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                           placeholder="e.g., 10" required>
                                </div>
                                <div>
                                    <label for="areaWidth" class="block text-sm font-medium text-gray-700">Area Width (m)</label>
                                    <input type="number" id="areaWidth" name="areaWidth" step="0.01" min="0.01" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                           placeholder="e.g., 5" required>
                                </div>
                            </div>

                            <!-- Spacing -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="plantSpacing" class="block text-sm font-medium text-gray-700">Plant Spacing (m)</label>
                                    <input type="number" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                           placeholder="e.g., 0.3" required>
                                </div>
                                <div>
                                    <label for="rowSpacing" class="block text-sm font-medium text-gray-700">Row Spacing (m)</label>
                                    <input type="number" id="rowSpacing" name="rowSpacing" step="0.01" min="0.01" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                           placeholder="e.g., 0.4" required>
                                </div>
                            </div>

                            <!-- Border Spacing -->
                            <div>
                                <label for="borderSpacing" class="block text-sm font-medium text-gray-700">Border Spacing (m)</label>
                                <input type="number" id="borderSpacing" name="borderSpacing" step="0.01" min="0" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                       placeholder="e.g., 0.5" value="0" required>
                                <p class="text-xs text-gray-500 mt-1">Space to leave around the edges of the area</p>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200">
                                Calculate Planting Layout
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Results Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Calculation Results</h2>
                    <div id="results" class="space-y-4 hidden">
                        <!-- Results will be displayed here -->
                    </div>
                    <div id="loading" class="hidden text-center py-8">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto"></div>
                        <p class="mt-2 text-gray-600">Calculating...</p>
                    </div>
                    <div id="error" class="hidden text-center py-8 text-red-600"></div>
                </div>
            </div>

            <!-- Visualization Section -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Planting Layout Visualization</h2>
                <div id="visualization" class="hidden">
                    <canvas id="plantingChart" width="400" height="200"></canvas>
                </div>
                <div id="noData" class="text-center py-8 text-gray-500">
                    Enter values and calculate to see visualization
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('plantingCalculatorForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const resultsDiv = document.getElementById('results');
            const loadingDiv = document.getElementById('loading');
            const errorDiv = document.getElementById('error');
            const visualizationDiv = document.getElementById('visualization');
            const noDataDiv = document.getElementById('noData');
            
            // Show loading, hide others
            loadingDiv.classList.remove('hidden');
            resultsDiv.classList.add('hidden');
            errorDiv.classList.add('hidden');
            visualizationDiv.classList.add('hidden');
            noDataDiv.classList.add('hidden');
            
            fetch('<?php echo e(route("calculate.plants")); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                loadingDiv.classList.add('hidden');
                
                if (data.error) {
                    errorDiv.textContent = data.error;
                    errorDiv.classList.remove('hidden');
                    return;
                }
                
                // Display results
                resultsDiv.innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800">Total Plants</h3>
                            <p class="text-2xl font-bold text-green-600">${data.totalPlants}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800">Plants per Row</h3>
                            <p class="text-2xl font-bold text-blue-600">${data.plantsPerRow}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-purple-800">Number of Rows</h3>
                            <p class="text-2xl font-bold text-purple-600">${data.numberOfRows}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-yellow-800">Space Utilization</h3>
                            <p class="text-2xl font-bold text-yellow-600">${data.spaceUtilization}%</p>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-600">
                        <p>Effective Planting Area: ${data.effectiveArea} m²</p>
                        <p>Planting Density: ${data.plantingDensity} plants/m²</p>
                    </div>
                `;
                
                resultsDiv.classList.remove('hidden');
                visualizationDiv.classList.remove('hidden');
                noDataDiv.classList.add('hidden');
                
                // Create visualization chart
                createVisualizationChart(data);
            })
            .catch(error => {
                loadingDiv.classList.add('hidden');
                errorDiv.textContent = error.error || 'An error occurred during calculation';
                errorDiv.classList.remove('hidden');
            });
        });
        
        function createVisualizationChart(data) {
            const ctx = document.getElementById('plantingChart').getContext('2d');
            
            // Destroy existing chart if it exists
            if (window.plantingChart instanceof Chart) {
                window.plantingChart.destroy();
            }
            
            window.plantingChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Plants per Row', 'Number of Rows', 'Total Plants'],
                    datasets: [{
                        label: 'Planting Metrics',
                        data: [data.plantsPerRow, data.numberOfRows, data.totalPlants],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(139, 92, 246, 0.8)'
                        ],
                        borderColor: [
                            'rgb(34, 197, 94)',
                            'rgb(59, 130, 246)',
                            'rgb(139, 92, 246)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Planting Layout Summary'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Quantity'
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\G4_APP-DEV\project\resources\views/planting-calculator.blade.php ENDPATH**/ ?>