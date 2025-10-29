@php
    // Comprehensive farming reference data
    $soilTestingGuide = [
        'pH Levels' => [
            'Acidic (pH 6.0 and below)' => 'Good for blueberries, azaleas, rhododendrons',
            'Neutral (pH 6.1-7.0)' => 'Ideal for most vegetables and flowers',
            'Alkaline (pH 7.1 and above)' => 'Good for lavender, clematis, asparagus'
        ],
        'Nutrient Testing' => [
            'Nitrogen (N)' => 'Essential for leaf growth and green color',
            'Phosphorus (P)' => 'Important for root development and flowering',
            'Potassium (K)' => 'Helps with disease resistance and fruit quality'
        ],
        'Testing Schedule' => [
            'Initial Test' => 'Before planting new areas',
            'Annual Test' => 'Every spring for active garden areas',
            'Problem Areas' => 'Test immediately if plants show nutrient deficiency'
        ]
    ];

    $companionPlantGuide = [
        'Beneficial Combinations' => [
            'Tomatoes + Basil' => 'Basil repels pests and improves tomato flavor',
            'Carrots + Chives' => 'Chives deter carrot flies',
            'Corn + Beans + Squash' => 'Traditional "Three Sisters" - beans fix nitrogen, corn provides support, squash suppresses weeds',
            'Marigolds + Vegetables' => 'Marigolds repel many garden pests',
            'Lettuce + Tall Plants' => 'Tall plants provide shade for cool-season crops'
        ],
        'Plants to Separate' => [
            'Tomatoes + Brassicas' => 'Compete for nutrients',
            'Onions + Beans' => 'Onions can inhibit bean growth',
            'Carrots + Dill' => 'Mature dill can reduce carrot yields'
        ]
    ];

    $pestManagementStrategies = [
        'Prevention' => [
            'Crop Rotation' => 'Rotate plant families to break pest cycles',
            'Beneficial Insects' => 'Attract ladybugs, lacewings, and parasitic wasps',
            'Physical Barriers' => 'Row covers, copper tape for slugs, mesh for birds',
            'Healthy Soil' => 'Strong plants resist pests better'
        ],
        'Organic Controls' => [
            'Neem Oil' => 'Effective against aphids, whiteflies, spider mites',
            'Diatomaceous Earth' => 'Controls crawling insects like slugs and beetles',
            'Bt (Bacillus thuringiensis)' => 'Targets caterpillars and larvae',
            'Insecticidal Soap' => 'Safe for soft-bodied insects'
        ]
    ];

    $fertilizerSchedule = [
        'Spring (March-May)' => [
            'Early Spring' => 'Apply compost and balanced organic fertilizer',
            'Pre-Planting' => 'Work in aged manure or compost',
            'Planting Time' => 'Use starter fertilizer for transplants'
        ],
        'Summer (June-August)' => [
            'Early Summer' => 'Side-dress heavy feeders (tomatoes, corn, squash)',
            'Mid-Summer' => 'Apply liquid fertilizer to container plants',
            'Late Summer' => 'Reduce nitrogen for fruit ripening'
        ],
        'Fall (September-November)' => [
            'Early Fall' => 'Fertilize cool-season crops',
            'Late Fall' => 'Apply bone meal to perennials',
            'Winter Prep' => 'Add compost as soil amendment'
        ]
    ];

    $irrigationBestPractices = [
        'Watering Schedule' => [
            'Morning Watering' => 'Best time - reduces evaporation and disease',
            'Deep, Infrequent' => 'Encourages deep root growth',
            'Soil Check' => 'Water when top 1-2 inches of soil are dry'
        ],
        'Water Conservation' => [
            'Mulching' => 'Reduces evaporation by up to 70%',
            'Drip Irrigation' => 'Delivers water directly to roots',
            'Rain Collection' => 'Harvest rainwater for irrigation',
            'Drought-Resistant Plants' => 'Choose native and adapted varieties'
        ],
        'Seasonal Adjustments' => [
            'Spring' => 'Increase watering as plants start growing',
            'Summer' => 'Daily watering may be needed for containers',
            'Fall' => 'Reduce watering as growth slows',
            'Winter' => 'Water only when soil is dry and not frozen'
        ]
    ];
