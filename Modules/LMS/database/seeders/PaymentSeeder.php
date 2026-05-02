<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\PaymentMethod;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $paymentMethods = [
            [
                'method_name' => 'Stripe',
                'slug' => 'stripe',
                'currency' => 'AUD',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-0kPLJgOe.png',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'Paypal',
                'slug' => 'paypal',
                'currency' => 'AUD',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-Dyu4GFdk.svg',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            // Regional gateways below are disabled by default for AU client.
            // Razorpay = India only (INR), Xendit = SEA only (IDR/PHP/etc.),
            // Paystack = Africa only (ZAR/NGN). Admin can enable later if needed.
            [
                'method_name' => 'Razorpay',
                'slug' => 'razorpay',
                'currency' => 'INR',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-7Djey1BX.png',
                'status' => 0,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'xendit',
                'slug' => 'xendit',
                'currency' => 'IDR',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-NAXoWT6H.png',
                'status' => 0,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'Paystack',
                'slug' => 'paystack',
                'currency' => 'ZAR',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-8tWnmaIX.png',
                'status' => 0,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'Offline',
                'slug' => 'offline',
                'currency' => 'AUD',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-OndMChdV.svg',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        ];

        foreach ($paymentMethods as $paymentMethod) {
            PaymentMethod::updateOrCreate(['method_name' => $paymentMethod['method_name']], $paymentMethod);
        }
    }
}
