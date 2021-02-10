<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categorie;


class CategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Categorie[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Categorie::paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $categorie = new Categorie([
          'libCat' => $request->get('libCat')
        ]);
        $categorie->save();
        return Response()->json(['etat' => true]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $categorie->update($request->all());
        return Response()->json(['etat' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string[]
     */
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->livres()->detach();
        $categorie->delete();
        return ['message' => 'Catégorie supprimé'];
    }
}
