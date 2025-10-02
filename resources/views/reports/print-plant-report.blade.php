<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Report - Print Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Define print styles */
        @media print {
            @page {
                margin: 1.5cm;
            }
            body {
                font-size: 12pt;
                background: #fff !important;
                color: #000;
            }
            .no-print {
                display: none !important;
            }
            .print-section {
                page-break-inside: avoid;
            }
            /* Ensure backgrounds and colors are print-friendly */
            .bg-gradient-to-br, .backdrop-blur-sm, .bg-green-50\/80 {
                background: white !important;
                backdrop-filter: none !important;
            }
            .text-transparent {
                color: #000 !important;
            }
            /* Improve text readability */
            .text-green-800, .text-green-700, .text-gray-800 {
                color: #000 !important;
            }
        }

        /* Screen-only styles */
        @media screen {
            .print-section {
                max-width: 21cm;
                margin: 2rem auto;
                padding: 2rem;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Print Button for Screen -->
    <div class="no-print text-center p-6">
        <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
            🖨️ Print Report
        </button>
        <p class="text-sm text-gray-600 mt-2">Use this button to print the report below.</p>
    </div>

    <!-- Print Report Content -->
    <div class="print-section bg-white">
        <!-- Report Header -->
        <div class="text-center mb-8 border-b-2 border-green-200 pb-6">
            <h1 class="text-3xl font-bold text-green-800 mb-2">🌿 Plantation System Report</h1>
            <p class="text-green-700">{{ date('F Y') }}</p>
            <p class="text-sm text-gray-600 mt-2">Generated on: {{ date('M j, Y g:i A') }}</p>
        </div>

        <!-- Summary Statistics -->
        <div class="mb-8 print-section">
            <h2 class="text-xl font-semibold text-green-800 mb-4 border-b border-green-100 pb-2">Report Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 border-2 border-green-200 rounded-lg">
                    <div class="text-2xl font-bold text-green-700 mb-1" id="printTotalTypes">0</div>
                    <div class="text-green-600 font-medium">Total Plant Types</div>
                </div>
                <div class="text-center p-4 border-2 border-green-200 rounded-lg">
                    <div class="text-2xl font-bold text-green-700 mb-1" id="printTotalPlants">0</div>
                    <div class="text-green-600 font-medium">Total Plants</div>
                </div>
                <div class="text-center p-4 border-2 border-green-200 rounded-lg">
                    <div class="text-2xl font-bold text-green-700 mb-1">{{ date('M Y') }}</div>
                    <div class="text-green-600 font-medium">Reporting Period</div>
                </div>
            </div>
        </div>

        <!-- Plant Data Table -->
        <div class="print-section">
            <h2 class="text-xl font-semibold text-green-800 mb-4 border-b border-green-100 pb-2">Plant Inventory Details</h2>
            <table class="w-full border-collapse border border-green-300">
                <thead>
                    <tr class="bg-green-100">
                        <th class="text-left py-3 px-4 font-semibold text-green-800 border border-green-300">Plant Type</th>
                        <th class="text-left py-3 px-4 font-semibold text-green-800 border border-green-300">Date Planted</th>
                        <th class="text-left py-3 px-4 font-semibold text-green-800 border border-green-300">Quantity</th>
                    </tr>
                </thead>
                <tbody id="printPlantData">
                    <!-- Empty state matches monthly report -->
                    <tr>
                        <td colspan="3" class="py-8 text-center border border-green-300">
                            <div class="flex flex-col items-center text-green-500">
                                <span class="text-2xl mb-2">🌱</span>
                                <p class="text-lg font-medium">No plant data available</p>
                                <p class="text-sm text-green-600 mt-1">Add some plants to see them here</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Report Footer -->
        <div class="mt-12 pt-6 border-t-2 border-green-200 text-center text-sm text-gray-600">
            <p>Plantation System Report • Generated on {{ date('F j, Y') }} • Confidential</p>
        </div>
    </div>

    <script>
        // Function to update print report data
        function updatePrintReport(plantData) {
            const tableBody = document.getElementById('printPlantData');
            const totalTypesElement = document.getElementById('printTotalTypes');
            const totalPlantsElement = document.getElementById('printTotalPlants');
            
            if (!plantData || !Array.isArray(plantData) || plantData.length === 0) {
                // Maintain empty state
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="py-8 text-center border border-green-300">
                            <div class="flex flex-col items-center text-green-500">
                                <span class="text-2xl mb-2">🌱</span>
                                <p class="text-lg font-medium">No plant data available</p>
                                <p class="text-sm text-green-600 mt-1">Add some plants to see them here</p>
                            </div>
                        </td>
                    </tr>
                `;
                totalTypesElement.textContent = '0';
                totalPlantsElement.textContent = '0';
                return;
            }
            
            // Populate with data
            tableBody.innerHTML = '';
            let totalPlants = 0;
            
            plantData.forEach((plant, index) => {
                const plantType = plant.type || 'Unknown';
                const datePlanted = plant.date_planted ? 
                    new Date(plant.date_planted).toLocaleDateString('en-US', { 
                        month: 'short', day: 'numeric', year: 'numeric' 
                    }) : 'Not set';
                const numberOfPlants = plant.number_of_plants ?? 0;
                totalPlants += numberOfPlants;
                
                const row = document.createElement('tr');
                row.className = index % 2 === 0 ? 'bg-white' : 'bg-green-50';
                row.innerHTML = `
                    <td class="py-3 px-4 border border-green-300 text-gray-800">${plantType}</td>
                    <td class="py-3 px-4 border border-green-300 text-green-700">${datePlanted}</td>
                    <td class="py-3 px-4 border border-green-300 text-green-700">${numberOfPlants}</td>
                `;
                tableBody.appendChild(row);
            });
            
            totalTypesElement.textContent = plantData.length;
            totalPlantsElement.textContent = totalPlants;
        }

        // Initialize with empty data
        document.addEventListener('DOMContentLoaded', function() {
            updatePrintReport([]);
            
            // Listen for data updates from parent (if embedded)
            window.addEventListener('message', function(event) {
                if (event.data && event.data.type === 'PLANT_DATA_UPDATE') {
                    updatePrintReport(event.data.plants);
                }
            });
        });

        // Make function globally accessible
        window.updatePrintReport = updatePrintReport;
    </script>
</body>
</html>
