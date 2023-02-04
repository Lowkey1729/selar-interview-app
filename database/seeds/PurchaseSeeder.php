<?php

use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::query()->chunk(100, function ($users) {
            foreach ($users as $user) {
                $user->products()->save(factory(\App\Purchase::class)->make());
            }
        });
    }
}
