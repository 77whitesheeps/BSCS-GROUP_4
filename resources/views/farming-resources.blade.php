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

                </div>
            </div>
        </div>
    </div>
</div>