<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
         $this->call([
             BrandsTableSeeder::class,
             ProductSeeder::class,
             UserSeeder::class,
             NotaSeeder::class,
             OrderSeeder::class,
         ]);
    }
}
