<?php

use Illuminate\Database\Seeder;

class IndictorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Indicator::class,5)->create();
    }
}
