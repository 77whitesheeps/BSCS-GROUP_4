@extends('layouts.app')

@section('title', 'Garden Planner')
@section('page-title', 'Garden Planner')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Garden Planner</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map text-success me-2"></i>Comprehensive Garden Planner
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">Plan, calculate, and manage your garden from planting to harvest. Integrate calculations, track progress, and optimize your farming operations.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calculator text-primary me-2"></i>Calculator Integration
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('planting.calculator') }}" class="btn btn-outline-success btn-sm w-100">
                                <i class="fas fa-calculator me-2"></i>Square Planting Calculator
                            </a>
                        </div>
                        <div class="col-md-4 mb-2">
                           <a href="{{ route('quincunx.calculator') }}" class="btn btn-outline-info btn-sm w-100">
                                <i class="fas fa-th me-2"></i>Quincunx Calculator
                            </a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('triangular.calculator') }}" class="btn btn-outline-warning btn-sm w-100">
                                <i class="fas fa-play me-2"></i>Triangular Calculator
                            </a>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Tip:</strong> Use the calculators above to determine planting densities, then import those calculations into your garden plan below.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Enhanced Plan Form -->
        <div class="col-lg-8 mb-4">
            <div class="card card-dashboard">
                <div class="card-header">
                    <h5 class="card-title mb-0" id="planFormTitle">
                        <i class="fas fa-plus-circle text-primary me-2"></i>Create Comprehensive Garden Plan
                    </h5>
                </div>
                <div class="card-body">
                    <form id="gardenPlanForm">
                        @csrf
                        <!-- Hidden fields for edit mode -->
                        <input type="hidden" id="editMode" name="edit_mode" value="false">
                        <input type="hidden" id="planId" name="plan_id" value="">

                        <!-- Streamlined Single Form Following Best Practices -->
                        
                        <!-- Section 1: Garden Identity & Location -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>1. Garden Identity & Location
                            </h6>
                            <div class="ps-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="planName" class="form-label">Garden Plan Name *</label>
                                        <input type="text" class="form-control" id="planName" name="name" required placeholder="e.g., Backyard Vegetable Garden 2025">
                                        <small class="text-muted">Give your garden a descriptive name</small>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="growingSeason" class="form-label">Primary Season *</label>
                                        <select class="form-control" id="growingSeason" name="growing_season" required>
                                            <option value="">Select Season</option>
                                            <option value="spring">🌸 Spring</option>
                                            <option value="summer">☀️ Summer</option>
                                            <option value="fall">🍂 Fall</option>
                                            <option value="winter">❄️ Winter</option>
                                            <option value="year-round">🌍 Year-round</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="gardenType" class="form-label">Garden Type *</label>
                                        <select class="form-control" id="gardenType" name="garden_type" required>
                                            <option value="">Select Type</option>
                                            <option value="vegetable">Vegetable</option>
                                            <option value="fruit">Fruit</option>
                                            <option value="herb">Herb</option>
                                            <option value="flower">Flower</option>
                                            <option value="mixed">Mixed</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-8 mb-3">
                                        <label for="gardenLocation" class="form-label">Location/Plot Name</label>
                                        <input type="text" class="form-control" id="gardenLocation" name="location" placeholder="e.g., Backyard Plot A, North Garden Bed">
                                        <small class="text-muted">Where is this garden physically located?</small>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sunExposure" class="form-label">Sun Exposure *</label>
                                        <select class="form-control" id="sunExposure" name="sun_exposure" required>
                                            <option value="">Select</option>
                                            <option value="full-sun">☀️ Full Sun (6+ hrs)</option>
                                            <option value="partial-sun">⛅ Partial Sun (4-6 hrs)</option>
                                            <option value="partial-shade">🌤️ Partial Shade (2-4 hrs)</option>
                                            <option value="full-shade">🌑 Full Shade (<2 hrs)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="planDescription" class="form-label">Garden Goals & Description</label>
                                    <textarea class="form-control" id="planDescription" name="description" rows="2" placeholder="What do you want to achieve? (e.g., Fresh vegetables for family, Cut flowers, Maximize yield)"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Garden Dimensions & Bed Layout -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-ruler-combined me-2"></i>2. Garden Dimensions & Bed Layout
                            </h6>
                            <div class="ps-3">
                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    <strong>Best Practice:</strong> Measure your garden space accurately. Standard bed width is 1-1.2m for easy reach from both sides, or 0.6m for single-sided access.
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="totalAreaLength" class="form-label">Total Garden Length (m) *</label>
                                        <input type="number" class="form-control" id="totalAreaLength" name="total_area_length" step="0.1" min="0.1" placeholder="10.0" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="totalAreaWidth" class="form-label">Total Garden Width (m) *</label>
                                        <input type="number" class="form-control" id="totalAreaWidth" name="total_area_width" step="0.1" min="0.1" placeholder="5.0" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Total Area</label>
                                        <input type="text" class="form-control bg-light" id="totalGardenArea" readonly placeholder="0 m²">
                                        <input type="hidden" id="totalArea" name="total_area">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="bedLayout" class="form-label">Bed Layout *</label>
                                        <select class="form-control" id="bedLayout" name="bed_layout" required>
                                            <option value="">Select Layout</option>
                                            <option value="single-bed">Single Bed</option>
                                            <option value="raised-beds">Multiple Raised Beds</option>
                                            <option value="row-garden">Traditional Rows</option>
                                            <option value="square-foot">Square Foot Garden</option>
                                            <option value="container">Container Garden</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="numberOfBeds" class="form-label">Number of Beds/Rows</label>
                                        <input type="number" class="form-control" id="numberOfBeds" name="number_of_beds" min="1" value="1" placeholder="1">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="pathWidth" class="form-label">Path Width (m)</label>
                                        <input type="number" class="form-control" id="pathWidth" name="path_width" step="0.1" min="0" value="0.4" placeholder="0.4">
                                        <small class="text-muted">Min 0.4m recommended</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Planting Area Calculator</label>
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row text-center">
                                                    <div class="col-md-4">
                                                        <strong class="text-success" id="usablePlantingArea">0 m²</strong>
                                                        <div><small class="text-muted">Usable Planting Area</small></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong class="text-warning" id="pathArea">0 m²</strong>
                                                        <div><small class="text-muted">Path Area</small></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong class="text-info" id="spaceEfficiency">0%</strong>
                                                        <div><small class="text-muted">Space Efficiency</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Choose Calculator & Add Plants -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-calculator me-2"></i>3. Choose Calculator & Add Plants
                            </h6>
                            <div class="ps-3">
                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>How it works:</strong> Choose a calculator below based on your planting pattern, calculate your plants, then add them to your garden plan.
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="calcPlantType" class="form-label">Plant/Crop Name *</label>
                                        <select class="form-control" id="calcPlantType">
                                            <option value="">Select or type plant name</option>
                                            <optgroup label="Vegetables">
                                                <option value="Tomato" data-spacing="0.5" data-row="0.6">🍅 Tomato (50-60cm spacing)</option>
                                                <option value="Lettuce" data-spacing="0.2" data-row="0.3">🥬 Lettuce (20-30cm spacing)</option>
                                                <option value="Cabbage" data-spacing="0.4" data-row="0.5">🥬 Cabbage (40-50cm spacing)</option>
                                                <option value="Carrot" data-spacing="0.05" data-row="0.3">🥕 Carrot (5-30cm rows)</option>
                                                <option value="Pepper" data-spacing="0.4" data-row="0.5">�️ Pepper (40-50cm spacing)</option>
                                                <option value="Cucumber" data-spacing="0.4" data-row="1.0">🥒 Cucumber (40cm-1m spacing)</option>
                                            </optgroup>
                                            <optgroup label="Fruits">
                                                <option value="Strawberry" data-spacing="0.3" data-row="0.4">� Strawberry (30-40cm spacing)</option>
                                                <option value="Melon" data-spacing="1.0" data-row="1.5">🍈 Melon (1-1.5m spacing)</option>
                                            </optgroup>
                                            <optgroup label="Herbs">
                                                <option value="Basil" data-spacing="0.25" data-row="0.3">� Basil (25-30cm spacing)</option>
                                                <option value="Parsley" data-spacing="0.15" data-row="0.25">� Parsley (15-25cm spacing)</option>
                                                <option value="Mint" data-spacing="0.3" data-row="0.4">🌿 Mint (30-40cm spacing)</option>
                                            </optgroup>
                                            <option value="custom" data-spacing="0.3" data-row="0.3">🔧 Custom Plant</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="calcPattern" class="form-label">Planting Pattern</label>
                                        <select class="form-control" id="calcPattern">
                                            <option value="square">Grid (Square)</option>
                                            <option value="quincunx">Offset (Quincunx)</option>
                                            <option value="triangular">Hex (Triangular)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="plantVariety" class="form-label">Variety (Optional)</label>
                                        <input type="text" class="form-control" id="plantVariety" placeholder="e.g., Cherry, Beefsteak">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 mb-2">
                                        <label for="calcAreaLength" class="form-label">Bed Length (m) *</label>
                                        <input type="number" class="form-control" id="calcAreaLength" step="0.1" min="0.1" placeholder="3.0">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="calcAreaWidth" class="form-label">Bed Width (m) *</label>
                                        <input type="number" class="form-control" id="calcAreaWidth" step="0.1" min="0.1" placeholder="1.2">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="calcPlantSpacing" class="form-label">Plant Spacing (m) *</label>
                                        <input type="number" class="form-control" id="calcPlantSpacing" step="0.01" min="0.01" value="0.3">
                                        <small class="text-muted">Within row</small>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="calcRowSpacing" class="form-label">Row Spacing (m) *</label>
                                        <input type="number" class="form-control" id="calcRowSpacing" step="0.01" min="0.01" value="0.4">
                                        <small class="text-muted">Between rows</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="btn btn-success" id="calculateBtn">
                                            <i class="fas fa-calculator me-2"></i>Calculate Plant Count
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary ms-2" id="useAdvancedCalc">
                                            <i class="fas fa-external-link-alt me-2"></i>Use Advanced Calculator
                                        </button>
                                    </div>
                                </div>

                                <!-- Calculation Results -->
                                <div id="calcResults" class="card border-success d-none mb-3">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0"><i class="fas fa-check-circle me-2"></i>Planting Calculation Results</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-3">
                                                <div class="border rounded p-2 bg-light">
                                                    <h4 class="mb-0 text-success" id="resultTotalPlants">0</h4>
                                                    <small class="text-muted">Total Plants</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="border rounded p-2 bg-light">
                                                    <h5 class="mb-0 text-success" id="resultPlantsPerRow">0</h5>
                                                    <small class="text-muted">Per Row</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="border rounded p-2 bg-light">
                                                    <h5 class="mb-0 text-success" id="resultRows">0</h5>
                                                    <small class="text-muted">Rows</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="border rounded p-2 bg-light">
                                                    <h5 class="mb-0 text-success" id="resultDensity">0</h5>
                                                    <small class="text-muted">plants/m²</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-center">
                                            <button type="button" class="btn btn-primary" id="addToList">
                                                <i class="fas fa-plus-circle me-2"></i>Add to Garden Plan
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Saved Plant List -->
                                <div id="savedCalculations" class="mt-3">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-list me-2"></i>Plants in This Garden (<span id="plantCount">0</span> types)
                                    </h6>
                                    <!-- Saved calculations will appear here -->
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Planting Timeline & Schedule -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>4. Planting Timeline & Schedule
                            </h6>
                            <div class="ps-3">
                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    <strong>Pro Tip:</strong> Plan by working backwards from your desired harvest date. Consider your climate zone's first/last frost dates for optimal timing.
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="startDate" class="form-label">Start Date *</label>
                                        <input type="date" class="form-control" id="startDate" name="start_date" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="firstPlantingDate" class="form-label">First Planting Date</label>
                                        <input type="date" class="form-control" id="firstPlantingDate" name="first_planting_date">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="expectedHarvestDate" class="form-label">Expected First Harvest</label>
                                        <input type="date" class="form-control" id="expectedHarvestDate" name="expected_harvest_date">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="plantingSchedule" class="form-label">Planting Schedule</label>
                                        <textarea class="form-control" id="plantingSchedule" rows="4" placeholder="Week 1: Prepare beds, add compost&#10;Week 2: Direct sow lettuce, radish&#10;Week 4: Transplant tomato seedlings&#10;Week 6: Plant beans, cucumbers"></textarea>
                                        <small class="text-muted">List key planting activities by week/month</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="harvestSchedule" class="form-label">Expected Harvest Schedule</label>
                                        <textarea class="form-control" id="harvestSchedule" rows="4" placeholder="Week 6: Lettuce, radishes&#10;Week 10: Peas, spinach&#10;Week 14: Tomatoes begin&#10;Week 16: Peak harvest season"></textarea>
                                        <small class="text-muted">When do you expect to harvest each crop?</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="expectedYield" class="form-label">Expected Total Yield (kg)</label>
                                        <input type="number" class="form-control" id="expectedYield" name="expected_yield" step="0.1" min="0" placeholder="50.0">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="harvestDuration" class="form-label">Harvest Duration (weeks)</label>
                                        <input type="number" class="form-control" id="harvestDuration" name="harvest_duration" min="1" placeholder="8">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="successionPlanting" class="form-label">Succession Planting</label>
                                        <select class="form-control" id="successionPlanting" name="succession_planting">
                                            <option value="none">No succession</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="biweekly">Every 2 weeks</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Soil & Growing Conditions -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-mountain me-2"></i>5. Soil & Growing Conditions
                            </h6>
                            <div class="ps-3">
                                <div class="row mb-3">
                                    <div class="col-md-3 mb-3">
                                        <label for="soilType" class="form-label">Soil Type *</label>
                                        <select class="form-control" id="soilType" name="soil_type" required>
                                            <option value="">Select Type</option>
                                            <option value="clay">Clay</option>
                                            <option value="sandy">Sandy</option>
                                            <option value="loam">Loam (Ideal)</option>
                                            <option value="silt">Silt</option>
                                            <option value="mixed">Mixed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="soilPH" class="form-label">Soil pH Level</label>
                                        <input type="number" class="form-control" id="soilPH" name="soil_ph" step="0.1" min="0" max="14" placeholder="6.5">
                                        <small class="text-muted">6.0-7.0 ideal for most crops</small>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="soilQuality" class="form-label">Soil Quality</label>
                                        <select class="form-control" id="soilQuality" name="soil_quality">
                                            <option value="excellent">Excellent</option>
                                            <option value="good">Good</option>
                                            <option value="fair">Fair</option>
                                            <option value="poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="drainageQuality" class="form-label">Drainage</label>
                                        <select class="form-control" id="drainageQuality" name="drainage">
                                            <option value="excellent">Excellent</option>
                                            <option value="good">Good</option>
                                            <option value="poor">Poor/Waterlogged</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="soilAmendments" class="form-label">Soil Amendments & Preparation</label>
                                        <textarea class="form-control" id="soilAmendments" name="soil_amendments" rows="3" placeholder="Compost: 5 bags (50L each)&#10;Aged manure: 2 bags&#10;Perlite for drainage: 1 bag&#10;Blood meal for nitrogen"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="soilRequirements" class="form-label">Special Soil Requirements</label>
                                        <textarea class="form-control" id="soilRequirements" rows="3" placeholder="Tomatoes need calcium (add bone meal)&#10;Blueberries need acidic soil (pH 4.5-5.5)&#10;Root crops need deep, loose soil"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 6: Watering & Irrigation Plan -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-tint me-2"></i>6. Watering & Irrigation Plan
                            </h6>
                            <div class="ps-3">
                                <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="irrigationMethod" class="form-label">Irrigation Method *</label>
                                        <select class="form-control" id="irrigationMethod" name="irrigation_method" required>
                                            <option value="">Select Method</option>
                                            <option value="hand-water">Hand Watering</option>
                                            <option value="drip">Drip Irrigation</option>
                                            <option value="soaker-hose">Soaker Hose</option>
                                            <option value="sprinkler">Sprinkler System</option>
                                            <option value="mixed">Mixed Methods</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="wateringFrequency" class="form-label">Watering Frequency</label>
                                        <select class="form-control" id="wateringFrequency" name="watering_frequency">
                                            <option value="daily">Daily</option>
                                            <option value="every-other-day">Every other day</option>
                                            <option value="twice-weekly">2x per week</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="as-needed">As needed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="estimatedWaterUsage" class="form-label">Water Usage (L/week)</label>
                                        <input type="number" class="form-control" id="estimatedWaterUsage" name="estimated_water_usage" step="1" min="0" placeholder="150">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="irrigationPlan" class="form-label">Detailed Watering Schedule</label>
                                    <textarea class="form-control" id="irrigationPlan" rows="3" placeholder="Morning: Water 30 min (6-8 AM)&#10;Check soil moisture daily&#10;Deep water 2x/week in hot weather&#10;Reduce watering 2 weeks before harvest"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 7: Fertilizer & Nutrient Management -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-leaf me-2"></i>7. Fertilizer & Nutrient Management
                            </h6>
                            <div class="ps-3">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="fertilizerType" class="form-label">Primary Fertilizer Type</label>
                                        <select class="form-control" id="fertilizerType" name="fertilizer_type">
                                            <option value="organic">Organic (Compost, Manure)</option>
                                            <option value="synthetic">Synthetic (NPK)</option>
                                            <option value="mixed">Mixed Approach</option>
                                            <option value="none">No fertilizer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="npkRatio" class="form-label">NPK Ratio</label>
                                        <input type="text" class="form-control" id="npkRatio" name="npk_ratio" placeholder="e.g., 10-10-10, 5-10-5">
                                        <small class="text-muted">Nitrogen-Phosphorus-Potassium</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="fertilizerSchedule" class="form-label">Fertilizer Application Schedule</label>
                                    <textarea class="form-control" id="fertilizerSchedule" rows="3" placeholder="Week 0: Pre-plant compost (5kg/m²)&#10;Week 2: Side-dress nitrogen&#10;Week 6: Balanced fertilizer&#10;Week 10: High phosphorus for fruiting"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 8: Resources & Budget -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-dollar-sign me-2"></i>8. Resources & Budget
                            </h6>
                            <div class="ps-3">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="estimatedCost" class="form-label">Total Estimated Cost ($)</label>
                                        <input type="number" class="form-control" id="estimatedCost" name="estimated_cost" step="0.01" min="0" placeholder="250.00">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="laborHours" class="form-label">Estimated Labor (hours/week)</label>
                                        <input type="number" class="form-control" id="laborHours" name="labor_hours" step="0.5" min="0" placeholder="5.0">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="toolRequirements" class="form-label">Required Tools & Materials</label>
                                    <textarea class="form-control" id="toolRequirements" rows="3" placeholder="Seeds: Tomato (3 pkts), Lettuce (2 pkts) - $25&#10;Compost: 10 bags @ $5 each - $50&#10;Drip irrigation kit - $75&#10;Garden stakes, twine - $20&#10;Mulch: 5 bags - $30"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 9: Tasks & Progress Tracking -->
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-tasks me-2"></i>9. Tasks & Progress Tracking
                            </h6>
                            <div class="ps-3">
                                <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="planStatus" class="form-label">Current Status *</label>
                                        <select class="form-control" id="planStatus" name="status" required>
                                            <option value="planning">📝 Planning Phase</option>
                                            <option value="preparing">🔨 Preparing Beds</option>
                                            <option value="planting">🌱 Planting</option>
                                            <option value="growing">🌿 Growing</option>
                                            <option value="maintaining">🚿 Maintaining</option>
                                            <option value="harvesting">🌾 Harvesting</option>
                                            <option value="completed">✅ Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Overall Progress</label>
                                        <div class="progress" style="height: 38px;">
                                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" id="progressBar" style="width: 0%">
                                                <span class="fw-bold">0%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tasks Completed</label>
                                        <div class="text-center border rounded p-2 bg-light">
                                            <h4 class="mb-0" id="taskProgress">0 / 0</h4>
                                            <small class="text-muted">tasks done</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Garden Task Checklist</label>
                                    <button type="button" class="btn btn-success btn-sm mb-2" id="addTaskBtn">
                                        <i class="fas fa-plus me-2"></i>Add Custom Task
                                    </button>
                                    <div class="alert alert-light">
                                        <small><i class="fas fa-info-circle me-1"></i> Add tasks like: "Prepare soil", "Plant tomatoes", "Install irrigation", "First harvest"</small>
                                    </div>
                                    <div id="taskContainer" class="border rounded p-3 bg-white">
                                        <!-- Dynamic tasks will be added here -->
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="additionalNotes" class="form-label">Garden Journal & Observations</label>
                                    <textarea class="form-control" id="additionalNotes" name="notes" rows="4" placeholder="Date: Nov 4, 2025&#10;Weather: Sunny, 24°C&#10;&#10;Planted tomatoes in bed 1. Soil is moist and well-prepared.&#10;Added compost tea to seedlings.&#10;Note: Need to stake tomatoes next week."></textarea>
                                    <small class="text-muted">Keep a record of activities, weather, pest issues, and harvest notes</small>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields for complex data -->
                        <input type="hidden" id="layoutData" name="layout_data">
                        <input type="hidden" id="plantCalculationsData" name="plant_calculations">
                        <input type="hidden" id="seasonalScheduleData" name="seasonal_schedule">
                        <input type="hidden" id="irrigationPlanData" name="irrigation_plan">
                        <input type="hidden" id="soilRequirementsData" name="soil_requirements">
                        <input type="hidden" id="fertilizerScheduleData" name="fertilizer_schedule">
                        <input type="hidden" id="toolRequirementsData" name="tool_requirements">
                        <input type="hidden" id="taskChecklistData" name="task_checklist">

                        <!-- Action Buttons -->
                        <div class="text-end mt-4 pt-3 border-top">
                            <button type="button" id="cancelBtn" class="btn btn-danger me-2" style="display: none;">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="button" id="savePlanBtn" class="btn btn-plant">
                                <i class="fas fa-save me-2"></i>Save Garden Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Existing Plans -->
        <div class="col-lg-4 mb-4">
            <div class="card card-dashboard">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list text-info me-2"></i>Your Garden Plans
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($plans as $plan)
                        <div class="plan-item mb-3 p-3 border rounded position-relative">
                            <!-- Status Badge -->
                            <span class="badge bg-{{ $plan->status_color }} position-absolute top-0 end-0 m-2">
                                {{ ucfirst($plan->status) }}
                            </span>
                            
                            <h6 class="mb-1 pe-5">{{ $plan->name }}</h6>
                            <p class="text-muted small mb-2">{{ Str::limit($plan->description ?: 'No description', 80) }}</p>
                            
                            <!-- Plan Details -->
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-ruler-combined me-1"></i>
                                        @if($plan->total_area)
                                            {{ number_format($plan->total_area, 1) }} m²
                                        @else
                                            Area not set
                                        @endif
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $plan->growing_season ? ucfirst($plan->growing_season) : 'No season' }}
                                    </small>
                                </div>
                            </div>

                            <!-- Progress Bar (if has tasks) -->
                            @if($plan->task_checklist && count($plan->task_checklist) > 0)
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted">Progress</small>
                                        <small class="text-muted">{{ $plan->completion_percentage }}%</small>
                                    </div>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $plan->completion_percentage }}%"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Quick Stats -->
                            <div class="row g-2 mb-2">
                                @if($plan->hasCalculations())
                                    <div class="col-6">
                                        <small class="text-success d-block">
                                            <i class="fas fa-seedling me-1"></i>
                                            {{ $plan->total_estimated_plants }} plants
                                        </small>
                                    </div>
                                @endif
                                @if($plan->expected_yield)
                                    <div class="col-6">
                                        <small class="text-warning d-block">
                                            <i class="fas fa-apple-alt me-1"></i>
                                            {{ number_format($plan->expected_yield, 1) }} kg
                                        </small>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $plan->created_at->diffForHumans() }}</small>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick="loadPlan({{ $plan->id }})" title="Edit Plan">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info me-1" onclick="viewPlan({{ $plan->id }})" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deletePlan({{ $plan->id }})" title="Delete Plan">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-2">No garden plans yet</p>
                            <p class="small text-muted">Create your first comprehensive plan to get started!</p>
                            <button class="btn btn-success btn-sm" onclick="document.getElementById('planName').focus()">
                                <i class="fas fa-plus me-2"></i>Create First Plan
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Tips Card -->
            <div class="card card-dashboard mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb text-warning me-2"></i>Farming Tips
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-2">
                            <strong>Essential Considerations:</strong>
                        </div>
                        <ul class="small text-muted ps-3 mb-0">
                            <li>Soil testing every 2-3 years</li>
                            <li>Crop rotation to prevent disease</li>
                            <li>Companion planting for natural pest control</li>
                            <li>Water-efficient irrigation systems</li>
                            <li>Seasonal task scheduling</li>
                            <li>Record keeping for future planning</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comprehensive Farming Resources Section -->
