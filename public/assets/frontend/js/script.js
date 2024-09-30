$(function() {
    $("#book-parking-form").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        onStepChanging: function(event, currentIndex, newIndex) {
            // Allow skipping the validation for the last step
            if (currentIndex < newIndex) {
                // Validate current step
                const $currentForm = $(this).find("section").eq(currentIndex);
                let valid = true;
                let invalidInputs = 0;
                
                $currentForm.find("input:visible, select:visible").each(function() {
                    if ($(this).prop("required") && !$(this).val()) {
                        invalidInputs++;
                        valid = false;
                        if($(this).hasClass('select2')){
                            $(this).parent().find('.select2-selection').css({'border': '1px solid #f46a6a'});
                        }

                        if($(this).attr('data-provide')=='datepicker'){
                            $(this).parents('.datepicker-container').find('.invalid-feedback').show();
                        }

                        $(this).addClass("is-invalid");
                    } else {
                        valid = true;
                        if($(this).hasClass('select2')){
                            $(this).parent().find('.select2-selection').removeAttr('style');
                        }

                        if($(this).attr('data-provide')=='datepicker'){
                            $(this).parents('.datepicker-container').find('.invalid-feedback').hide();
                        }
                        
                        $(this).removeClass("is-invalid");
                    }
                });

                if(invalidInputs > 0){
                    valid = false;
                }

                if(currentIndex===0){
                    // check if security code is matched
                    const building = $currentForm.find("#buildingSelect").val();
                    const unit = $currentForm.find("#unitSelect").val();
                    const securityCode = $currentForm.find("#securityCode").val();

                    if (building && unit && securityCode) {
                        const selectedUnitOption = $currentForm.find("#unitSelect option:selected");
                        const expectedCode = selectedUnitOption.data('password').toString(); // Correctly retrieve the data-password attribute
                        if (securityCode !== expectedCode) {
                            valid = false;
                            alert("Invalid security code. Please try again.");
                            $currentForm.find("#securityCode").addClass("is-invalid");
                        } else {
                            valid = true;
                            $currentForm.find("#securityCode").removeClass("is-invalid");
                            
                            if(!$('[name="selected_plan"]').val()){
                                $('.actions').addClass('d-none');
                            }
                        }
                    } else {
                        valid = false;
                    }
                }

                if(currentIndex===1 && !$('.vehicle-form').hasClass('d-none')){
                    $('.actions').removeClass('d-none');
                } else if(currentIndex===1){
                    $('.actions').addClass('d-none');
                }

                /* if(currentIndex===3){
                    if($('#agreeTerms:checked').length > 0){
                        valid = true;
                        $('[href="#finish"]').parent().removeClass('disabled');
                    } else {
                        valid = false;
                        $('[href="#finish"]').parent().addClass('disabled');
                    }
                } */
                
                return valid; // Proceed if valid
            }
            
            return true; // Allow moving backward without validation
        },
        onFinished: function(event, currentIndex) {
            /* if(currentIndex===3){
                if($('#agreeTerms:checked').length > 0){
                    $('[href="#finish"]').parent().removeClass('disabled');
                } else {
                    $('[href="#finish"]').parent().addClass('disabled');
                    return false;
                }
            } */

            const formData = {
                building_id: $("#buildingSelect").val(),
                unit_id: $("#unitSelect").val(),
                securityCode: $("#securityCode").val(),
                plan: $('[name="selected_plan"]').val(),
                startDate: $("#start-date").val(),
                brand: $("#brand").val(),
                model: $("#model").val(),
                color: $("#color").val(),
                licensePlate: $("#license-plate").val(),
                confirmationMethod: $("#confirmation-method").val(),
                email: $("#email").val(),
                phone_number : $("#phone").val()
            };

            $('#processing').css('display', 'flex');

            $.ajax({
                url: '/api/create-parking',
                type: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(formData),
                dataType: 'json',
                success: function(response) {
                    if(response.success == true) {
                        $('#processing i').attr('class','mdi mdi-check-all fs-1 text-success');
                        $('#processing p').html('Form has been submitted successfully! Please reload the page to book a new parking...');
                        window.location = `parking-booked/${response.parkingId}`;
                    } else {
                        $('#processing').css('display', 'none');
                        alert('Something went wrong!')
                    }
                }
            });
        }
    });

    $('[aria-label="Pagination"] li:last a').html('Confirm')
});