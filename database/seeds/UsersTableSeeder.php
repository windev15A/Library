<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->delete();

        DB::table('users')->insert(array (
            0 =>
            array (
                'created_at' => NULL,
                'deleted_at' => NULL,
                'email' => 'admin@live.fr',
                'email_verified_at' => NULL,
                'id' => 1,
                'isAdmin' => 1,
                'name' => 'Abdellah',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
                array (
                    'created_at' => NULL,
                    'deleted_at' => NULL,
                    'email' => 'user@live.fr',
                    'email_verified_at' => NULL,
                    'id' => 1,
                    'isAdmin' =>0,
                    'name' => 'User',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'remember_token' => NULL,
                    'updated_at' => NULL,
                ),
        ));


    }
}
