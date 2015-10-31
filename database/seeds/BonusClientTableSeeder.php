<?php

use Illuminate\Database\Seeder;

class BonusClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\BonusClient::create(['client_id' => '13555', 'card_number' => '2621119110480']);
    }
}
