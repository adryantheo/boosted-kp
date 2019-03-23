<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    
    public function run()
    {
        $faker = Faker\Factory::create();

       
           User::create([
               'name' => $faker->name,
               'email' => $faker->email,
               'password' => 'secret',

           ]);
       
    }
}
