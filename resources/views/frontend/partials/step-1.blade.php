<section>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input.form-control.number-days {
            width: 15% !important;
            -moz-appearance: textfield;
        }				
        .card-body.per-day-card {
            display: flex;
            padding-bottom: 0px;
            padding-top: 14px;
            justify-content: space-between;
        }
        .inner-day {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .right-section {
            font-size: 16px;
            font-weight: 500;
        }
    </style>
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
                        //Free Plan
                                var plans = `<div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <div class="card shadow-sm bg-primary-subtle plan-container" data-plan="3days" data-price="0" data-days="${response.plans.free}">
                                                            <div class="card-body">
                                                                <h5>${response.plans.free} Days Parking</h5>
                                                                <h4>Free</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>`;
                                //Per Day Plan
                                plans += `<div class="col-lg-6">
                                            <div class="mb-3">
                                                <div class="card shadow-sm bg-primary-subtle plan-container" data-plan="per_day_plan" data-price="0" data-days="${response.plans.free}">
                                                    <div class="card-body per-day-card">
                                                        <div class="col-md-8 left-section">
                                                            <span>$</span>${response.plans.per_day} Per Day (minimum <span>$</span>${response.plans.minimum_cost})<br/>
                                                            <div class="inner-day">Enter number of days <input type="number" name="number_of_days" class="form-control number-days" placeholder="0"></div><br/>
                                                        </div>
                                                        <div class="col-md-4 right-section text-end">
                                                            Total : $<span class="total-cost">0</span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="per_day" value="${response.plans.per_day}">
                                                    <input type="hidden" id="minimum_cost" value="${response.plans.minimum_cost}">
                                                </div>
                                            </div>
                                        </div>`;
                            // Additional Plan
                            var plansList = response.plans.parkings;
                            $.each(plansList, function(key,val) { 
                                var getPrice = parseFloat(val.price).toFixed(2);
                                
                                plans += `<div class="col-lg-6">
                                            <div class="mb-3">
                                                <div class="card shadow-sm bg-primary-subtle plan-container" data-plan="${val.days}days" data-price="${val.price}" data-days="${val.days}">
                                                    <div class="card-body">
                                                        <h5>${val.days} Days Parking</h5>
                                                        <h4><span>$</span>${getPrice}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;    
                            });
                            $('#plans-list').html(plans);
                            setupKeyupListener();
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
        function setupKeyupListener() {
            $('[name="number_of_days"]').on('keyup change', function() {
                var numberOfDays = parseInt($(this).val()) || 0; 
                var perDay = parseFloat($('#per_day').val()) || 0;
                var minimumCost = parseInt($('#minimum_cost').val()) || 0;
                
                var totalCost = perDay * numberOfDays;
                $('[data-plan="per_day_plan"]').attr('data-price',totalCost);
                $('[data-plan="per_day_plan"]').attr('data-days',numberOfDays);
                $('[name="selected_plan"]').val('per_day_plan');
                $('[name="30_days_cost"]').val(totalCost);
                $('[name="total_days"]').val(numberOfDays);
                if (totalCost <= 0) {
                    $('.total-cost').text('0.00');
                    $('.actions').addClass('d-none');
                    return;
                }

                $('.total-cost').text(totalCost.toFixed(2));
                if (totalCost < minimumCost) {
                    $('.actions').addClass('d-none');
                } else {
                    $('.actions').removeClass('d-none');
                }
            });
        }
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
