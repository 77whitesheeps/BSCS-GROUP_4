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

                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs mb-4" id="planTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                    <i class="fas fa-info-circle me-1"></i>Basic Info
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="calculations-tab" data-bs-toggle="tab" data-bs-target="#calculations" type="button" role="tab">
                                    <i class="fas fa-calculator me-1"></i>Plant Calculations
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seasonal-tab" data-bs-toggle="tab" data-bs-target="#seasonal" type="button" role="tab">
                                    <i class="fas fa-calendar me-1"></i>Seasonal Planning
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources" type="button" role="tab">
                                    <i class="fas fa-tools me-1"></i>Resources & Care
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tracking-tab" data-bs-toggle="tab" data-bs-target="#tracking" type="button" role="tab">
                                    <i class="fas fa-tasks me-1"></i>Progress Tracking
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="planTabContent">
                            <!-- Basic Information Tab -->
                            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="planName" class="form-label">Plan Name *</label>
                                        <input type="text" class="form-control" id="planName" name="name" required placeholder="e.g., Summer Vegetable Garden 2024">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="totalArea" class="form-label">Total Area (m²)</label>
                                        <input type="number" class="form-control" id="totalArea" name="total_area" step="0.01" min="0" placeholder="e.g., 50.00">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="growingSeason" class="form-label">Growing Season</label>
                                        <select class="form-control" id="growingSeason" name="growing_season">
                                            <option value="">Select Season</option>
                                            <option value="spring">Spring</option>
                                            <option value="summer">Summer</option>
                                            <option value="fall">Fall/Autumn</option>
                                            <option value="winter">Winter</option>
                                            <option value="year-round">Year-round</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="climateZone" class="form-label">Climate Zone</label>
                                        <input type="text" class="form-control" id="climateZone" name="climate_zone" placeholder="e.g., 9a, Tropical, Mediterranean">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="planDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="planDescription" name="description" rows="3" placeholder="Describe your garden plan, goals, and objectives..."></textarea>
                                </div>

                                <!-- Basic Layout Configuration -->
                                <div class="card border-light">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-th me-2"></i>Basic Layout Configuration</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label for="rows" class="form-label small">Number of Rows</label>
                                                <input type="number" class="form-control" id="rows" name="rows" min="1" max="20" value="1">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="cols" class="form-label small">Number of Columns</label>
                                                <input type="number" class="form-control" id="cols" name="cols" min="1" max="20" value="1">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="plantType" class="form-label small">Default Plant Type</label>
                                                <input type="text" class="form-control" id="plantType" name="plant_type" placeholder="e.g., Tomato">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plant Calculations Tab -->
                            <div class="tab-pane fade" id="calculations" role="tabpanel">
                                <div class="card border-light mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Import Calculator Results</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Use the calculator links above to calculate planting densities, then paste the results here or manually enter calculation data.
                                        </div>
                                        
                                        <button type="button" class="btn btn-success btn-sm mb-3" id="addCalculationBtn">
                                            <i class="fas fa-plus me-2"></i>Add Plant Calculation
                                        </button>
                                        
                                        <div id="calculationsContainer">
                                            <!-- Dynamic calculation entries will be added here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Seasonal Planning Tab -->
                            <div class="tab-pane fade" id="seasonal" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-seedling me-2"></i>Planting Schedule</h6>
                                            </div>
                                            <div class="card-body">
                                                <textarea class="form-control" id="plantingSchedule" rows="6" placeholder="January: Start seeds indoors&#10;March: Transplant seedlings&#10;April: Direct sow cool-season crops&#10;May: Plant warm-season crops&#10;..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-apple-alt me-2"></i>Harvest Schedule</h6>
                                            </div>
                                            <div class="card-body">
                                                <textarea class="form-control" id="harvestSchedule" rows="6" placeholder="June: Early lettuce, radishes&#10;July: Summer squash, herbs&#10;August: Tomatoes, peppers&#10;September: Fall crops&#10;..."></textarea>
                                                <div class="mt-2">
                                                    <label for="expectedYield" class="form-label small">Expected Total Yield (kg)</label>
                                                    <input type="number" class="form-control" id="expectedYield" name="expected_yield" step="0.1" min="0" placeholder="e.g., 25.5">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resources & Care Tab -->
                            <div class="tab-pane fade" id="resources" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light mb-3">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-tint me-2"></i>Irrigation Plan</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <label for="estimatedWaterUsage" class="form-label small">Estimated Water Usage (L/week)</label>
                                                    <input type="number" class="form-control" id="estimatedWaterUsage" name="estimated_water_usage" step="0.1" min="0" placeholder="e.g., 150.0">
                                                </div>
                                                <textarea class="form-control" id="irrigationPlan" rows="4" placeholder="Daily: Check soil moisture&#10;Twice weekly: Deep watering of vegetables&#10;Weekly: Water fruit trees&#10;As needed: Supplement during dry spells"></textarea>
                                            </div>
                                        </div>

                                        <div class="card border-light">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-mountain me-2"></i>Soil Management</h6>
                                            </div>
                                            <div class="card-body">
                                                <textarea class="form-control" id="soilRequirements" rows="4" placeholder="pH: 6.0-7.0&#10;Well-draining loamy soil&#10;Rich in organic matter&#10;Regular compost additions"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light mb-3">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-leaf me-2"></i>Fertilizer Schedule</h6>
                                            </div>
                                            <div class="card-body">
                                                <textarea class="form-control" id="fertilizerSchedule" rows="4" placeholder="Spring: Apply compost and balanced fertilizer&#10;Mid-season: Side-dress heavy feeders&#10;Fall: Bone meal for perennials&#10;Winter: Mulch for soil protection"></textarea>
                                            </div>
                                        </div>

                                        <div class="card border-light">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-tools me-2"></i>Required Tools & Supplies</h6>
                                            </div>
                                            <div class="card-body">
                                                <textarea class="form-control" id="toolRequirements" rows="4" placeholder="Tools: Spade, hoe, rake, pruning shears&#10;Supplies: Seeds, seedlings, mulch, fertilizer&#10;Infrastructure: Trellises, stakes, irrigation system&#10;Estimated Cost: $XXX"></textarea>
                                                <div class="mt-2">
                                                    <label for="estimatedCost" class="form-label small">Estimated Total Cost ($)</label>
                                                    <input type="number" class="form-control" id="estimatedCost" name="estimated_cost" step="0.01" min="0" placeholder="e.g., 250.00">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Tracking Tab -->
                            <div class="tab-pane fade" id="tracking" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-tasks me-2"></i>Task Checklist</h6>
                                            </div>
                                            <div class="card-body">
                                                <button type="button" class="btn btn-success btn-sm mb-3" id="addTaskBtn">
                                                    <i class="fas fa-plus me-2"></i>Add Task
                                                </button>
                                                <div id="taskContainer">
                                                    <!-- Dynamic tasks will be added here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light mb-3">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>Status & Progress</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="planStatus" class="form-label">Current Status</label>
                                                    <select class="form-control" id="planStatus" name="status">
                                                        <option value="planning">Planning</option>
                                                        <option value="planted">Planted</option>
                                                        <option value="growing">Growing</option>
                                                        <option value="harvesting">Harvesting</option>
                                                        <option value="completed">Completed</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Progress Indicator</label>
                                                    <div class="progress mb-2">
                                                        <div class="progress-bar" role="progressbar" id="progressBar" style="width: 0%">0%</div>
                                                    </div>
                                                    <small class="text-muted">Based on completed tasks</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card border-light">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Additional Notes</h6>
                                            </div>
                                            <div class="card-body">
                                                <textarea class="form-control" id="additionalNotes" name="notes" rows="6" placeholder="Record observations, challenges, successes, and lessons learned..."></textarea>
                                            </div>
                                        </div>
                                    </div>
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

