$(function() {
    function submitParkingForm(){
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
            phone_number : $("#phone").val(),
            transaction_id : $("#transaction_id").val()
        };

        $('#processing').css('display', 'flex');

        $.ajax({
            url: '/api/create-parking',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            dataType: 'json',
            success: function(response) {
                if(response.success === true) {
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

                if(newIndex===3 && valid){
                    if(parseFloat($('#30_days_cost').val()) > 0){
                        $('.paying-amount').text($('#30_days_cost').val());
                        $('.actions').addClass('d-none');
                        $('.proceed-payment-btn').removeClass('d-none');
                    } else {
                        $('.actions').removeClass('d-none');
                        $('.proceed-payment-btn').addClass('d-none');
                        $('.payment-section').addClass('d-none');
                        $('.terms-and-conditions').removeClass('d-none');
                    }
                }

                return valid; // Proceed if valid
            }
            
            return true; // Allow moving backward without validation
        },
        onFinished: function(event, currentIndex) {
           submitParkingForm();
        }
    });
    
    $('#make-payment').on('click', function() {
        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                $('#card-errors').text(result.error.message);
            } else {
                $('#make-payment').attr('disabled', 'disabled');

                $.ajax({
                    url: `/api/process-payment`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        stripeToken: result.token.id,
                        amount: $('#30_days_cost').val(),
                    },
                    success: function(response) {
                        $('#make-payment').removeAttr('disabled');

                        if(response.success){
                            $('#transaction_id').val(response.transaction_id);
                            submitParkingForm();
                        } else {
                            alert('Failed to make payment!')
                        }
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        $('#make-payment').removeAttr('disabled');
                        alert(response.message);
                    }
                });
            }
        });
    });

    $('[aria-label="Pagination"] li:last a').html('Confirm')
});