<?php

use Illuminate\Database\Seeder;

class LivresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('livres')->delete();
        
        \DB::table('livres')->insert(array (
            0 => 
            array (
                'id' => 2,
                'numISBN' => '987654201',
                'titre' => 'Python 3.0.5',
                'description' => 'Pratiquer python 3',
                'langueLivre' => 'Français',
                'annee' => 2018,
                'nbPage' => 150,
                'dateAchat' => '2019-02-01',
                'photo' => '1586775148.png',
                'auteur_id' => 2,
                'created_at' => '2020-04-13 12:52:28',
                'updated_at' => '2020-04-15 15:56:36',
            ),
            1 => 
            array (
                'id' => 3,
                'numISBN' => '524163987541',
                'titre' => 'React js',
                'description' => 'Programmer avec React',
                'langueLivre' => 'Anglais',
                'annee' => 2019,
                'nbPage' => 850,
                'dateAchat' => '2020-01-01',
                'photo' => '1586775226.jpeg',
                'auteur_id' => 1,
                'created_at' => '2020-04-13 12:53:46',
                'updated_at' => '2020-04-13 12:53:46',
            ),
        ));
        
        
    }
}