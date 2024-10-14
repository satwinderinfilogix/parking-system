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
                            $unitSelect.append(`<option value="${unit.id}" data-password="${unit.security_code}" data-30-days-cost="${unit['30_days_cost']}">${unit.unit_number}</option>`);
                        });
                    } else {
                        $unitSelect.append('<option value="" disabled>No units available</option>');
                    }
                }
            });
            $.ajax({
                url: `/plans-by-building-id/${selectedBuilding}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.success){
                        var plans = `<div class="col-lg-6">
                                            <div class="mb-3">
                                                <div class="card shadow-sm bg-primary-subtle plan-container" data-plan="3days" data-price="0">
                                                    <div class="card-body">
                                                        <h5>${response.plans.free} Days Parking</h5>
                                                        <h4>Free</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;

                            var plansList = response.plans.parkings;
                            $.each(plansList, function(key,val) { 
                                var getPrice = parseFloat(val.price).toFixed(2);
                                
                                plans += `<div class="col-lg-6">
                                            <div class="mb-3">
                                                <div class="card shadow-sm bg-primary-subtle plan-container" data-plan="${val.days}days" data-price="${val.price}">
                                                    <div class="card-body">
                                                        <h5>${val.days} Days Parking</h5>
                                                        <h4><span>$</span>${getPrice}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;    
                            });
                            $('#plans-list').html(plans);
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

            let monthlyCost = parseFloat($(`#unitSelect option:selected`).attr('data-30-days-cost'));
            $(`#30_days_cost`).val(monthlyCost);
            
            if(monthlyCost < 1){
                $(`.monthlyPlanCost`).html(`Free`);
            } else {
                $(`.monthlyPlanCost`).html(`&dollar;${monthlyCost.toFixed(2)}`);
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
                        $('.plan-container[data-plan="3days"]').removeClass('bg-primary-subtle').addClass('bg-dark-subtle text-white');
                    } else {
                        $('.plan-container[data-plan="3days"]').removeClass('bg-dark-subtle text-white').addClass('bg-primary-subtle');
                    }
                    
                    if (response.data) {
                        $('#prev-vehicles-history').html(``);

                        if(response.data.length > 0){
                            $('#prev-vehicle-history-buttons').removeClass('d-none');
                            $('.vehicle-form').addClass('d-none');
                        } else {
                            $('#prev-vehicle-history-buttons').addClass('d-none');
                            $('.vehicle-form').removeClass('d-none');
                        }

                        response.data.forEach((vehicle, index) => {
                            $('#prev-vehicles-history').append(`<tr data-vehicle="${encodeURIComponent(JSON.stringify(vehicle))}">
                                <td>${++index}</td>
                                <td>${vehicle.car_brand}</td>
                                <td>${vehicle.model}</td>
                                <td>${vehicle.license_plate}</td>
                                <td><button class="btn btn-primary btn-sm use-vehicle"><i class="fa fa-check"></i></button></td>
                            </tr>`);
                        });
                    }
                }
            });
        });
    });
</script>
