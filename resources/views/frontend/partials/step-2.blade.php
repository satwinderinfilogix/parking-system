<section>
    <div class="row" id="plans-list">
        {{--<div class="col-lg-6">
            <div class="mb-3">
                <div class="card shadow-sm bg-primary-subtle plan-container" data-plan="3days">
                    <div class="card-body">
                        <h5>3 Days Parking</h5>
                        <h4>Free</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <div class="card shadow-sm bg-primary-subtle plan-container" data-plan="30days">
                    <div class="card-body">
                        <h5>30 Days Parking</h5>
                        <h4 class="monthlyPlanCost">$20.00</h4>
                    </div>
                </div>
            </div>
        </div>--}}
    </div>

    <input type="hidden" name="selected_plan" id="selected_plan">
    <input type="hidden" name="30_days_cost" id="30_days_cost">
    <input type="hidden" name="total_days" id="total_days">
</section>


<script>
    $(function() {
        $(document).on('click', '.plan-container:not(.bg-dark-subtle)', function() {
            var dataPlan = $(this).attr('data-plan');
            $('[name="selected_plan"]').val(dataPlan);
            $('[name="30_days_cost"]').val($(this).attr('data-price'));
            $('[name="total_days"]').val($(this).attr('data-days'));
            $('.actions').removeClass('d-none');
            $('.proceed-payment-btn').addClass('d-none');
            $('.payment-section').addClass('d-none');
            $('.terms-and-conditions').removeClass('d-none');

            $('.plan-container').removeClass('bg-primary text-white').addClass('bg-primary-subtle');
            $(this).toggleClass('bg-primary-subtle bg-primary text-white');
            $('.actions').removeClass('d-none');
            var numberOfDays =parseInt($('[name="number_of_days"]').val()) || 0;
            if(dataPlan == "per_day_plan"){
                $('.actions').addClass('d-none');
                var perDay = parseFloat($('#per_day').val()) || 0;
                var minimumCost = parseInt($('#minimum_cost').val()) || 0;
                
                var totalCost = perDay * numberOfDays;

                if (totalCost <= 0) {
                    $('.actions').addClass('d-none');
                }

                if (totalCost < minimumCost) {
                    $('.actions').addClass('d-none');
                } else {
                    $('.actions').removeClass('d-none');
                }
            }
        });

        $('.first').click(function() {
            $('.actions').removeClass('d-none');
        });
        
    })
</script>
