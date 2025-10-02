<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen">
    <div id="plantReport" class="p-6">
        <!-- Simple Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-700 bg-clip-text text-transparent mb-2">
                🌿 Plant Report
            </h1>
            <div class="inline-flex items-center bg-white/80 backdrop-blur-sm rounded-2xl px-6 py-3 shadow-sm border border-green-100">
                <div class="w-3 h-3 bg-green-400 rounded-full mr-3 animate-pulse"></div>
                <p class="text-green-800 font-medium">{{ date('F Y') }}</p>
            </div>
        </div>

        <!-- Data Display Area -->
        <div class="space-y-6">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <span class="mr-2">📊</span>
                        Plant Inventory
                    </h2>
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="bg-green-50/80">
                            <th class="text-left py-4 px-6 font-semibold text-green-800 border-b border-green-100">Plant Type</th>
                            <th class="text-left py-4 px-6 font-semibold text-green-800 border-b border-green-100">Date Planted</th>
                            <th class="text-left py-4 px-6 font-semibold text-green-800 border-b border-green-100">Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="plantData">
                        <!-- Empty state by default -->
                        <tr>
                            <td colspan="3" class="py-8 text-center">
                                <div class="flex flex-col items-center text-green-400">
                                    <span class="text-4xl mb-2">🌱</span>
                                    <p class="text-lg font-medium">No plant data available</p>
                                    <p class="text-sm text-green-500 mt-1">Add some plants to see them here</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Summary Stats -->
            <div id="summaryStats" class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-cyan-100 rounded-xl border border-blue-200">
                        <div class="text-2xl font-bold text-blue-600 mb-1" id="totalTypes">0</div>
                        <div class="text-blue-700 font-medium">Total Plant Types</div>
                        <div class="text-blue-500 text-sm mt-1">🌿 Different varieties</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-emerald-50 to-green-100 rounded-xl border border-emerald-200">
                        <div class="text-2xl font-bold text-emerald-600 mb-1" id="totalPlants">0</div>
                        <div class="text-emerald-700 font-medium">Total Plants</div>
                        <div class="text-emerald-500 text-sm mt-1">📈 Overall count</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global function to update plant data from external calculations
        function updatePlantData(newData) {
            const tableBody = document.getElementById('plantData');
            const totalTypesElement = document.getElementById('totalTypes');
            const totalPlantsElement = document.getElementById('totalPlants');
            
            // Handle empty or invalid data
            if (!newData || !Array.isArray(newData) || newData.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="py-8 text-center">
                            <div class="flex flex-col items-center text-green-400">
                                <span class="text-4xl mb-2">🌱</span>
                                <p class="text-lg font-medium">No plant data available</p>
                                <p class="text-sm text-green-500 mt-1">Add some plants to see them here</p>
                            </div>
                        </td>
                    </tr>
                `;
                totalTypesElement.textContent = '0';
                totalPlantsElement.textContent = '0';
                return;
            }
            
            // Clear existing data
            tableBody.innerHTML = '';
            
            // Add new data rows with alternating colors
            newData.forEach((plant, index) => {
                const plantType = plant.type || 'Unknown';
                const datePlanted = plant.date_planted ? 
                    new Date(plant.date_planted).toLocaleDateString('en-US', { 
                        month: 'short', day: 'numeric', year: 'numeric' 
                    }) : 'Not set';
                const numberOfPlants = plant.number_of_plants ?? 0;
                
                const row = document.createElement('tr');
                row.className = index % 2 === 0 ? 'bg-white' : 'bg-green-50/50';
                row.innerHTML = `
                    <td class="py-4 px-6 text-gray-800 font-medium">
                        <div class="flex items-center">
                            <span class="text-lg mr-3">🌿</span>
                            ${plantType}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-green-700">
                        <div class="flex items-center">
                            <span class="text-sm mr-2">📅</span>
                            ${datePlanted}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                            <span class="mr-1">🌻</span>
                            ${numberOfPlants} plants
                        </span>
                    </td>
                `;
                tableBody.appendChild(row);
            });
            
            // Update summary stats
            const totalTypes = newData.length;
            const totalPlants = newData.reduce((sum, plant) => sum + (plant.number_of_plants ?? 0), 0);
            
            totalTypesElement.textContent = totalTypes;
            totalPlantsElement.textContent = totalPlants;
        }

        // Function to receive data from parent window (if embedded)
        function receivePlantData(event) {
            if (event.data && event.data.type === 'PLANT_DATA_UPDATE') {
                updatePlantData(event.data.plants);
            }
        }

        // Listen for messages from parent window
        window.addEventListener('message', receivePlantData);

        // Make update function globally accessible
        window.updatePlantReport = updatePlantData;

        // Initialize with empty state
        document.addEventListener('DOMContentLoaded', function() {
            // Start with empty data
            updatePlantData([]);
        });
    </script>
</body>
</html>