@include('farming-resources')

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Success!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-seedling fa-4x text-success mb-3"></i>
                <h4 class="mb-3">Garden Plan Saved!</h4>
                <p class="text-muted mb-0">Your garden plan has been successfully saved and is ready for use.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Plan Details Modal -->
<div class="modal fade" id="planDetailsModal" tabindex="-1" aria-labelledby="planDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="planDetailsModalLabel">
                    <i class="fas fa-eye me-2"></i>Garden Plan Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="planDetailsContent">
                <!-- Plan details will be loaded here dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- delete modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="deleteConfirmModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-trash-alt fa-4x text-warning mb-3"></i>
                <h4 class="mb-3">Are you sure?</h4>
                <p class="text-muted mb-0">This action cannot be undone. The garden plan will be permanently deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete success modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash-alt me-2"></i>Plan Deleted
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-trash fa-4x text-danger mb-3"></i>
                <h4 class="mb-3">Garden Plan Deleted!</h4>
                <p class="text-muted mb-0">Your garden plan has been permanently deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.plan-item {
    transition: all 0.3s ease;
}

.plan-item:hover {
    background-color: #f8f9fa;
    border-color: var(--plant-green) !important;
}

.form-label {
    font-weight: 600;
    color: #495057;
}
</style>
@endpush

