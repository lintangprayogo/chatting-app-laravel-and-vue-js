<?php

use Illuminate\Database\Seeder;
use App\Message;
use App\User;
class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           $faker = Faker\Factory::create();

           $users= User::limit(15)->get();
          for ($i = 0; $i < 300; $i++) {
               $from;
               $to;
               do{
                 $from=$users[rand(0,(count($users)-1))];
                 $to=$users[rand(1,(count($users)-1))] ;
               }while ( $from==$to );



             $user=Message::create([
                    'from'=>$from->id,
                    'to'=>$to->id,
                    'text'=>$faker->sentence, 
               ]);

            
           }
    }
}
