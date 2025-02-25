<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('subscription_started_at')->nullable()->after('paid');
            $table->dateTime('subscription_expires_at')->nullable()->after('subscription_started_at');
            $table->string('payment_provider')->nullable()->after('subscription_expires_at'); // Stripe, PayPal, etc.
            $table->string('payment_reference')->nullable()->after('payment_provider'); // Transaction ID
            $table->string('plan_id')->nullable()->after('payment_reference'); // Subscription Plan ID
            $table->boolean('auto_renew')->default(true)->after('plan_id'); // Auto-renewal option
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                
                'subscription_started_at',
                'subscription_expires_at',
                'payment_provider',
                'payment_reference',
                'plan_id',
                'auto_renew',
             
            ]);
        });
    }
};
