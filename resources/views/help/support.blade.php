@extends('layouts.dashboard')

@section('title', 'Help & Support')
@section('page-title', 'Help & Support')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Help & Support</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard mb-4">
                <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #68af2c, #5a9625);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-question-circle me-2"></i>Help & Support
                    </h5>
                </div>
                <div class="card-body">
                    <h6>Welcome to the Help & Support Center</h6>
                    <p>Here you can find answers to common questions and get support for using Plant-O-Matic.</p>

                    <div class="accordion" id="helpAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How do I use the Planting Calculators?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#helpAccordion">
                                <div class="accordion-body">
                                    The Planting Calculators help you determine the number of plants needed for your garden. Select the calculator type (Square, Quincunx, or Triangular), enter your garden dimensions, and choose the plant spacing. The calculator will provide the optimal number of plants.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How can I save my calculations?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#helpAccordion">
                                <div class="accordion-body">
                                    After performing a calculation, you can save it by clicking the "Save" button. Saved calculations can be viewed in the Calculations > Saved Calculations section.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How do I export my data?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#helpAccordion">
                                <div class="accordion-body">
                                    Go to Calculations > Export to export your saved calculations in PDF, CSV, or Excel format. You can set your preferred export format in Preferences.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    How do I change my preferences?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#helpAccordion">
                                <div class="accordion-body">
                                    Navigate to Settings > Preferences to customize email notifications, theme, default garden size, auto-save options, and export format.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Need more help?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#helpAccordion">
                                <div class="accordion-body">
                                    If you can't find the answer to your questions here, please contact our support team at plantomatic@gmail.com.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
