<?php

use Illuminate\Database\Seeder;

class SpecialOffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SpecialOffers::class, 5)->create();
    }
}