@endphp

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-leaf text-success me-2"></i>Comprehensive Farming Resources
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Resource Navigation Tabs -->
                    <ul class="nav nav-tabs mb-4" id="resourceTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="soil-tab" data-bs-toggle="tab" data-bs-target="#soil-resources" type="button" role="tab">
                                <i class="fas fa-mountain me-1"></i>Soil Testing
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="companion-tab" data-bs-toggle="tab" data-bs-target="#companion-resources" type="button" role="tab">
                                <i class="fas fa-seedling me-1"></i>Companion Planting
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pest-tab" data-bs-toggle="tab" data-bs-target="#pest-resources" type="button" role="tab">
                                <i class="fas fa-bug me-1"></i>Pest Management
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="fertilizer-tab" data-bs-toggle="tab" data-bs-target="#fertilizer-resources" type="button" role="tab">
                                <i class="fas fa-leaf me-1"></i>Fertilizer Guide
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="irrigation-tab" data-bs-toggle="tab" data-bs-target="#irrigation-resources" type="button" role="tab">
                                <i class="fas fa-tint me-1"></i>Irrigation Tips
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="resourceTabContent">
                        <!-- Soil Testing Resources -->
                        <div class="tab-pane fade show active" id="soil-resources" role="tabpanel">
                            <div class="row">
                                @foreach($soilTestingGuide as $category => $items)
                                    <div class="col-md-4 mb-4">
                                        <div class="card border-success">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0">{{ $category }}</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($items as $key => $value)
                                                    <div class="mb-2">
                                                        <strong class="text-success">{{ $key }}:</strong>
                                                        <small class="d-block text-muted">{{ $value }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Companion Planting Resources -->
                        <div class="tab-pane fade" id="companion-resources" role="tabpanel">
                            <div class="row">
                                @foreach($companionPlantGuide as $category => $items)
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-{{ $category === 'Beneficial Combinations' ? 'success' : 'warning' }}">
                                            <div class="card-header bg-{{ $category === 'Beneficial Combinations' ? 'success' : 'warning' }} text-white">
                                                <h6 class="mb-0">{{ $category }}</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($items as $key => $value)
                                                    <div class="mb-2">
                                                        <strong class="text-{{ $category === 'Beneficial Combinations' ? 'success' : 'warning' }}">{{ $key }}:</strong>
                                                        <small class="d-block text-muted">{{ $value }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pest Management Resources -->
                        <div class="tab-pane fade" id="pest-resources" role="tabpanel">
                            <div class="row">
                                @foreach($pestManagementStrategies as $category => $items)
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-info">
                                            <div class="card-header bg-info text-white">
                                                <h6 class="mb-0">{{ $category }}</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($items as $key => $value)
                                                    <div class="mb-2">
                                                        <strong class="text-info">{{ $key }}:</strong>
                                                        <small class="d-block text-muted">{{ $value }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Fertilizer Guide Resources -->
                        <div class="tab-pane fade" id="fertilizer-resources" role="tabpanel">
                            <div class="row">
                                @foreach($fertilizerSchedule as $season => $items)
                                    <div class="col-md-4 mb-4">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">{{ $season }}</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($items as $key => $value)
                                                    <div class="mb-2">
                                                        <strong class="text-primary">{{ $key }}:</strong>
                                                        <small class="d-block text-muted">{{ $value }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Irrigation Resources -->
                        <div class="tab-pane fade" id="irrigation-resources" role="tabpanel">
                            <div class="row">
                                @foreach($irrigationBestPractices as $category => $items)
                                    <div class="col-md-4 mb-4">
                                        <div class="card border-cyan">
                                            <div class="card-header bg-info text-white">
                                                <h6 class="mb-0">{{ $category }}</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($items as $key => $value)
                                                    <div class="mb-2">
                                                        <strong class="text-info">{{ $key }}:</strong>
                                                        <small class="d-block text-muted">{{ $value }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Quick Reference Tools -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-light">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-tools me-2"></i>Quick Reference Tools</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <div class="d-grid">
                                                <button class="btn btn-outline-success btn-sm" onclick="showPlantingCalendar()">
                                                    <i class="fas fa-calendar-alt me-2"></i>Planting Calendar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planting Calendar Modal -->
<div class="modal fade" id="plantingCalendarModal" tabindex="-1" aria-labelledby="plantingCalendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="plantingCalendarModalLabel">
                    <i class="fas fa-calendar-alt me-2"></i>Planting Calendar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Location Detection -->
                <div class="card border-primary mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Your Location</h6>
                                <p class="mb-2 text-muted" id="detectedLocation">Detecting location...</p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    We'll use your location to provide personalized planting dates
                                </small>
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <button class="btn btn-primary w-100" onclick="detectLocation()">
                                    <i class="fas fa-crosshairs me-2"></i>Detect Location
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading State -->
                <div id="calendarLoading" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Fetching personalized planting calendar...</p>
                </div>

                <!-- Calendar Information -->
                <div id="calendarInfo" style="display: none;">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="card text-center border-success">
                                <div class="card-body">
                                    <i class="fas fa-globe fa-2x text-success mb-2"></i>
                                    <h6 class="small mb-1">Climate Zone</h6>
                                    <strong id="climateZoneDisplay">-</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center border-info">
                                <div class="card-body">
                                    <i class="fas fa-thermometer-half fa-2x text-info mb-2"></i>
                                    <h6 class="small mb-1">Hardiness Zone</h6>
                                    <strong id="hardinessZoneDisplay">-</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center border-warning">
                                <div class="card-body">
                                    <i class="fas fa-snowflake fa-2x text-warning mb-2"></i>
                                    <h6 class="small mb-1">Last Frost</h6>
                                    <strong id="lastFrostDisplay">-</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center border-primary">
                                <div class="card-body">
                                    <i class="fas fa-calendar fa-2x text-primary mb-2"></i>
                                    <h6 class="small mb-1">Growing Days</h6>
                                    <strong id="growingDaysDisplay">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Planting Calendar Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>Plant</th>
                                    <th>Start Seeds Indoors</th>
                                    <th>Direct Sow/Transplant</th>
                                    <th>Harvest Time</th>
                                    <th>Difficulty</th>
                                </tr>
                            </thead>
                            <tbody id="plantingCalendarBody">
                                <!-- Will be populated dynamically from API -->
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-success mt-3">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Personalized for Your Location!</strong> These planting dates are calculated based on your exact location and climate zone.
                    </div>
                </div>

                <!-- Error State -->
                <div id="calendarError" class="alert alert-warning" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="errorMessage">Unable to detect location. Please enable location services or try again.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let userCoordinates = null;

function showPlantingCalendar() {
    const modal = new bootstrap.Modal(document.getElementById('plantingCalendarModal'));
    modal.show();
    
    // Auto-detect location when modal opens
    detectLocation();
}

function detectLocation() {
    document.getElementById('calendarLoading').style.display = 'block';
    document.getElementById('calendarInfo').style.display = 'none';
    document.getElementById('calendarError').style.display = 'none';
    document.getElementById('detectedLocation').textContent = 'Detecting location...';
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                userCoordinates = {
                    lat: position.coords.latitude,
                    lon: position.coords.longitude
                };
                fetchPlantingCalendar(userCoordinates.lat, userCoordinates.lon);
            },
            function(error) {
                console.error('Geolocation error:', error);
                document.getElementById('calendarLoading').style.display = 'none';
                document.getElementById('calendarError').style.display = 'block';
                document.getElementById('detectedLocation').textContent = 'Location detection failed';
                
                // Fallback to demo data or ask for manual location
                if (error.code === error.PERMISSION_DENIED) {
                    document.getElementById('errorMessage').textContent = 
                        'Location access denied. Please enable location services or enter your location manually.';
                }
            }
        );
    } else {
        document.getElementById('calendarLoading').style.display = 'none';
        document.getElementById('calendarError').style.display = 'block';
        document.getElementById('errorMessage').textContent = 
            'Geolocation is not supported by your browser. Please enter your location manually.';
    }
}

async function fetchPlantingCalendar(lat, lon) {
    try {
        const response = await fetch(`/planting-calendar/location?lat=${lat}&lon=${lon}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch planting calendar');
        }
        
        const data = await response.json();
        
        if (data.success) {
            displayPlantingCalendar(data);
        } else {
            throw new Error(data.message || 'Failed to load calendar');
        }
        
    } catch (error) {
        console.error('Fetch error:', error);
        document.getElementById('calendarLoading').style.display = 'none';
        document.getElementById('calendarError').style.display = 'block';
        document.getElementById('errorMessage').textContent = 
            'Error loading planting calendar. Please try again.';
    }
}

function displayPlantingCalendar(data) {
    // Hide loading, show content
    document.getElementById('calendarLoading').style.display = 'none';
    document.getElementById('calendarInfo').style.display = 'block';
    document.getElementById('calendarError').style.display = 'none';
    
    // Update location display
    document.getElementById('detectedLocation').innerHTML = `
        <i class="fas fa-check-circle text-success me-1"></i>
        <strong>${data.location}</strong>
    `;
    
    // Update zone information
    document.getElementById('climateZoneDisplay').textContent = 
        data.climate_zone.charAt(0).toUpperCase() + data.climate_zone.slice(1);
    document.getElementById('hardinessZoneDisplay').textContent = 
        data.hardiness_zone || 'N/A';
    
    // Update frost date
    if (data.frost_dates && data.frost_dates.has_frost) {
        const frostDate = new Date(data.frost_dates.last_frost_spring);
        document.getElementById('lastFrostDisplay').textContent = 
            frostDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    } else {
        document.getElementById('lastFrostDisplay').textContent = 'No Frost';
    }
    
    // Update growing season length
    document.getElementById('growingDaysDisplay').textContent = 
        data.growing_season_length + ' days';
    
    // Populate planting schedule table
    const tbody = document.getElementById('plantingCalendarBody');
    tbody.innerHTML = '';
    
    data.planting_schedule.forEach(crop => {
        const difficultyColor = {
            'Easy': 'success',
            'Medium': 'warning',
            'Hard': 'danger'
        }[crop.difficulty] || 'secondary';
        
        // Format dates if available
        let indoorText = crop.indoor;
        if (crop.exact_indoor_date) {
            const date = new Date(crop.exact_indoor_date);
            indoorText += ` <br><small class="text-primary">(${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })})</small>`;
        }
        
        let outdoorText = crop.outdoor;
        if (crop.exact_outdoor_date) {
            const date = new Date(crop.exact_outdoor_date);
            outdoorText += ` <br><small class="text-primary">(${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })})</small>`;
        }
        
        const row = `
            <tr>
                <td><strong>${crop.plant}</strong></td>
                <td>${indoorText}</td>
                <td>${outdoorText}</td>
                <td>${crop.harvest}</td>
                <td><span class="badge bg-${difficultyColor}">${crop.difficulty}</span></td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}
</script>