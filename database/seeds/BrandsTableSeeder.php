<?php

use Illuminate\Database\Seeder;
use App\Brand;

class BrandsTableSeeder extends Seeder
{
    
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range (1,10) as $i){
            Brand::create([
                'name' => $faker->name,
                'description' => $faker->name,
            ]);
    }
}
}
