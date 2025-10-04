@extends('layouts.dashboard')

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
                        <i class="fas fa-map text-success me-2"></i>Design Your Garden
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">Create and manage your garden plans. Start by creating a new plan or loading an existing one.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Plan Form -->
        <div class="col-lg-8 mb-4">
            <div class="card card-dashboard">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle text-primary me-2"></i>Create New Plan
                    </h5>
                </div>
                <div class="card-body">
                    <form id="gardenPlanForm">
                        @csrf
                        <!-- Hidden fields for edit mode -->
                        <input type="hidden" id="editMode" name="edit_mode" value="false">
                        <input type="hidden" id="planId" name="plan_id" value="">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="planName" class="form-label">Plan Name</label>
                                <input type="text" class="form-control" id="planName" name="name" required placeholder="e.g., Vegetable Garden 2024">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="totalArea" class="form-label">Total Area (m²)</label>
                                <input type="number" class="form-control" id="totalArea" name="total_area" step="0.01" min="0" placeholder="e.g., 50.00">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="planDescription" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="planDescription" name="description" rows="3" placeholder="Describe your garden plan..."></textarea>
                        </div>

                        <!-- Basic Grid Layout -->
                        <div class="mb-3">
                            <label class="form-label">Garden Layout (Basic Grid)</label>
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

                        <!-- Layout Data -->
                        <input type="hidden" id="layoutData" name="layout_data">

                        <div class="text-end">
                            <button type="button" id="cancelBtn" class="btn btn-danger me-2" style="display: none;">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="button" id="savePlanBtn" class="btn btn-plant">
                                <i class="fas fa-save me-2"></i>Save Plan
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
                        <i class="fas fa-list text-info me-2"></i>Your Plans
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($plans as $plan)
                        <div class="plan-item mb-3 p-3 border rounded">
                            <h6 class="mb-1">{{ $plan->name }}</h6>
                            <p class="text-muted small mb-2">{{ $plan->description ?: 'No description' }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    @if($plan->total_area)
                                        {{ number_format($plan->total_area, 2) }} m²
                                    @else
                                        Area not set
                                    @endif
                                </small>
                                <small class="text-muted">{{ $plan->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-outline-primary me-1" onclick="loadPlan({{ $plan->id }})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deletePlan({{ $plan->id }})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No garden plans yet</p>
                            <p class="small text-muted">Create your first plan to get started!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

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
$(document).ready(function() {
    // Save/Update plan
    $('#savePlanBtn').on('click', function() {
        const formData = new FormData(document.getElementById('gardenPlanForm'));
        const isEdit = $('#editMode').val() === 'true';
        const planId = $('#planId').val();

        // Generate basic layout data
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
                const errors = xhr.responseJSON.errors;
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
    });

    // cancel editing
    $('#cancelBtn').on('click', function() {
        resetForm();
    });

    // Close modal and reload page
    $('#successModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    // close delete modal and reload page
    $('#deleteModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    // handle delete confirmation
    $('#confirmDeleteBtn').on('click', function() {
        const planId = $(this).data('plan-id');
        performDelete(planId);
    });
});

// Reset form to create mode
function resetForm() {
    $('#gardenPlanForm')[0].reset();
    $('#editMode').val('false');
    $('#planId').val('');
    $('.card-title').html('<i class="fas fa-plus-circle text-primary me-2"></i>Create New Plan');
    $('#savePlanBtn').html('<i class="fas fa-save me-2"></i>Save Plan');
    $('#cancelBtn').hide();
}

// Load plan for editing
function loadPlan(planId) {
    $.ajax({
        url: '/garden-planner/' + planId,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(plan) {
            // Populate form with plan data
            $('#planName').val(plan.name);
            $('#planDescription').val(plan.description);
            $('#totalArea').val(plan.total_area);

            // populate layout data if available
            if (plan.layout_data) {
                const layout = typeof plan.layout_data === 'string' ? JSON.parse(plan.layout_data) : plan.layout_data;
                $('#rows').val(layout.rows || 1);
                $('#cols').val(layout.cols || 1);
                $('#plantType').val(layout.defaultPlant || 'Plant');
            }

            // edit mode
            $('#editMode').val('true');
            $('#planId').val(plan.id);
            $('.card-title').html('<i class="fas fa-edit text-warning me-2"></i>Edit Plan');
            $('#savePlanBtn').html('<i class="fas fa-save me-2"></i>Update Plan');
            $('#cancelBtn').show();

            $('html, body').animate({
                scrollTop: $('.card-dashboard').first().offset().top - 20
            }, 500);
        },
        error: function(xhr) {
            alert('Error loading plan for editing');
        }
    });
}

// Delete plan - show confirmation modal
function deletePlan(planId) {
    $('#confirmDeleteBtn').data('plan-id', planId);
    $('#deleteConfirmModal').modal('show');
}

// actual deletion
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
