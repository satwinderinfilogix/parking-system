<section>
    <div class="row d-none" id="prev-vehicle-history-buttons">
        <div class="col-lg-6">
            <div class="mb-3">
                <button class="btn btn-primary w-100" id="saved-vehicles-btn" data-bs-toggle="modal"
                    data-bs-target="#savedVehiclesModal">
                    Choose from previous history
                </button>
            </div>
        </div>

        <div class="col-lg-6 add-new-vehicle-btn">
            <div class="mb-3">
                <button class="btn btn-primary w-100 add-new-vehicle">
                    Add New
                </button>
            </div>
        </div>
    </div>

    <div class="vehicle-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3 datepicker-container">
                    <label for="start-date">Date Start</label>
                    <div class="input-group" id="startDate">
                        <input type="text" class="form-control" id="start-date" placeholder="YYYY-MM-DD" required
                            data-date-format="yyyy-mm-dd" data-date-container='#startDate' data-provide="datepicker"
                            data-date-autoclose="true">

                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                    </div>
                    <span class="invalid-feedback">Please enter a valid date.</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="brand">Car brand</label>
                    <input type="text" class="form-control" id="brand" placeholder="Enter Vehicle Brand"
                        required>
                    <span class="invalid-feedback">Please select a car brand.</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" placeholder="Enter Model" required>
                    <span class="invalid-feedback">Please enter a valid model number.</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="color">Color</label>
                    <input type="text" class="form-control" id="color" placeholder="Enter Vehicle Color"
                        required>
                    <span class="invalid-feedback">Please enter a color.</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="license-plate">License Plate</label>
                    <input type="text" class="form-control" id="license-plate" placeholder="Enter License Plate"
                        required>
                    <span class="invalid-feedback">Please enter a valid license plate.</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="confirmation-method">Receive Confirmation By:</label>
                    <select class="form-control" id="confirmation-method" required>
                        <option value="" selected disabled>Select Source</option>
                        <option value="Email">Email</option>
                        <option value="Text">Text</option>
                    </select>
                    <span class="invalid-feedback">Please select a confirmation method.</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6" id="email-input" style="display: none;">
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter Email" required>
                    <span class="invalid-feedback">Please enter a valid email address.</span>
                </div>
            </div>
            <div class="col-lg-6" id="phone-input" style="display: none;">
                <div class="mb-3">
                    <label for="phone">Phone Number</label>
                    <input type="number" class="form-control" id="phone" placeholder="Enter Phone Number" required>
                    <span class="invalid-feedback">Please enter a valid phone number.</span>
                </div>
                @if(isset($disclaimer))
                <div class="mb-3">
                    <p>
                        <b>Disclaimer:</b> {!! $disclaimer !!}
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="savedVehiclesModal" tabindex="-1" aria-labelledby="savedVehiclesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="savedVehiclesModalLabel">Saved Vehicles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>License Plate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="prev-vehicles-history"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add-new-vehicle">Add new vehicle</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        let today = new Date();
        $('#start-date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: today // Disable past dates
        });

        $('.add-new-vehicle').click(function() {
            $('.add-new-vehicle-btn').addClass('d-none');
            $('.vehicle-form').removeClass('d-none');
            $('.actions').removeClass('d-none');

            $('#brand').val(``);
            $('#model').val(``);
            $('#color').val(``);
            $('#license-plate').val(``);
            $('#email').val(``);
            $('#phone').val(``);
        })

        $(document).on('click', '.use-vehicle', function(event) {
            const vehicleData = $(this).parents('[data-vehicle]').attr('data-vehicle');
            const vehicle = JSON.parse(decodeURIComponent(vehicleData));
            
            $('#brand').val(vehicle.car_brand);
            $('#model').val(vehicle.model);
            $('#color').val(vehicle.color);
            $('#license-plate').val(vehicle.license_plate);

            if(vehicle.email){
                $('#email-input').show();
                $('#email').val(vehicle.email);
                $('#confirmation-method').val('Email');
            } else {
                $('#phone-input').show();
                $('#phone').val(vehicle.phone_number);
                $('#confirmation-method').val('Text');
            }

            $('#savedVehiclesModal').modal('hide')
            $('.vehicle-form').removeClass('d-none');
            $('.actions').removeClass('d-none');
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
</script>
