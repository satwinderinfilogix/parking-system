<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <label for="basicpill-building">Building</label>
        <select name="building" id="building-select" @class([
            'form-control select2',
            'is-invalid' => $errors->has('building'),
        ])>
            <option value="" disabled selected>Select Building</option>
            @foreach ($buildings as $item)
                <option value="{{ $item->id }}" @selected(old('building', $parking->building_id ?? '') == $item->id)>{{ $item->name }}</option>
            @endforeach
        </select>
        @error('building')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-lg-6 mb-2">
        <label for="basicpill-units">Units</label>
        <select name="unit" id="unit-select" @class([
            'form-control select2',
            'is-invalid' => $errors->has('building'),
        ])>
            <option value="" disabled selected>Select Unit</option>
        </select>
        @error('unit')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-lg-6 mb-2">
        <label for="plan">Plan</label>
        <select @class(['form-control select2', 'is-invalid' => $errors->has('plan')]) name="plan" id="plan">
            <option value="" disabled selected>Select Plan</option>
            <option value="3days" @selected(old('plan', $parking->plan ?? '') == '3days')>3days</option>
            <option value="30days" @selected(old('plan', $parking->plan ?? '') == '30days')>30days</option>
        </select>
        @error('plan')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-lg-6 mb-2">
        <div class=" datepicker-container">
            <label for="start-date">Date Start</label>
            <div class="input-group" id="startDate">
                <input type="text" @class(['form-control', 'is-invalid' => $errors->has('start_date')]) name="start_date" id="start-date"
                    placeholder="YYYY-MM-DD" data-date-format="yyyy-mm-dd" data-date-container='#startDate'
                    data-provide="datepicker" data-date-autoclose="true"
                    value="{{ old('start_date', $parking->start_date ?? '') }}">

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
    <div class="col-lg-6 mb-2">
        <x-form-input name="car_brand" label="Car brand" placeholder="Enter Car Brand" value="{{ old('car_brand', $parking->car_brand ?? '') }}" />
    </div>

    <div class="col-lg-6 mb-2">
        <x-form-input name="model" label="Model" placeholder="Enter Model" value="{{ old('model', $parking->model ?? '') }}" />
    </div>
    <div class="col-lg-6 mb-2">
        <x-form-input name="color" label="Color" placeholder="Enter Color" value="{{ old('color', $parking->color ?? '') }}" />
    </div>

    <div class="col-lg-6 mb-2">
        <x-form-input name="license_plate" value="{{ old('license_plate', $parking->license_plate ?? '') }}" label="License Plate"
            placeholder="Enter License Plate" />
    </div>
    <div class="col-lg-6 mb-2">
        <label for="confirmation-method">Receive Confirmation By:</label>
        <select @class(['form-control', 'is-invalid' => $errors->has('confirmation')]) name="confirmation" id="confirmation-method">
            <option value="" selected disabled>Select Source</option>
            <option value="Email" @selected((old('confirmation') == 'Email') || ($parking->email ?? ''))>Email</option>
            <option value="Text" @selected((old('confirmation') == 'Text')  || ($parking->phone_number ?? ''))>Text</option>
        </select>
        @error('confirmation')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-lg-6 mb-2" id="email-input" @style(['display: none' => (old('confirmation') !== 'Email' && (!isset($parking) || !$parking->email))])>
        <x-form-input name="email" value="{{ $parking->email ?? '' }}" id="email" label="Email"
            placeholder="Enter Email" />
    </div>
    <div class="col-lg-6 mb-2" id="phone-input" @style(['display: none' => (old('confirmation') !== 'Text' && (!isset($parking) || !$parking->phone_number))])>
        <x-form-input name="phone" value="{{ $parking->phone_number ?? '' }}" id="phone" label="Phone Number"
            placeholder="Enter Phone Number" />
    </div>
</div>
<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>


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

    function getUnitsByBuildingId(buildingId) {
        if (buildingId) {
            $.ajax({
                url: '/units-by-building-id/' + buildingId,
                type: 'GET',
                success: function(data) {
                    $('#unit-select').empty().append(
                        '<option value="" disabled selected>Select Unit</option>');
                    $.each(data.units, function(index, unit) {
                        let selectedUnit = ``;
                        
                        if(`{{ old('unit', $parking->unit_id ?? '') }}` == unit.id){
                            selectedUnit = ` selected="selected"`;
                        }

                        $('#unit-select').append(`<option value="${unit.id}" ${selectedUnit}>${unit.unit_number}</option>`);
                    });
                },
                error: function() {
                    $('#unit-select').empty().append(
                        '<option value="" disabled selected>Error loading units</option>');
                }
            });
        } else {
            $('#unit-select').empty().append('<option value="" disabled selected>Select Unit</option>');
        }
    }

    $(document).ready(function() {
        $('#building-select').change(function() {
            var buildingId = $(this).val();
            getUnitsByBuildingId(buildingId);
        });

        if (`{{ old('building', $parking->building_id ?? '') }}`) {
            let buildingId = `{{ old('building', $parking->building_id ?? '') }}`;
            getUnitsByBuildingId(buildingId);
        }
    });
</script>
