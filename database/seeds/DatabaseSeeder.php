<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(LivresTableSeeder::class);
        $this->call(AdherentsTableSeeder::class);
        $this->call(AuteursTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