@push('scripts')
<script>
// Global variables for dynamic content
let calculationCounter = 0;
let taskCounter = 0;
let savedPlantCalculations = [];

$(document).ready(function() {
    // Initialize dynamic content
    initializeDynamicElements();
    
    // Garden dimension calculator
    $('#totalAreaLength, #totalAreaWidth, #numberOfBeds, #pathWidth').on('input', function() {
        calculateGardenDimensions();
    });

    $('#bedLayout').on('change', function() {
        calculateGardenDimensions();
    });

    // Plant type spacing suggestions
    $('#calcPlantType').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const spacing = selectedOption.data('spacing');
        const rowSpacing = selectedOption.data('row');
        
        if (spacing && rowSpacing) {
            $('#calcPlantSpacing').val(spacing);
            $('#calcRowSpacing').val(rowSpacing);
        }
    });

    // Auto-calculate bed area
    $('#calcAreaLength, #calcAreaWidth').on('input', function() {
        const length = parseFloat($('#calcAreaLength').val()) || 0;
        const width = parseFloat($('#calcAreaWidth').val()) || 0;
        const totalArea = (length * width).toFixed(2);
    });

    // Calculate button
    $('#calculateBtn').on('click', function() {
        calculatePlants();
    });

    // Add to list button
    $('#addToList').on('click', function() {
        addCalculationToList();
    });

    // Use advanced calculator button
    $('#useAdvancedCalc').on('click', function() {
        window.open('{{ route("planting.calculator") }}', '_blank');
    });
    
    // Save/Update plan
    $('#savePlanBtn').on('click', function() {
        savePlan();
    });

    // Cancel editing
    $('#cancelBtn').on('click', function() {
        resetForm();
    });

    // Add task entry
    $('#addTaskBtn').on('click', function() {
        addTaskEntry();
    });

    // Update progress when tasks change
    $(document).on('change', '.task-checkbox', function() {
        updateProgressBar();
    });

    // Modal handlers
    $('#successModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    $('#deleteModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    $('#confirmDeleteBtn').on('click', function() {
        const planId = $(this).data('plan-id');
        performDelete(planId);
    });

    // Tab navigation
    $('[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const targetTab = $(e.target).attr('data-bs-target');
        if (targetTab === '#tracking') {
            updateProgressBar();
        }
    });
});

