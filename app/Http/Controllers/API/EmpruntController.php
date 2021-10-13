<?php

namespace App\Http\Controllers\API;

use App\Adherent;
use App\Http\Controllers\Controller;
use App\Livre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class EmpruntController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $emprunt
     * @return JsonResponse|Response
     */
    public function index()
    {
        $adherents = Adherent::whereHas('livres')->paginate(30);
        foreach ($adherents as $adherent) {
            $adherent->livres;
        }
        return Response()->json(['books' => $adherents]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $adherent = Adherent::find($request->get('adherent')['id']);
        $count = $adherent->livres()->count();
        $hasLivre = DB::table('adherent_livre')->where('adherent_id', $request->get('adherent')['id'])
            ->where('livre_id', $request->get('livre')['id'])
            ->where('deleted_at', null)
            ->exists();

        if ($count >= 3 || $hasLivre) {
            return Response()->json(['etat' => false]);
        }
        $adherent->livres()->attach($request->get('livre')['id'], [
            'dateDebut' => $request->get('dateDebut'),
            'dateFin' => $request->get('dateFin'),
            'rendu' => $request->get('rendu'),
        ]);
        return Response()->json(['etat' => true]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {

        $adherent = Adherent::find($id);

        $adherent->livres()->updateExistingPivot($request->get('livre_id'), [
            'dateDebut' => $request->get('dateDebut'),
            'dateFin' => $request->get('dateFin'),
            'rendu' => $request->get('rendu'),
        ]);
        return Response()->json(['etat' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {

        $key = \request()->input('0');
        $adherent = Adherent::find($id);
        $adherent->livres()->updateExistingPivot($key, [
            'deleted_at' => DB::raw('NOW()'),
            'rendu' => 1,
        ]);
        return Response()->json(['etat' => true]);
    }

    public function getArchives($id)
    {

        $livres = array();
        $archives = DB::table('adherent_livre')->where('adherent_id',$id)
                    ->whereNotNull('deleted_at')->get();
        foreach ($archives as $archive){
            $livres[]= ['book'=>Livre::find($archive->livre_id), 'info'=>$archive] ;
        }

        return Response()->json(['archives' => $livres]);
    }


}
