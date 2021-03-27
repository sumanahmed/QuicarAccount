<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\CarType;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$car_types = ['Sedan','SUV','Microbus','Minibus','Bus','Pickup','Ambulance'];

    	foreach ($car_types as $value) {
    		CarType::create([
	            'name' => $value
	        ]);
    	}
    }
}
