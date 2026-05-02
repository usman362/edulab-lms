<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            // Primary currency for ACE Academic (Australian client) — seeded enabled.
            [
                'name' => 'aud',
                'code' => 'AUD',
                'symbol' => 'A$',
                'exchange_rate' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'usd',
                'code' => 'USD',
                'symbol' => '$',
                'exchange_rate' => null,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'eur',
                'code' => 'EUR',
                'symbol' => '€',
                'exchange_rate' => null,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'gbp',
                'code' => 'GBP',
                'symbol' => '£',
                'exchange_rate' => null,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'nzd',
                'code' => 'NZD',
                'symbol' => 'NZ$',
                'exchange_rate' => null,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($currencies as $currency) {
            Currency::updateOrCreate(['name' => $currency['name']], $currency);
        }
    }
}
