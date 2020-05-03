<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $faker = Faker\Factory::create();
         for ($i = 0; $i < 10; $i++) {
             
             $user=User::create([
                    'name'=>$faker->name,
                    'email'=>$faker->email,
                    "phone"=>$faker->tollFreePhoneNumber,
                    "profile_image"=>"http://via.placeholder.com/150x150",
                    "password"=>Hash::make("12345678"),
                    "remember_token"=>str_random(10)
               ]);

            
           }
    }
}
