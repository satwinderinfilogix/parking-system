<section>
    <div class="row">
        <div class="col-lg-6">
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
                        <h4>$20.00</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="selected_plan">
</section>


<script>
    $(function(){
        $('.plan-container').click(function(){
            $('[name="selected_plan"]').val($(this).attr('data-plan'));

            $('.plan-container').removeClass('bg-primary text-white').addClass('bg-primary-subtle');
            $(this).toggleClass('bg-primary-subtle bg-primary text-white');
            $('.actions').removeClass('d-none');
        })
    })
</script>