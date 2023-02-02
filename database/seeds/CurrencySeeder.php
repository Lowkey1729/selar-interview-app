<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = $this->getCurrencies();
        $table = 'currencies';
        foreach ($currencies as $currency) {
            \Illuminate\Support\Facades\DB::table($table)->insert($currency);
        }


    }

    public function getCurrencies(): array
    {
        return [
            [
                'code' => 'NGN',
                'name' => 'Naira(NGN)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GHS',
                'name' => 'CEDIS(GHS)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'KES',
                'name' => 'Kenya Shillings(KES)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollars(USD)',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];
    }
}
