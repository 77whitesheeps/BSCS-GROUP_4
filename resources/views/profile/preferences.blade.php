@extends('layouts.app')

@section('title', 'Preferences Settings')
@section('page-title', 'Preferences Settings')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Preferences</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-dashboard mb-4">
                <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #68af2c, #5a9625);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sliders-h me-2"></i>Preferences
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('preferences.update') }}" id="preferences-form">
                        @csrf

                        <div class="mb-3 form-check form-switch">
                            <input type="hidden" name="email_notifications" value="0">
                            <input type="checkbox" class="form-check-input preference-input" id="email_notifications" name="email_notifications" value="1" {{ $user->email_notifications ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_notifications">{{ __('Enable Email Notifications') }}</label>
                            @error('email_notifications')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input type="hidden" name="theme" value="light">
                            <input type="checkbox" class="form-check-input preference-input" id="theme" name="theme" value="dark" {{ $user->theme === 'dark' ? 'checked' : '' }}>
                            <label class="form-check-label" for="theme">Enable Dark Mode</label>
                            @error('theme')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="mb-3">
                            <label for="default_garden_size" class="form-label">{{ __('Default Garden Size') }}</label>
                            <select class="form-select preference-input" id="default_garden_size" name="default_garden_size" required>
                                <option value="square_meters" {{ $user->default_garden_size === 'square_meters' ? 'selected' : '' }}>Square Meters</option>
                                <option value="acres" {{ $user->default_garden_size === 'acres' ? 'selected' : '' }}>Acres</option>
                            </select>
                            @error('default_garden_size')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input type="hidden" name="auto_save_calculations" value="0">
                            <input type="checkbox" class="form-check-input preference-input" id="auto_save_calculations" name="auto_save_calculations" value="1" {{ $user->auto_save_calculations ? 'checked' : '' }}>
                            <label class="form-check-label" for="auto_save_calculations">{{ __('Enable Auto-save Calculations') }}</label>
                            @error('auto_save_calculations')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="export_format" class="form-label">{{ __('Export Format') }}</label>
                            <select class="form-select preference-input" id="export_format" name="export_format" required>
                                <option value="pdf" {{ $user->export_format === 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="csv" {{ $user->export_format === 'csv' ? 'selected' : '' }}>CSV</option>
                                <option value="excel" {{ $user->export_format === 'excel' ? 'selected' : '' }}>Excel</option>
                            </select>
                            @error('export_format')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-muted small mt-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Preferences are saved automatically when changed.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var inputs = document.querySelectorAll('.preference-input');
    var isSubmitting = false;
    inputs.forEach(function(input) {
        input.addEventListener('change', function() {
            if (isSubmitting) return;
            isSubmitting = true;
            document.getElementById('preferences-form').submit();
        });
    });
});
</script>
@endsection