$(document).ready(function() {
    // Initialize dynamic content
    initializeDynamicElements();
    
    // Save/Update plan
    $('#savePlanBtn').on('click', function() {
        savePlan();
    });

    // Cancel editing
    $('#cancelBtn').on('click', function() {
        resetForm();
    });

    // Add calculation entry
    $('#addCalculationBtn').on('click', function() {
        addCalculationEntry();
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

function initializeDynamicElements() {
    // Add default calculation entry if none exist
    if ($('#calculationsContainer').children().length === 0) {
        addCalculationEntry();
    }
    
    // Add default tasks if none exist
    if ($('#taskContainer').children().length === 0) {
        addTaskEntry('Prepare soil');
        addTaskEntry('Plant seeds/seedlings');
        addTaskEntry('Set up irrigation');
        addTaskEntry('Apply mulch');
    }
}

function addCalculationEntry(data = null) {
    calculationCounter++;
    const calcId = 'calc_' + calculationCounter;
    
    const calcHtml = `
        <div class="card border-light mb-3 calculation-entry" data-calc-id="${calcId}">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Plant Calculation #${calculationCounter}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCalculation('${calcId}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small">Plant Type</label>
                        <input type="text" class="form-control" name="calc_plant_type_${calcId}" value="${data?.plant_type || ''}" placeholder="e.g., Tomato">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small">Calculation Method</label>
                        <select class="form-control" name="calc_method_${calcId}">
                            <option value="square" ${data?.method === 'square' ? 'selected' : ''}>Square Planting</option>
                            <option value="triangular" ${data?.method === 'triangular' ? 'selected' : ''}>Triangular</option>
                            <option value="quincunx" ${data?.method === 'quincunx' ? 'selected' : ''}>Quincunx</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="form-label small">Area Length (m)</label>
                        <input type="number" class="form-control" name="calc_length_${calcId}" value="${data?.area_length || ''}" step="0.1" min="0">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label small">Area Width (m)</label>
                        <input type="number" class="form-control" name="calc_width_${calcId}" value="${data?.area_width || ''}" step="0.1" min="0">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label small">Plant Spacing (cm)</label>
                        <input type="number" class="form-control" name="calc_spacing_${calcId}" value="${data?.plant_spacing || ''}" step="1" min="1">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label small">Total Plants</label>
                        <input type="number" class="form-control" name="calc_total_plants_${calcId}" value="${data?.total_plants || ''}" readonly>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#calculationsContainer').append(calcHtml);
}

function removeCalculation(calcId) {
    $(`.calculation-entry[data-calc-id="${calcId}"]`).remove();
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
}

function collectFormData() {
    // Collect basic form data
    const formData = new FormData(document.getElementById('gardenPlanForm'));
    
    // Collect layout data
    const rows = parseInt($('#rows').val()) || 1;
    const cols = parseInt($('#cols').val()) || 1;
    const plantType = $('#plantType').val() || 'Plant';
    const layout = {
        rows: rows,
        cols: cols,
        defaultPlant: plantType,
        grid: Array(rows).fill().map(() => Array(cols).fill(plantType))
    };
    formData.set('layout_data', JSON.stringify(layout));

    // Collect calculations
    const calculations = [];
    $('.calculation-entry').each(function() {
        const calcId = $(this).data('calc-id');
        const calc = {
            plant_type: $(`[name="calc_plant_type_${calcId}"]`).val(),
            method: $(`[name="calc_method_${calcId}"]`).val(),
            area_length: parseFloat($(`[name="calc_length_${calcId}"]`).val()) || 0,
            area_width: parseFloat($(`[name="calc_width_${calcId}"]`).val()) || 0,
            plant_spacing: parseFloat($(`[name="calc_spacing_${calcId}"]`).val()) || 0,
            total_plants: parseInt($(`[name="calc_total_plants_${calcId}"]`).val()) || 0
        };
        if (calc.plant_type) calculations.push(calc);
    });
    formData.set('plant_calculations', JSON.stringify(calculations));

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
    $('#calculationsContainer').empty();
    $('#taskContainer').empty();
    calculationCounter = 0;
    taskCounter = 0;
    
    // Go back to first tab
    $('.nav-tabs .nav-link').first().tab('show');
    
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
            $('#calculationsContainer').empty();
            calculationCounter = 0;
            if (plan.plant_calculations && plan.plant_calculations.length > 0) {
                plan.plant_calculations.forEach(calc => {
                    addCalculationEntry(calc);
                });
            } else {
                addCalculationEntry();
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
        detailsHtml += `
            <h5 class="mt-4"><i class="fas fa-calculator me-2"></i>Plant Calculations</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Plant Type</th>
                            <th>Method</th>
                            <th>Area (m²)</th>
                            <th>Spacing (cm)</th>
                            <th>Total Plants</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        plan.plant_calculations.forEach(calc => {
            const area = (calc.area_length * calc.area_width).toFixed(2);
            detailsHtml += `
                <tr>
                    <td>${calc.plant_type}</td>
                    <td>${calc.method.charAt(0).toUpperCase() + calc.method.slice(1)}</td>
                    <td>${area}</td>
                    <td>${calc.plant_spacing}</td>
                    <td>${calc.total_plants}</td>
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
