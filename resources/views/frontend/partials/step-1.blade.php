<section>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Building Name</label>
                <select name="building_name" class="form-control select2" id="buildingSelect" required>
                    <option value="" selected disabled>Select Building</option>
                    @foreach($buildings as $key => $building)
                        <option value="{{$building->id }}">{{$building->name}}</option>
                    @endforeach
                </select>

                <span class="invalid-feedback">Please select building</span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="unitSelect">Unit Number</label>
                <select class="form-control" id="unitSelect" required>
                    <option value="" selected disabled>Select Unit</option>
                </select>

                <span class="invalid-feedback">Please select Unit</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="securityCode">Security Code</label>
                <input type="text" id="securityCode" class="form-control" placeholder="Security Code" required>
                <span class="invalid-feedback">Please enter security Code</span>
            </div>
        </div>
    </div>
</section>

<script>
    $(function() {
        /* const units = {
            "Building 1": ["Unit 101", "Unit 102", "Unit 103"],
            "Building 2": ["Unit 201", "Unit 202", "Unit 203"]
        }; */

        $('#buildingSelect').on('change', function() {
            const selectedBuilding = $(this).val();
            const $unitSelect = $('#unitSelect');

            // Clear previous units
            $unitSelect.empty().append('<option value="" selected disabled>Select Unit</option>');
            $.ajax({
                url: `/units-by-building-id/${selectedBuilding}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Check if units are returned
                    if (response.units && response.units.length > 0) {
                        response.units.forEach(unit => {
                            $unitSelect.append(`<option value="${unit.id}" data-password="${unit.security_code}">${unit.unit_number}</option>`);
                        });
                    } else {
                        $unitSelect.append('<option value="" disabled>No units available</option>');
                    }
                }
            });
            // Populate units based on the selected building
            /* if (units[selectedBuilding]) {
                units[selectedBuilding].forEach(unit => {
                    $unitSelect.append(`<option value="${unit}">${unit}</option>`);
                });
            } */
        });

        $('#unitSelect').on('change', function() {
            const formData = {
                building_id: $("#buildingSelect").val(),
                unit_id: $("#unitSelect").val(),
            }

            $.ajax({
                url: '/api/plans',
                type: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(formData),
                dataType: 'json',
                success: function(response) {
                    if(response.success == true) {
                        $('div.plan-container[data-plan="3days"]').removeClass('bg-primary-subtle').addClass('bg-dark-subtle text-white');
                    } else {
                        $('div.plan-container[data-plan="3days"]').removeClass('bg-dark-subtle text-white').addClass('bg-primary-subtle');
                    }
                }
            });
        });
    });
</script>
