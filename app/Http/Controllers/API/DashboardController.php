<?php

namespace App\Http\Controllers\API;

use App\Auteur;
use App\Categorie;
use App\Http\Controllers\Controller;
use App\Livre;
use App\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getStatistic(){

        $users = User::count();
        $livres  = Livre::count();
        $categories  = Categorie::count();
        $auteurs  = Auteur::count();
        $adherents = DB::table('adherents')
            ->limit(5)
            ->get();
        return Response()->json(
            [   
                'users'     =>  $users,
                'livres'    =>  $livres,
                'categorie' =>  $categories,
                'adherents' =>  $adherents,
                'auteurs'   =>  $auteurs,
            ]
        );
    }
}