// Garden Dimensions Calculator
function calculateGardenDimensions() {
    const length = parseFloat($('#totalAreaLength').val()) || 0;
    const width = parseFloat($('#totalAreaWidth').val()) || 0;
    const numberOfBeds = parseInt($('#numberOfBeds').val()) || 1;
    const pathWidth = parseFloat($('#pathWidth').val()) || 0;
    const bedLayout = $('#bedLayout').val();

    // Calculate total garden area
    const totalArea = length * width;
    $('#totalGardenArea').val(totalArea.toFixed(2) + ' m²');
    $('#totalArea').val(totalArea.toFixed(2));

    // Calculate path area based on layout
    let pathArea = 0;
    let plantingArea = 0;

    if (bedLayout === 'raised-beds' || bedLayout === 'row-garden') {
        // Assume paths between beds
        const numberOfPaths = Math.max(0, numberOfBeds - 1);
        pathArea = numberOfPaths * pathWidth * length;
        plantingArea = totalArea - pathArea;
    } else if (bedLayout === 'square-foot') {
        // Square foot gardens have minimal paths
        pathArea = totalArea * 0.15; // ~15% for paths
        plantingArea = totalArea * 0.85;
    } else {
        // Single bed or container - minimal paths
        pathArea = totalArea * 0.05;
        plantingArea = totalArea * 0.95;
    }

    // Calculate efficiency
    const efficiency = totalArea > 0 ? (plantingArea / totalArea * 100).toFixed(1) : 0;

    // Update displays
    $('#usablePlantingArea').text(plantingArea.toFixed(2) + ' m²');
    $('#pathArea').text(pathArea.toFixed(2) + ' m²');
    $('#spaceEfficiency').text(efficiency + '%');
}

