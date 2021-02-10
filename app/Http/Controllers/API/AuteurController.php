<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Auteur;

class AuteurController extends Controller
{


    public function __construct()
    {
        $this->middleware('myValidate:App\Auteur')->only('store', 'update');
    }
    public function index(){
        return Auteur::paginate(20);
    }

    public function store(Request $request)
    {
        $auteur = new Auteur([
          'lastName' => $request->get('lastName'),
          'firstName' => $request->get('firstName'),
          'nationality' => $request->get('nationality'),
          'birthDate' => $request->get('birthDate'),
        ]);
        $auteur->save();
        return Response()->json(['etat' => true]);
    }

    public function update(Request $request, $id)
    {
        $auteur = Auteur::findOrFail($id);

        $auteur->update($request->all());
        return Response()->json(['etat' => true]);

    }

    public function destroy($id)
    {
        $auteur = Auteur::findOrFail($id);

        $auteur->delete();

    }
}
