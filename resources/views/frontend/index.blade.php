<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Book Parking</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/frontend/css/style.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/plugin.js') }}"></script>
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <a href="#" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ asset('assets/images/site-logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/site-logo.png') }}" class="bg-white w-75" alt="" height="50">
                                </span>
                            </a>
                            <h4 class="mb-sm-0 font-size-18 text-center">Book Parking</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div id="book-parking-form">
                                    <h3>Building Details</h3>
                                    @include('frontend.partials.step-1')
                                    
                                    <h3>Parking Plan</h3>
                                    @include('frontend.partials.step-2')

                                    <h3>Vehicle Details</h3>
                                    @include('frontend.partials.step-3')

                                    <h3>Confirm Detail</h3>
                                    @include('frontend.partials.step-4')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="overlay" id="processing">
        <div class="text-center">
            <div class="spinner-container">
                <i class="mdi mdi-loading spinner"></i>
            </div>

            <p class="fs-5">Please wait receipt is being generated...</p>
        </div>
    </div>


    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>

    <script src="{{ asset('assets/frontend/js/script.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    
    <script>
        $(function() {
            $('.select2').select2({
                width: '100%'
            });

            const $steps = $('.body');
            const $nextButton = $("a[href='#next']");
            const $prevButton = $("a[href='#previous']");
            let currentStep = 0;

            function showStep(step) {
                $steps.each(function (index) {
                    $(this).toggleClass("current", index === step);
                    $(this).attr("aria-hidden", index !== step);
                });
            }

            function validateCurrentStep() {
                const $currentForm = $steps.eq(currentStep).find("form");
                let valid = true;

                $currentForm.find("input, select").each(function () {
                    if ($(this).prop("required") && !$(this).val()) {
                        valid = false;
                        $(this).addClass("is-invalid"); // Bootstrap invalid class
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                return valid;
            }

            $nextButton.on("click", function (event) {
                event.preventDefault();
                if (validateCurrentStep()) {
                    currentStep++;
                    if (currentStep < $steps.length) {
                        showStep(currentStep);
                    }
                }
            });

            $prevButton.on("click", function (event) {
                event.preventDefault();
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            showStep(currentStep);
        })
    </script>
</body>

</html>
