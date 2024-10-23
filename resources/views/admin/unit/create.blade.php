@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create a unit</h4>

                        <div class="page-title-right">
                            <a href="{{ route('unit.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to units</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="session('error')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('unit.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="basicpill-building">Building</label>
                                        <select @class(["form-control select2", 'is-invalid' => $errors->has('building')]) name="building">
                                            <option value="" disabled selected>Select Building</option>
                                            @foreach ($buildings as $item)
                                                <option value="{{ $item->id }}" @selected(old('building') == $item->id)>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('building')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <x-form-input name="unit_number" value="{{ old('unit_number') }}" label="Unit Number" placeholder="Enter Unit Number"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <x-form-input name="security_code" value="{{ old('security_code') }}" label="Security Code" placeholder="Enter Security Code"/>
                                    </div>
                                </div>
                                <div class="row" id="unit-plan-list">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-building-input">Number of days</label>
                                            <div id="days-section">
                                
                                                <!-- Free and Every Section -->
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label for="free-days">Free</label>
                                                        <input type="number" id="free-days" name="free_days" value="3" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="every-days">Every</label>
                                                        <input type="number" id="every-days" name="every_days" value="30" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="per-day">Per Day Cost</label>
                                                        <input type="number" id="per-day" name="per_day" value="1" class="form-control" step="0.1" min="0" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="minimum-cost">Minimum Cost</label>
                                                        <input type="number" id="minimum-cost" name="minimum_cost" value="30" class="form-control" step="0.1" min="0" required>
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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
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
                            <input type="number" name="periods[${periodCount}][days]" value="1" class="form-control period_days" required>
                        </div>
                        <div class="col-md-2">
                            <label>Default$</label>
                            <input type="number" name="periods[${periodCount}][price]" value="10" class="form-control period_price" required>
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

            $(document).on('change', '[name="building"],#unit_number', function(e) {
                var buildingId = $('[name="building"]').val();
                var planId = $('#unit_number').val();
                $.ajax({
                    url : `{{ route('unit.planlist') }}/${buildingId}/${planId}`,
                    type : 'GET',
                    success : function(resp){
                        console.log(resp);
                    }
                });
            });
        });
    </script>
@endsection