<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quincunx Planting Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .plant-dot {
            transition: all 0.3s ease;
        }
        .plant-dot:hover {
            transform: scale(1.2);
        }
        .pattern-grid {
            background-image: 
                linear-gradient(to right, #e5e7eb 1px, transparent 1px),
                linear-gradient(to bottom, #e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
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
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-green-700">🌱 Quincunx Planting Calculator</h1>
                    <div class="flex gap-3">
                        <button onclick="resetForm()" class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-lg hover:bg-gray-100 transition duration-200">
                            Reset
                        </button>
                        <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                            ← Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 fade-in">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 fade-in">
                    <p>✓ {{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Calculator Form -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <span class="mr-2">📐</span>
                        Enter Planting Details
                    </h2>
                    
                    <form method="POST" action="{{ route('calculate.quincunx') }}">
                        @csrf
                        <div class="space-y-4">
                            <!-- Area Dimensions -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="areaLength" class="block text-sm font-medium text-gray-700">Area Length</label>
                                    <div class="flex gap-2">
                                        <input type="number" id="areaLength" name="areaLength" step="0.01" min="0.01" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                               value="{{ old('areaLength', $inputs['areaLength'] ?? '') }}" 
                                               placeholder="10" required>
                                        <select name="lengthUnit" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <option value="m" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? '') == 'm') ? 'selected' : '' }}>m</option>
                                            <option value="ft" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? '') == 'ft') ? 'selected' : '' }}>ft</option>
                                            <option value="cm" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? '') == 'cm') ? 'selected' : '' }}>cm</option>
                                            <option value="in" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? '') == 'in') ? 'selected' : '' }}>in</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="areaWidth" class="block text-sm font-medium text-gray-700">Area Width</label>
                                    <div class="flex gap-2">
                                        <input type="number" id="areaWidth" name="areaWidth" step="0.01" min="0.01" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                               value="{{ old('areaWidth', $inputs['areaWidth'] ?? '') }}" 
                                               placeholder="8" required>
                                        <select name="widthUnit" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <option value="m" {{ (old('widthUnit', $inputs['widthUnit'] ?? '') == 'm') ? 'selected' : '' }}>m</option>
                                            <option value="ft" {{ (old('widthUnit', $inputs['widthUnit'] ?? '') == 'ft') ? 'selected' : '' }}>ft</option>
                                            <option value="cm" {{ (old('widthUnit', $inputs['widthUnit'] ?? '') == 'cm') ? 'selected' : '' }}>cm</option>
                                            <option value="in" {{ (old('widthUnit', $inputs['widthUnit'] ?? '') == 'in') ? 'selected' : '' }}>in</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Spacing -->
                            <div>
                                <label for="plantSpacing" class="block text-sm font-medium text-gray-700">Plant Spacing</label>
                                <div class="flex gap-2">
                                    <input type="number" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                           value="{{ old('plantSpacing', $inputs['plantSpacing'] ?? '') }}" 
                                           placeholder="1.5" required>
                                    <select name="spacingUnit" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="m" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? '') == 'm') ? 'selected' : '' }}>m</option>
                                        <option value="ft" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? '') == 'ft') ? 'selected' : '' }}>ft</option>
                                        <option value="cm" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? '') == 'cm') ? 'selected' : '' }}>cm</option>
                                        <option value="in" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? '') == 'in') ? 'selected' : '' }}>in</option>
                                    </select>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Distance between plant centers</p>
                            </div>

                            <!-- Border Spacing -->
                            <div>
                                <label for="borderSpacing" class="block text-sm font-medium text-gray-700">Border Spacing</label>
                                <div class="flex gap-2">
                                    <input type="number" id="borderSpacing" name="borderSpacing" step="0.01" min="0" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                           value="{{ old('borderSpacing', $inputs['borderSpacing'] ?? 0) }}" 
                                           placeholder="0">
                                    <select name="borderUnit" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="m" {{ (old('borderUnit', $inputs['borderUnit'] ?? '') == 'm') ? 'selected' : '' }}>m</option>
                                        <option value="ft" {{ (old('borderUnit', $inputs['borderUnit'] ?? '') == 'ft') ? 'selected' : '' }}>ft</option>
                                        <option value="cm" {{ (old('borderUnit', $inputs['borderUnit'] ?? '') == 'cm') ? 'selected' : '' }}>cm</option>
                                        <option value="in" {{ (old('borderUnit', $inputs['borderUnit'] ?? '') == 'in') ? 'selected' : '' }}>in</option>
                                    </select>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Space to leave around the edges of the area</p>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200">
                                Calculate Quincunx Layout
                            </button>
                        </div>
                    </form>

                    <!-- Quick Examples -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-semibold text-blue-800 mb-2">Quick Examples:</h3>
                        <div class="space-y-2 text-sm">
                            <button onclick="setExample('orchard')" class="text-blue-600 hover:underline block">🍎 Apple Orchard (10m × 8m, 3m spacing)</button>
                            <button onclick="setExample('garden')" class="text-blue-600 hover:underline block">🌿 Herb Garden (5m × 3m, 0.5m spacing)</button>
                            <button onclick="setExample('vineyard')" class="text-blue-600 hover:underline block">🍇 Vineyard (20m × 15m, 2.5m spacing)</button>
                        </div>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <span class="mr-2">📊</span>
                        Calculation Results
                    </h2>
                    
                    @if(isset($results) && $results)
                        <div class="space-y-4 fade-in">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h3 class="font-semibold text-green-800">Total Plants</h3>
                                    <p class="text-2xl font-bold text-green-600">{{ number_format($results['totalPlants']) }}</p>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h3 class="font-semibold text-blue-800">Number of Rows</h3>
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($results['numberOfRows']) }}</p>
                                </div>
                                <div class="bg-purple-50 p-4 rounded-lg">
                                    <h3 class="font-semibold text-purple-800">Avg Plants/Row</h3>
                                    <p class="text-2xl font-bold text-purple-600">{{ $results['averagePlantsPerRow'] ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <h3 class="font-semibold text-yellow-800">Efficiency</h3>
                                    <p class="text-2xl font-bold text-yellow-600">{{ $results['efficiency'] ?? 'N/A' }}%</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p>Pattern Type: <span class="font-medium">{{ $results['patternType'] ?? 'Quincunx (Staggered)' }}</span></p>
                                <p>Effective Area: <span class="font-medium">{{ number_format($results['effectiveArea'], 2) }}</span> m²</p>
                                <p>Planting Density: <span class="font-medium">{{ number_format($results['plantingDensity'], 2) }}</span> plants/m²</p>
                                @if(isset($results['rowSpacing']))
                                    <p>Row Spacing: <span class="font-medium">{{ $results['rowSpacing'] }}</span> m</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-6xl mb-4">🌱</div>
                            <p>Enter values and calculate to see results</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Visualization Section -->
            @if(isset($results) && $results)
            <div class="mt-8 bg-white rounded-lg shadow-md p-6 fade-in">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <span class="mr-2">🎨</span>
                    Quincunx Pattern Visualization
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-semibold mb-2">Pattern Explanation</h3>
                        <p class="text-gray-600 mb-4">
                            The quincunx pattern arranges plants in a staggered formation where each plant 
                            in alternate rows is positioned between two plants in adjacent rows, creating 
                            a more efficient hexagonal packing arrangement.
                        </p>
                        <div class="bg-gray-100 p-4 rounded-lg mb-4">
                            <h4 class="font-semibold mb-2">Key Features:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>Staggered row arrangement</li>
                                <li>More efficient space utilization than square patterns</li>
                                <li>Ideal for orchards and perennial crops</li>
                                <li>Provides better light penetration and air circulation</li>
                                <li>Approximately 15% more efficient than square grid</li>
                            </ul>
                        </div>
                        
                        @if(isset($results['rowDetails']))
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-semibold mb-2 text-blue-800">Row Breakdown:</h4>
                                <div class="text-sm space-y-1 max-h-32 overflow-y-auto">
                                    @foreach($results['rowDetails'] as $row)
                                        <div class="{{ $row['offset'] ? 'text-blue-600' : 'text-green-600' }}">
                                            Row {{ $row['row'] }}: {{ $row['plants'] }} plants {{ $row['offset'] ? '(offset)' : '' }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <div class="relative w-80 h-80 bg-green-50 rounded-lg border border-green-200 pattern-grid overflow-hidden">
                            <div class="absolute inset-0 p-4">
                                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid meet">
                                    @if(isset($results['rowDetails']))
                                        @php
                                            $maxRows = min(count($results['rowDetails']), 8);
                                            $maxCols = min(max(array_column($results['rowDetails'], 'plants')), 8);
                                        @endphp
                                        @foreach(array_slice($results['rowDetails'], 0, $maxRows) as $rowIndex => $row)
                                            @php
                                                $y = 15 + ($rowIndex * 70 / $maxRows);
                                                $plantsToShow = min($row['plants'], $maxCols);
                                            @endphp
                                            @for($plantIndex = 0; $plantIndex < $plantsToShow; $plantIndex++)
                                                @php
                                                    $baseX = 10 + ($plantIndex * 80 / $maxCols);
                                                    $x = $row['offset'] ? $baseX + (40 / $maxCols) : $baseX;
                                                    $color = $row['offset'] ? '#3b82f6' : '#10b981';
                                                @endphp
                                                <circle cx="{{ $x }}" cy="{{ $y }}" r="2" fill="{{ $color }}" class="plant-dot" />
                                            @endfor
                                        @endforeach
                                    @else
                                        <!-- Default visualization if no row details -->
                                        <circle cx="20" cy="20" r="3" fill="green" />
                                        <circle cx="50" cy="20" r="3" fill="green" />
                                        <circle cx="80" cy="20" r="3" fill="green" />
                                        <circle cx="35" cy="40" r="3" fill="blue" />
                                        <circle cx="65" cy="40" r="3" fill="blue" />
                                        <circle cx="20" cy="60" r="3" fill="green" />
                                        <circle cx="50" cy="60" r="3" fill="green" />
                                        <circle cx="80" cy="60" r="3" fill="green" />
                                        <circle cx="35" cy="80" r="3" fill="blue" />
                                        <circle cx="65" cy="80" r="3" fill="blue" />
                                    @endif
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-4 text-xs">
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                <span>Regular Row</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                <span>Offset Row</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </main>
    </div>

    <script>
        function resetForm() {
            document.querySelector('form').reset();
        }
        
        function setExample(type) {
            const examples = {
                orchard: { length: 10, width: 8, spacing: 3, unit: 'm' },
                garden: { length: 5, width: 3, spacing: 0.5, unit: 'm' },
                vineyard: { length: 20, width: 15, spacing: 2.5, unit: 'm' }
            };
            
            const example = examples[type];
            if (example) {
                document.getElementById('areaLength').value = example.length;
                document.getElementById('areaWidth').value = example.width;
                document.getElementById('plantSpacing').value = example.spacing;
                document.getElementById('borderSpacing').value = 0;
                
                // Set all units to the example unit
                document.querySelectorAll('select').forEach(select => {
                    select.value = example.unit;
                });
            }
        }
    </script>
</body>
</html>hp