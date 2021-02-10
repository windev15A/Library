<?php

namespace App\Http\Controllers\API;

use App\Adherent;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AdherentController extends Controller
{

    public function __construct()
    {
        $this->middleware('myValidate:App\Adherent')->only('store', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Adherent[]|Collection
     */
    public function index()
    {
        return Adherent::paginate(25);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $adherent = new Adherent([
            'nomAd' => $request->get('nomAd'),
            'prenomAd' => $request->get('prenomAd'),
            'adressAd' => $request->get('adressAd'),
            'cpAd' => $request->get('cpAd'),
            'villeAd' => $request->get('villeAd'),
            'emailAd' => $request->get('emailAd'),
            'profession' => $request->get('profession'),
        ]);
        $adherent->password = bcrypt('12345678');

        $adherent->save();
        return Response()->json(['etat' => true]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $adherent = Adherent::findOrFail($id);
        $adherent->nomAd = $request->get('nomAd');
        $adherent->prenomAd = $request->get('prenomAd');
        $adherent->adressAd = $request->get('adressAd');
        $adherent->cpAd = $request->get('cpAd');
        $adherent->villeAd = $request->get('villeAd');
        $adherent->emailAd = $request->get('emailAd');
        $adherent->profession = $request->get('profession');
        $adherent->update();
        return Response()->json(['message'=>'Adhérent modifié avec succès','etat' => true]);
    }

    public function destroy(Adherent $adherent)
    {
        $adherent->delete();
    }
}
