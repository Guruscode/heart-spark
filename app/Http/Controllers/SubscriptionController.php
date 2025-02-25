<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        // Set your Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Show the subscription plans page.
     */
    public function showPlans()
    {
        return view('subscription.plans');
    }

    // Show payment form
    public function showPaymentForm(Request $request)
    {
        $planId = $request->query('plan_id');
        if (!$planId) {
            return redirect()->route('plans')->with('error', 'Invalid plan selection.');
        }

        $user = Auth::user();

        // Ensure the user has a Stripe Customer ID
        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $user->email,
                'name' => $user->name,
            ]);
            $user->update(['stripe_customer_id' => $customer->id]);
        }

        // Retrieve subscription details
        $subscriptionDetails = $this->getSubscriptionDetails($planId);
        if (!$subscriptionDetails) {
            return redirect()->route('plans')->with('error', 'Invalid subscription plan.');
        }

        // Create PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => $subscriptionDetails['price'] * 100, // Convert to cents
            'currency' => 'usd',
            'customer' => $user->stripe_customer_id,
            'metadata' => [
                'plan_id' => $planId,
                'user_id' => $user->id,
            ],
        ]);

        return view('subscription.payment', [
            'clientSecret' => $paymentIntent->client_secret,
            'planId' => $planId,
        ]);
    }

    public function handlePaymentSuccess(Request $request)
    {
        $user = Auth::user();

        // Update user subscription status
        $user->update([
            'subscription' => true,
            'payment_reference' => $request->payment_intent_id,
        ]);

        return response()->json(['message' => 'Subscription successful!']);
    }

    private function getSubscriptionDetails($planId)
    {
        $plans = [
            'price_premium_plan_id' => ['type' => 'premium', 'price' => 9.99, 'duration' => 30],
            'price_vip_plan_id' => ['type' => 'vip', 'price' => 19.99, 'duration' => 30],
        ];

        return $plans[$planId] ?? null;
    }
}
