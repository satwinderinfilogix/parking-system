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
</section>


<script>
    $(function() {
        $(document).on('click', '.plan-container:not(.bg-dark-subtle)', function() {
            $('[name="selected_plan"]').val($(this).attr('data-plan'));
            $('[name="30_days_cost"]').val($(this).attr('data-price'));
            $('.actions').removeClass('d-none');
            $('.proceed-payment-btn').addClass('d-none');
            $('.payment-section').addClass('d-none');
            $('.terms-and-conditions').removeClass('d-none');

            $('.plan-container').removeClass('bg-primary text-white').addClass('bg-primary-subtle');
            $(this).toggleClass('bg-primary-subtle bg-primary text-white');
            $('.actions').removeClass('d-none');
        });

        $('.first').click(function() {
            $('.actions').removeClass('d-none');
        })
    })
</script>