// Plant Calculator Functions
function calculatePlants() {
    const plantType = $('#calcPlantType option:selected').text();
    const variety = $('#plantVariety').val();
    const pattern = $('#calcPattern').val();
    const length = parseFloat($('#calcAreaLength').val());
    const width = parseFloat($('#calcAreaWidth').val());
    const plantSpacing = parseFloat($('#calcPlantSpacing').val());
    const rowSpacing = parseFloat($('#calcRowSpacing').val());

    // Validation
    if (!plantType || plantType === 'Select or type plant name') {
        alert('Please select a plant type');
        return;
    }
    
    if (!length || !width || !plantSpacing || !rowSpacing) {
        alert('Please fill in all required fields (Bed dimensions and spacing values)');
        return;
    }

    if (length <= 0 || width <= 0 || plantSpacing <= 0 || rowSpacing <= 0) {
        alert('All measurements must be greater than zero');
        return;
    }

    // Calculate based on pattern
    let plantsPerRow, numberOfRows, totalPlants, density;

    if (pattern === 'square') {
        plantsPerRow = Math.floor(length / plantSpacing);
        numberOfRows = Math.floor(width / rowSpacing);
        totalPlants = plantsPerRow * numberOfRows;
    } else if (pattern === 'triangular') {
        plantsPerRow = Math.floor(length / plantSpacing);
        const rowHeight = rowSpacing * Math.sqrt(3) / 2;
        numberOfRows = Math.floor(width / rowHeight);
        totalPlants = Math.floor((plantsPerRow * numberOfRows) + (plantsPerRow / 2 * (numberOfRows - 1)));
    } else if (pattern === 'quincunx') {
        plantsPerRow = Math.floor(length / plantSpacing);
        const diagSpacing = plantSpacing * Math.sqrt(2);
        numberOfRows = Math.floor(width / diagSpacing) * 2;
        totalPlants = Math.floor((plantsPerRow * numberOfRows) / 2);
    }

    const effectiveArea = length * width;
    density = (totalPlants / effectiveArea).toFixed(2);

    // Display results
    $('#resultTotalPlants').text(totalPlants);
    $('#resultPlantsPerRow').text(plantsPerRow);
    $('#resultRows').text(numberOfRows);
    $('#resultDensity').text(density);
    $('#calcResults').removeClass('d-none');

    // Scroll to results smoothly
    setTimeout(() => {
        $('#calcResults')[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }, 100);
}

function addCalculationToList() {
    const plantType = $('#calcPlantType option:selected').text();
    const totalPlants = $('#resultTotalPlants').text();
    const density = $('#resultDensity').text();
    const pattern = $('#calcPattern option:selected').text();

    if (totalPlants === '0' || !plantType) {
        alert('Please calculate first before adding to the list');
        return;
    }

    const calcData = {
        plantType: plantType,
        totalPlants: totalPlants,
        density: density,
        pattern: pattern,
        length: $('#calcAreaLength').val(),
        width: $('#calcAreaWidth').val(),
        plantSpacing: $('#calcPlantSpacing').val(),
        rowSpacing: $('#calcRowSpacing').val()
    };

    savedPlantCalculations.push(calcData);

    const calcHtml = `
        <div class="alert alert-success mb-2" data-calc-index="${savedPlantCalculations.length - 1}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong>${plantType}</strong>
                    <div class="small">
                        <i class="fas fa-seedling me-1"></i>${totalPlants} plants | 
                        <i class="fas fa-chart-pie me-1"></i>${density} plants/m² | 
                        <i class="fas fa-th me-1"></i>${pattern}
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCalculationFromList(${savedPlantCalculations.length - 1})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;

    $('#savedCalculations').append(calcHtml);

    // Reset calculator for next entry
    $('#calcPlantType').val('');
    $('#calcAreaLength').val('');
    $('#calcAreaWidth').val('');
    $('#calcResults').addClass('d-none');
}

function removeCalculationFromList(index) {
    savedPlantCalculations.splice(index, 1);
    $(`[data-calc-index="${index}"]`).remove();
    updatePlantCount();
}

function updatePlantCount() {
    const count = savedPlantCalculations.length;
    $('#plantCount').text(count);
}

function initializeDynamicElements() {
    updatePlantCount();
    // Add default tasks if none exist
    if ($('#taskContainer').children().length === 0) {
        addTaskEntry('Prepare soil');
        addTaskEntry('Plant seeds/seedlings');
        addTaskEntry('Set up irrigation');
        addTaskEntry('Apply mulch');
    }
}



function addTaskEntry(taskName = '', completed = false) {
    taskCounter++;
    const taskId = 'task_' + taskCounter;
    
    const taskHtml = `
        <div class="d-flex align-items-center mb-2 task-entry" data-task-id="${taskId}">
            <input type="checkbox" class="form-check-input task-checkbox me-2" name="task_completed_${taskId}" ${completed ? 'checked' : ''}>
            <input type="text" class="form-control me-2" name="task_name_${taskId}" value="${taskName}" placeholder="Enter task description">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeTask('${taskId}')">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    $('#taskContainer').append(taskHtml);
    updateProgressBar();
}

function removeTask(taskId) {
    $(`.task-entry[data-task-id="${taskId}"]`).remove();
    updateProgressBar();
}

function updateProgressBar() {
    const totalTasks = $('.task-checkbox').length;
    const completedTasks = $('.task-checkbox:checked').length;
    const percentage = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
    
    $('#progressBar').css('width', percentage + '%').text(percentage + '%');
    $('#taskProgress').text(`${completedTasks} / ${totalTasks}`);
    
    // Update progress bar color based on completion
    $('#progressBar').removeClass('bg-success bg-warning bg-info');
    if (percentage >= 75) {
        $('#progressBar').addClass('bg-success');
    } else if (percentage >= 50) {
        $('#progressBar').addClass('bg-info');
    } else {
        $('#progressBar').addClass('bg-warning');
    }
}

function collectFormData() {
    // Collect basic form data
    const formData = new FormData(document.getElementById('gardenPlanForm'));
    
    // Collect saved plant calculations
    formData.set('plant_calculations', JSON.stringify(savedPlantCalculations));
    
    // Calculate total estimated plants from all calculations
    const totalPlants = savedPlantCalculations.reduce((sum, calc) => {
        return sum + parseInt(calc.totalPlants || 0);
    }, 0);
    formData.set('total_estimated_plants', totalPlants);

    // Collect seasonal schedule
    const seasonalSchedule = {
        planting: $('#plantingSchedule').val(),
        harvest: $('#harvestSchedule').val()
    };
    formData.set('seasonal_schedule', JSON.stringify(seasonalSchedule));

    // Collect irrigation plan
    const irrigationPlan = {
        schedule: $('#irrigationPlan').val(),
        estimated_usage: parseFloat($('#estimatedWaterUsage').val()) || 0
    };
    formData.set('irrigation_plan', JSON.stringify(irrigationPlan));

    // Collect soil requirements
    const soilRequirements = {
        requirements: $('#soilRequirements').val()
    };
    formData.set('soil_requirements', JSON.stringify(soilRequirements));

    // Collect fertilizer schedule
    const fertilizerSchedule = {
        schedule: $('#fertilizerSchedule').val()
    };
    formData.set('fertilizer_schedule', JSON.stringify(fertilizerSchedule));

    // Collect tool requirements
    const toolRequirements = {
        requirements: $('#toolRequirements').val()
    };
    formData.set('tool_requirements', JSON.stringify(toolRequirements));

    // Collect task checklist
    const tasks = [];
    $('.task-entry').each(function() {
        const taskId = $(this).data('task-id');
        const task = {
            name: $(`[name="task_name_${taskId}"]`).val(),
            completed: $(`[name="task_completed_${taskId}"]`).is(':checked')
        };
        if (task.name) tasks.push(task);
    });
    formData.set('task_checklist', JSON.stringify(tasks));

    return formData;
}

function savePlan() {
    const formData = collectFormData();
    const isEdit = $('#editMode').val() === 'true';
    const planId = $('#planId').val();

    const ajaxConfig = {
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('#successModal').modal('show');
                resetForm();
            }
        },
        error: function(xhr) {
            console.error('Save error:', xhr.responseJSON);
            const errors = xhr.responseJSON?.errors || {};
            let errorMsg = 'Error saving plan:\n';
            for (let field in errors) {
                errorMsg += errors[field].join('\n') + '\n';
            }
            alert(errorMsg);
        }
    };

    if (isEdit) {
        ajaxConfig.url = '/garden-planner/' + planId;
        ajaxConfig.type = 'POST';
        ajaxConfig.data.append('_method', 'PUT');
    } else {
        ajaxConfig.url = '{{ route("garden.planner.save") }}';
        ajaxConfig.type = 'POST';
    }

    $.ajax(ajaxConfig);
}

