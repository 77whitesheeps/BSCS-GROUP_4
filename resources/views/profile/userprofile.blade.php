@extends('layouts.app')

@section('title', 'Profile Settings')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <!-- profile details -->
            <div class="card card-dashboard mb-4">
                <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #68af2c, #5a9625);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Full Name</label>
                                <div class="form-control-plaintext border rounded p-2 bg-light">{{ $user->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Email Address</label>
                                <div class="form-control-plaintext border rounded p-2 bg-light">{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Member Since</label>
                                <div class="form-control-plaintext border rounded p-2 bg-light">
                                    <i class="fas fa-calendar me-2"></i>{{ $user->created_at->format('F j, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- change pass card -->
            <div class="card card-dashboard">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-key me-2"></i>Change Password
                    </h5>
                </div>
                <div class="card-body">
                    <div id="password-change-section" class="d-none">
                        <form method="POST" action="{{ route('profile.change-password.update') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                           id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                       id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="hidePasswordForm()">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-plant">
                                    <i class="fas fa-save me-2"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="password-change-button" class="text-center">
                        <button type="button" class="btn btn-outline-primary" onclick="showPasswordForm()">
                            <i class="fas fa-key me-2"></i>Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Statistics Sidebar -->
        <div class="col-lg-4">
            <!-- acc stats -->
            <div class="card card-dashboard mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Account Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-number">{{ $user->total_calculations ?? 0 }}</div>
                            <small class="text-muted">Calculations</small>
                        </div>
                        <div class="col-6">
                            <div class="stat-number">{{ $user->gardenPlans->count() ?? 0 }}</div>
                            <small class="text-muted">Garden Plans</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Account secured with password
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showPasswordForm() {
    document.getElementById('password-change-section').classList.remove('d-none');
    document.getElementById('password-change-button').classList.add('d-none');
}

function hidePasswordForm() {
    document.getElementById('password-change-section').classList.add('d-none');
    document.getElementById('password-change-button').classList.remove('d-none');
}
</script>

<style>
.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--plant-green);
}

.form-control-plaintext {
    min-height: 38px;
    display: flex;
    align-items: center;
}
</style>
@endsection
