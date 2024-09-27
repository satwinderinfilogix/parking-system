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
                            <h4 class="card-title">Add a Parking</h4>
                            <form action="{{ route('parking.store') }}" method="post">
                                @csrf
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <label for="basicpill-building">Building</label>
                                        <select class="form-control select2" name="building_id" id="building-select">
                                            <option value="" disabled selected>Select Building</option>
                                            @foreach ($buildings as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('building_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="basicpill-units">Units</label>
                                        <select class="form-control select2" name="unit_id" id="unit-select">
                                            <option value="" disabled selected>Select Unit</option>
                                        </select>
                                        @error('unit_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <x-form-input name="security_code" value="{{ old('security_code') }}" label="Security Code" placeholder="Enter Security Code"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="basicpill-building">Plan</label>
                                        <select class="form-control select2" name="plan" id="plan">
                                            <option value="" disabled selected>Select Plan</option>
                                            <option value="3days">3days</option>
                                            <option value="30days">30days</option>
                                        </select>
                                        @error('plan')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <div class=" datepicker-container">
                                            <label for="start-date">Date Start</label>
                                            <div class="input-group" id="startDate">
                                                <input type="text" class="form-control" name="start_date" id="start-date" placeholder="YYYY-MM-DD"
                                                    data-date-format="yyyy-mm-dd" data-date-container='#startDate' data-provide="datepicker"
                                                    data-date-autoclose="true">
                        
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                            <span class="invalid-feedback">Please enter a valid date.</span>
                                        </div>
                                        @error('start_date')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form-input name="car_brand" value="{{ old('car_brand') }}" label="Car brand" placeholder="Enter Car Brand"/>
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <x-form-input name="model" value="{{ old('model') }}" label="Model" placeholder="Enter Model"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form-input name="color" value="{{ old('color') }}" label="Color" placeholder="Enter Color"/>
                                    </div>
                                </div> 
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <x-form-input name="license_plate" value="{{ old('license_plate') }}" label="License Plate" placeholder="Enter License Plate"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="confirmation-method">Receive Confirmation By:</label>
                                        <select class="form-control" name="confirmation" id="confirmation-method">
                                            <option value="" selected disabled>Select Source</option>
                                            <option value="Email">Email</option>
                                            <option value="Text">Text</option>
                                        </select>
                                        @error('confirmation')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6" id="email-input" style="display: none;">
                                        <x-form-input name="email" value="{{ old('email') }}" id="email" label="Email" placeholder="Enter Email"/>
                                    </div>
                                    <div class="col-lg-6" id="phone-input" style="display: none;">
                                        <x-form-input name="phone" value="{{ old('phone') }}" id="phone" label="Phone Number" placeholder="Enter Phone Number"/>
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    </div>
                                </div>
                            </form>    
                        </div>    
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     $(document).ready(function() {
        let today = new Date();
        $('#start-date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: today // Disable past dates
        });

        $('#confirmation-method').change(function() {
            const selectedValue = $(this).val();

            // Hide both inputs initially
            $('#email-input').hide();
            $('#phone-input').hide();

            // Show the relevant input based on selection
            if (selectedValue === 'Email') {
                $('#email-input').show();
            } else if (selectedValue === 'Text') {
                $('#phone-input').show();
            }
        });
    });

    $(document).ready(function() {
        let unitSecurityCode = '';
        $('#building-select').change(function() {
            var buildingId = $(this).val();
            if (buildingId) {
                $.ajax({
                    url: '/units-by-building-id/' + buildingId, // Update with your route
                    type: 'GET',
                    success: function(data) {
                        $('#unit-select').empty().append('<option value="" disabled selected>Select Unit</option>');
                        $.each(data.units, function(index, unit) {
                            $('#unit-select').append('<option value="' + unit.id + '" data-password="'+ unit.security_code +'">' + unit.unit_number + '</option>');
                        });
                    },
                    error: function() {
                        $('#unit-select').empty().append('<option value="" disabled selected>Error loading units</option>');
                    }
                });
            } else {
                $('#unit-select').empty().append('<option value="" disabled selected>Select Unit</option>');
            }
        });

        $('#unit-select').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            unitSecurityCode = selectedOption.data('password'); // Update the security code variable
        });

        // $('input[name="security_code"]').on('input', function() {
        //     var inputSecurityCode = $(this).val();

        //     if (inputSecurityCode !== unitSecurityCode) {
        //         alert('Code mismatch'); // Alert for mismatched codes
        //     }
        // });


    });
</script>