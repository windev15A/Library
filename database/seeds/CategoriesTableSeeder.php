<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('categories')->delete();

        DB::table('categories')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'libCat' => 'Programmation',
                    'created_at' => '2020-04-13 18:09:14',
                    'updated_at' => '2020-04-13 18:09:14',
                ),
            1 =>
                array(
                    'id' => 2,
                    'libCat' => 'Sport',
                    'created_at' => '2020-04-13 18:09:14',
                    'updated_at' => '2020-04-13 18:09:14',
                ),
            2 =>
                array (
                    'id' => 3,
                    'libCat' => 'Histoire',
                    'created_at' => '2020-04-13 18:09:14',
                    'updated_at' => '2020-04-13 18:09:14',
                ),
            3 =>
                array (
                    'id' => 4,
                    'libCat' => 'Politique',
                    'created_at' => '2020-04-13 18:09:14',
                    'updated_at' => '2020-04-13 18:09:14',
                ),
        ));


    }
}
