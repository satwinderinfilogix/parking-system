<section>
    <div>
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
                    <span class="invalid-feedback">Please enter a valid model number.</span>
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
                    <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number" required>
                    <span class="invalid-feedback">Please enter a valid phone number.</span>
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
