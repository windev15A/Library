<?php

namespace App\Http\Controllers\API;

use App\Adherent;
use App\Auteur;
use App\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Livre;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function searchLivre(Request $request)
    {
        $word = $request->get('words');
        if(is_numeric($word)){
            $livres = Livre::findOrFail($word);
        }else{
            $livres = Livre::where('titre', 'LIKE', '%' . $word . '%')->paginate(50);
        }
        return Response()->json(['livres' => $livres]);
    }

    public function searchAdherent(Request $request)
    {
        $name = $request->get('name');
        if(is_numeric($name)){
            $adherent = Adherent::findOrFail($name);

        }else{
            $adherent = Adherent::where('nomAd', 'LIKE', '%' . $name . '%')->get();
        }

        return $adherent;
    }
    public function getCategories(){
        return Categorie::all();
    }
    public function getAuteurs(){
        return Auteur::all();
    }

    public function getLivreByCat(Request $request){
        $cat = Categorie::find($request->get('cat'));
        $livres = $cat->livres()->paginate(5);
        foreach ($livres as $livre){
            $catId = $livre->categories->toArray();
        }

        return Response()->json(['livres' => $livres]);
    }
    public function getLivreByAuteur(Request $request){
        $auteur = Auteur::find($request->get('id'));
        $livres = $auteur->livres()->paginate(2);
        foreach ($livres as $livre){
            $catId = $livre->categories->toArray();
        }
        return Response()->json($livres);
    }

}
