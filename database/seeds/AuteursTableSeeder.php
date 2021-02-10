<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuteursTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('auteurs')->delete();
        DB::table('auteurs')->insert(array (
            0 =>
            array (
                'id' => 1,
                'lastName' => 'auteur',
                'firstName' => 'auteur',
                'nationality' => 'Francaise',
                'birthDate' => 1980,
                'created_at' => '2020-04-08 17:19:56',
                'updated_at' => '2020-04-08 17:20:21',
            ),
            1 =>
            array (
                'id' => 2,
                'lastName' => 'Kamal',
                'firstName' => 'Kamal',
                'nationality' => 'Marocaine',
                'birthDate' => 1950,
                'created_at' => '2020-04-13 13:01:09',
                'updated_at' => '2020-04-13 13:01:09',
            ),
        ));


    }
}
