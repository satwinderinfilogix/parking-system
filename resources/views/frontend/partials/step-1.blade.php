<section>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Building Name</label>
                <select name="building_name" class="form-control select2" id="buildingSelect" required>
                    <option value="" selected disabled>Select Building</option>
                    <option>Building 1</option>
                    <option>Building 2</option>
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
        const units = {
            "Building 1": ["Unit 101", "Unit 102", "Unit 103"],
            "Building 2": ["Unit 201", "Unit 202", "Unit 203"]
        };

        $('#buildingSelect').on('change', function() {
            const selectedBuilding = $(this).val();
            const $unitSelect = $('#unitSelect');

            // Clear previous units
            $unitSelect.empty().append('<option value="" selected disabled>Select Unit</option>');

            // Populate units based on the selected building
            if (units[selectedBuilding]) {
                units[selectedBuilding].forEach(unit => {
                    $unitSelect.append(`<option value="${unit}">${unit}</option>`);
                });
            }
        });
    })
</script>
