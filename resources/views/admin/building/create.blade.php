@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create a building</h4>

                        <div class="page-title-right">
                            <a href="{{ route('building.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to buildings</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('building.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-building-input">Building name</label>
                                            <input type="text" class="form-control" name="name" id="basicpill-building-input" placeholder="Enter Building Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-building-input">Number of days</label>
                                            <div id="days-section">
                                
                                                <!-- Free and Every Section -->
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label for="free-days">Free</label>
                                                        <input type="number" id="free-days" name="free_days" value="3" class="form-control">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="every-days">Every</label>
                                                        <input type="number" id="every-days" name="every_days" value="30" class="form-control">
                                                    </div>
                                                </div>
                                
                                                <!-- Periods Section -->
                                                <div id="periods">
                                                    <!-- Dynamically added periods will appear here -->
                                                </div>
                                
                                                <!-- Add Period Button -->
                                                <button type="button" id="add-period-btn" class="btn btn-primary mt-2">Add Period</button>
                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                              
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                                </div>
                            </form>    
                        </div>    
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <script>
        $(document).ready(function() {
            let periodCount = 0;

            // Function to renumber periods and update input names
            function renumberPeriods() {
                $('#periods .period-section').each(function(index, element) {
                    $(this).find('input[name^="period_days"]').attr('name', `periods[${index}][days]`);
                    $(this).find('input[name^="period_price"]').attr('name', `periods[${index}][price]`);
                });
            }

            // Add period section on button click
            $('#add-period-btn').click(function(e) {
                e.preventDefault();
                periodCount++;
                $('#periods').append(`
                    <div class="row mb-3 period-section" id="period-${periodCount}">
                        <div class="col-md-2">
                            <label>Period ${periodCount}</label>
                            <input type="number" name="periods[${periodCount}][days]" value="1" class="form-control period_days">
                        </div>
                        <div class="col-md-2">
                            <label>Default$</label>
                            <input type="number" name="periods[${periodCount}][price]" value="10" class="form-control period_price">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger mt-4 remove-period-btn" data-period="${periodCount}">Remove</button>
                        </div>
                    </div>
                `);
                renumberPeriods(); // Renumber periods after adding a new period
            });

            // Remove period section on button click
            $(document).on('click', '.remove-period-btn', function(e) {
                e.preventDefault();
                $(this).closest('.period-section').remove(); // Remove the clicked period section
                renumberPeriods(); // Renumber periods after removal
            });
        });
    </script>
@endsection