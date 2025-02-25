@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center">Complete Your Payment</h1>
    <p class="text-center text-muted">Secure your subscription and unlock premium features.</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="payment-form">
                        <div id="card-element" class="form-control"></div>
                        <div id="card-errors" class="text-danger mt-2"></div>
                        <button id="submit-button" class="btn btn-primary mt-3">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#card-element");

    const form = document.getElementById("payment-form");
    const submitButton = document.getElementById("submit-button");

    form.addEventListener("submit", async (event) => {
        event.preventDefault();
        submitButton.disabled = true;

        const { paymentIntent, error } = await stripe.confirmCardPayment("{{ $clientSecret }}", {
            payment_method: {
                card: card,
            },
        });

        if (error) {
            document.getElementById("card-errors").textContent = error.message;
            submitButton.disabled = false;
        } else {
            fetch("{{ route('subscription.payment.success') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ payment_intent_id: paymentIntent.id })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                window.location.href = "{{ route('plans') }}";
            });
        }
    });
</script>
@endsection