function resetForm() {
    $('#gardenPlanForm')[0].reset();
    $('#editMode').val('false');
    $('#planId').val('');
    $('#planFormTitle').html('<i class="fas fa-plus-circle text-primary me-2"></i>Create Comprehensive Garden Plan');
    $('#savePlanBtn').html('<i class="fas fa-save me-2"></i>Save Garden Plan');
    $('#cancelBtn').hide();
    
    // Reset dynamic content
    $('#savedCalculations').empty();
    $('#calcResults').addClass('d-none');
    $('#taskContainer').empty();
    savedPlantCalculations = [];
    calculationCounter = 0;
    taskCounter = 0;
    
    // Reinitialize
    initializeDynamicElements();
}

function loadPlan(planId) {
    $.ajax({
        url: '/garden-planner/' + planId,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(plan) {
            // Reset form first
            resetForm();
            
            // Populate basic information
            $('#planName').val(plan.name);
            $('#planDescription').val(plan.description);
            $('#totalArea').val(plan.total_area);
            $('#growingSeason').val(plan.growing_season);
            $('#climateZone').val(plan.climate_zone);
            $('#expectedYield').val(plan.expected_yield);
            $('#estimatedWaterUsage').val(plan.estimated_water_usage);
            $('#estimatedCost').val(plan.estimated_cost);
            $('#planStatus').val(plan.status);
            $('#additionalNotes').val(plan.notes);

            // Populate layout data
            if (plan.layout_data) {
                const layout = typeof plan.layout_data === 'string' ? JSON.parse(plan.layout_data) : plan.layout_data;
                $('#rows').val(layout.rows || 1);
                $('#cols').val(layout.cols || 1);
                $('#plantType').val(layout.defaultPlant || 'Plant');
            }

            // Populate calculations
            $('#savedCalculations').empty();
            savedPlantCalculations = [];
            if (plan.plant_calculations && plan.plant_calculations.length > 0) {
                // Parse if it's a JSON string
                const calculations = typeof plan.plant_calculations === 'string' 
                    ? JSON.parse(plan.plant_calculations) 
                    : plan.plant_calculations;
                
                // Load each calculation
                calculations.forEach((calc, index) => {
                    savedPlantCalculations.push(calc);
                    
                    const calcHtml = `
                        <div class="alert alert-success mb-2" data-calc-index="${index}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>${calc.plantType}</strong>
                                    <div class="small">
                                        <i class="fas fa-seedling me-1"></i>${calc.totalPlants} plants | 
                                        <i class="fas fa-chart-pie me-1"></i>${calc.density} plants/m² | 
                                        <i class="fas fa-th me-1"></i>${calc.pattern}
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCalculationFromList(${index})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    $('#savedCalculations').append(calcHtml);
                });
            }

            // Populate seasonal schedule
            if (plan.seasonal_schedule) {
                $('#plantingSchedule').val(plan.seasonal_schedule.planting || '');
                $('#harvestSchedule').val(plan.seasonal_schedule.harvest || '');
            }

            // Populate irrigation plan
            if (plan.irrigation_plan) {
                $('#irrigationPlan').val(plan.irrigation_plan.schedule || '');
            }

            // Populate soil requirements
            if (plan.soil_requirements) {
                $('#soilRequirements').val(plan.soil_requirements.requirements || '');
            }

            // Populate fertilizer schedule
            if (plan.fertilizer_schedule) {
                $('#fertilizerSchedule').val(plan.fertilizer_schedule.schedule || '');
            }

            // Populate tool requirements
            if (plan.tool_requirements) {
                $('#toolRequirements').val(plan.tool_requirements.requirements || '');
            }

            // Populate tasks
            $('#taskContainer').empty();
            taskCounter = 0;
            if (plan.task_checklist && plan.task_checklist.length > 0) {
                plan.task_checklist.forEach(task => {
                    addTaskEntry(task.name, task.completed);
                });
            } else {
                addTaskEntry('Prepare soil');
                addTaskEntry('Plant seeds/seedlings');
                addTaskEntry('Set up irrigation');
                addTaskEntry('Apply mulch');
            }

            // Set edit mode
            $('#editMode').val('true');
            $('#planId').val(plan.id);
            $('#planFormTitle').html('<i class="fas fa-edit text-warning me-2"></i>Edit Garden Plan');
            $('#savePlanBtn').html('<i class="fas fa-save me-2"></i>Update Plan');
            $('#cancelBtn').show();

            // Scroll to form
            $('html, body').animate({
                scrollTop: $('.card-dashboard').first().offset().top - 20
            }, 500);
        },
        error: function(xhr) {
            alert('Error loading plan for editing');
        }
    });
}

function viewPlan(planId) {
    $.ajax({
        url: '/garden-planner/' + planId,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(plan) {
            displayPlanDetails(plan);
            $('#planDetailsModal').modal('show');
        },
        error: function(xhr) {
            alert('Error loading plan details');
        }
    });
}

function displayPlanDetails(plan) {
    let detailsHtml = `
        <div class="row">
            <div class="col-md-8">
                <h4>${plan.name}</h4>
                <p class="text-muted">${plan.description || 'No description provided'}</p>
            </div>
            <div class="col-md-4 text-end">
                <span class="badge bg-${plan.status_color} fs-6">${plan.status.charAt(0).toUpperCase() + plan.status.slice(1)}</span>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-ruler-combined fa-2x text-primary mb-2"></i>
                        <h6>Area</h6>
                        <p class="mb-0">${plan.total_area ? plan.total_area + ' m²' : 'Not set'}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar fa-2x text-success mb-2"></i>
                        <h6>Season</h6>
                        <p class="mb-0">${plan.growing_season ? plan.growing_season.charAt(0).toUpperCase() + plan.growing_season.slice(1) : 'Not set'}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-seedling fa-2x text-warning mb-2"></i>
                        <h6>Plants</h6>
                        <p class="mb-0">${plan.total_estimated_plants || 0}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-apple-alt fa-2x text-danger mb-2"></i>
                        <h6>Expected Yield</h6>
                        <p class="mb-0">${plan.expected_yield ? plan.expected_yield + ' kg' : 'Not set'}</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Add more detailed sections if data exists
    if (plan.plant_calculations && plan.plant_calculations.length > 0) {
        // Parse if it's a JSON string
        const calculations = typeof plan.plant_calculations === 'string' 
            ? JSON.parse(plan.plant_calculations) 
            : plan.plant_calculations;
            
        detailsHtml += `
            <h5 class="mt-4"><i class="fas fa-calculator me-2"></i>Plant Calculations</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Plant Type</th>
                            <th>Pattern</th>
                            <th>Area (m²)</th>
                            <th>Spacing</th>
                            <th>Total Plants</th>
                            <th>Density</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        calculations.forEach(calc => {
            const area = (parseFloat(calc.length) * parseFloat(calc.width)).toFixed(2);
            detailsHtml += `
                <tr>
                    <td><strong>${calc.plantType}</strong></td>
                    <td>${calc.pattern}</td>
                    <td>${area}</td>
                    <td>${calc.plantSpacing}m × ${calc.rowSpacing}m</td>
                    <td><strong>${calc.totalPlants}</strong></td>
                    <td>${calc.density} plants/m²</td>
                </tr>
            `;
        });
        detailsHtml += `
                    </tbody>
                </table>
            </div>
        `;
    }

    if (plan.task_checklist && plan.task_checklist.length > 0) {
        const completedTasks = plan.task_checklist.filter(task => task.completed).length;
        const progressPercentage = Math.round((completedTasks / plan.task_checklist.length) * 100);
        
        detailsHtml += `
            <h5 class="mt-4"><i class="fas fa-tasks me-2"></i>Task Progress (${completedTasks}/${plan.task_checklist.length})</h5>
            <div class="progress mb-3">
                <div class="progress-bar" style="width: ${progressPercentage}%">${progressPercentage}%</div>
            </div>
            <ul class="list-group">
        `;
        plan.task_checklist.forEach(task => {
            detailsHtml += `
                <li class="list-group-item d-flex align-items-center">
                    <i class="fas fa-${task.completed ? 'check-circle text-success' : 'circle text-muted'} me-2"></i>
                    <span class="${task.completed ? 'text-decoration-line-through text-muted' : ''}">${task.name}</span>
                </li>
            `;
        });
        detailsHtml += `</ul>`;
    }

    $('#planDetailsContent').html(detailsHtml);
}

function deletePlan(planId) {
    $('#confirmDeleteBtn').data('plan-id', planId);
    $('#deleteConfirmModal').modal('show');
}

function performDelete(planId) {
    $('#deleteConfirmModal').modal('hide');

    $.ajax({
        url: '/garden-planner/' + planId,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('#deleteModal').modal('show');
            }
        },
        error: function(xhr) {
            let errorMsg = 'Error deleting plan';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg += ': ' + xhr.responseJSON.message;
            } else if (xhr.status) {
                errorMsg += ' (Status: ' + xhr.status + ')';
            }
            alert(errorMsg);
        }
    });
}
</script>
@endpush
@endsection
