<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdherentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('adherents')->delete();

        DB::table('adherents')->insert(array (
            0 =>
            array (
                'id' => 1,
                'nomAd' => 'mostafa',
                'prenomAd' => 'mostafa',
                'adressAd' => '6 rue de la ville',
                'cpAd' => '78500',
                'villeAd' => 'paris',
                'emailAd' => 'ad@live.fr',
                'password' => '$2y$10$Q/MBgLW0iiDoJL5wJ1amQevSrc0OkZKOXWJzmZWGmZGNkOEzepRre',
                'profession' => 'Informaticien',
                'created_at' => '2020-04-13 11:14:55',
                'updated_at' => '2020-04-13 11:14:55',
            ),
            1 =>
            array (
                'id' => 2,
                'nomAd' => 'heloo',
                'prenomAd' => 'heloo',
                'adressAd' => '8 rue de la ville',
                'cpAd' => '45800',
                'villeAd' => 'Houdan',
                'emailAd' => 'heloo@live.fr',
                'password' => '$2y$10$lSQ0PEJM1gAeE3B8MqcC0eqpEDYh4xSMBtc/3Ec9fjrbETtorAh7i',
                'profession' => 'plombier',
                'created_at' => '2020-04-13 13:16:34',
                'updated_at' => '2020-04-13 13:16:34',
            ),
        ));


    }
}
