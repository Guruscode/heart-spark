@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Choose Your Subscription Plan</h1>
    <p class="text-center text-muted">Unlock premium features and enhance your experience.</p>
    
    <div class="row justify-content-center">
        <!-- Free Plan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-light text-center">
                <div class="card-body">
                    <h5 class="card-title">Free Plan</h5>
                    <p class="text-muted">Limited likes & ads included.</p>
                    <h3 class="fw-bold">Free</h3>
                    <button class="btn btn-outline-secondary" disabled>Current Plan</button>
                </div>
            </div>
        </div>

        <!-- Premium Plan -->
        <div class="col-md-4">
            <div class="card shadow-lg border-primary text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary">Premium Plan</h5>
                    <p class="text-muted">Unlimited likes, no ads, message more people.</p>
                    <h3 class="fw-bold">$9.99 <small class="text-muted">/ month</small></h3>
                    <a href="{{ route('payment.form', ['plan_id' => 'price_premium_plan_id']) }}" class="btn btn-primary">Get Premium</a>
                </div>
            </div>
        </div>

        <!-- VIP Plan -->
        <div class="col-md-4">
            <div class="card shadow-lg border-warning text-center">
                <div class="card-body">
                    <h5 class="card-title text-warning">VIP Plan</h5>
                    <p class="text-muted">Everything in Premium + profile boost & priority support.</p>
                    <h3 class="fw-bold">$19.99 <small class="text-muted">/ month</small></h3>
                    <a href="{{ route('payment.form', ['plan_id' => 'price_vip_plan_id']) }}" class="btn btn-warning">Get VIP</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
