$(function() {
    const units = {
        "Building 1": {
            "Unit 101": "Code101",
            "Unit 102": "Code102",
            "Unit 103": "Code103"
        },
        "Building 2": {
            "Unit 201": "Code201",
            "Unit 202": "Code202",
            "Unit 203": "Code203"
        }
    };


    $("#basic-example").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        onStepChanging: function(event, currentIndex, newIndex) {
            // Allow skipping the validation for the last step
            if (currentIndex < newIndex) {
                // Validate current step
                const $currentForm = $(this).find("section").eq(currentIndex);
                let valid = true;
                
                $currentForm.find("input:visible, select:visible").each(function() {
                    if ($(this).prop("required") && !$(this).val()) {
                        valid = false;
                        if($(this).hasClass('select2')){
                            $(this).parent().find('.select2-selection').css({'border': '1px solid #f46a6a'});
                        }

                        $(this).addClass("is-invalid");
                    } else {
                        if($(this).hasClass('select2')){
                            $(this).parent().find('.select2-selection').removeAttr('style');
                        }

                        $(this).removeClass("is-invalid");
                    }
                });

                if(currentIndex===0){
                    // check if security code is matched
                    const building = $currentForm.find("#buildingSelect").val();
                    const unit = $currentForm.find("#unitSelect").val();
                    const securityCode = $currentForm.find("#securityCode").val();

                    if (building && unit && securityCode) {
                        const expectedCode = units[building][unit];
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

                return valid; // Proceed if valid
            }
            
            return true; // Allow moving backward without validation
        },
        onFinished: function(event, currentIndex) {
            alert("Form submitted!");
            // Here you can add form submission logic
        }
    });
});