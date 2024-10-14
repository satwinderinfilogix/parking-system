<section>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="terms-and-conditions">
                <h4 class="text-center">Terms and Conditions for Guest Parking</h4>
                <p class="text-center">By submitting this form, you agree to the following terms and conditions:</p>
                <ol class="fs-5">
                    <li class="mb-1"><strong>Eligibility:</strong> You confirm that you are a guest of the
                        building/property and authorized to use
                        the parking facilities.</li>
                    <li class="mb-1"><strong>Parking Duration:</strong> You may select between a 3-day or a 30-day
                        parking period.</li>
                    <li class="mb-1"><strong>Information Accuracy:</strong> You agree to provide accurate and truthful
                        information.</li>
                    <li class="mb-1"><strong>Confirmation and Payment:</strong> Upon selecting the 30-day parking
                        option, you agree to process
                        your payment.</li>
                    <li class="mb-1"><strong>Cancellation and Changes:</strong> Management reserves the right to
                        cancel
                        parking requests.</li>
                    <li class="mb-1"><strong>Liability:</strong> The building/property management is not responsible
                        for any loss, theft, or
                        damage to your vehicle.</li>
                    <li class="mb-1"><strong>Privacy Policy:</strong> Your personal information will be collected in
                        accordance with our Privacy
                        Policy.</li>
                    <li><strong>Agreement:</strong> By clicking "Accept," you confirm that you have read and understood
                        these terms.
                    </li>
                </ol>

                <div class="proceed-payment-btn d-none">
                    <button class="btn btn-primary continue-payment">Confirm & Continue</button>
                </div>
            </div>

            <div class="payment-section d-none">
                <div>
                    <label for="card-element"><b>Pay $<span class="paying-amount"></span></b></label><br/>
                    <label for="card-element">Credit or debit card:</label>
                    <div id="card-element"></div>
                    <div id="card-errors" class="text-danger" role="alert"></div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary" id="make-payment">Proceed</button>
                </div>
            </div>

            <input type="hidden" name="transaction_id" id="transaction_id">

            {{-- <div class="form-check mb-3 ms-3">
                <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                <label class="form-check-label" for="agreeTerms">
                    I have read and agree to the Terms and Conditions.
                </label>
            </div> --}}
        </div>
    </div>
</section>

<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();

    var checkoutStyle = {
        base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            lineHeight: "24px",
            padding: "10px",
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var cardElement = elements.create('card', {
        hidePostalCode: true,
        style: checkoutStyle
    });

    cardElement.mount('#card-element');

    cardElement.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    $('.continue-payment').click(function() {
        $('.terms-and-conditions').addClass('d-none');
        $('.payment-section').removeClass('d-none');
    });
</script>

{{-- <script>
    $(function(){
        $('#agreeTerms').change(function() {
            if ($(this).is(':checked')) {
                $('[href="#finish"]').parent().removeClass('disabled');
            } else {
                $('[href="#finish"]').parent().addClass('disabled');
            }
        });
    });
</script> --}}
