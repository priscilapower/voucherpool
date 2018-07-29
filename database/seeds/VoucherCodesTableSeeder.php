<?php

use Illuminate\Database\Seeder;

class VoucherCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('voucher_codes')->truncate();

        factory(App\VoucherCodes::class, 20)->create();
    }
}
