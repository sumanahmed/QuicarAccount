<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Year;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($i=1990; $i<=2025;$i++) {
    		Year::create([
	            'name' => $i
	        ]);
    	}
        
    }
}
