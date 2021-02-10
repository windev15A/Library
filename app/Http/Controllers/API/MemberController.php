<?php

namespace App\Http\Controllers\API;

use App\Adherent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{

    public function login(Request $request)
    {
        $this->validate($request, [
            'emailAd' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('adherent')->attempt(['emailAd' => $request->emailAd, 'password' => $request->password])) {
            $adherent = Auth::guard('adherent')->user();
            $success['token'] = $adherent->createToken('MemberToken')->accessToken;
            return response()->json(['success' => $success, 'member' => $adherent], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nomAd' => 'required|max:60|min:4',
            'emailAd' => 'required|email|unique:adherents',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $adherent = new Adherent();
        $adherent->nomAd = $request->input('nomAd');
        $adherent->emailAd = $request->input('emailAd');
        $adherent->password = bcrypt($request->input('password'));

        $adherent->save();

        return response()->json(['success' => 'Adherent enregistrée avec succès'], 200);
    }

    public function logout()
    {
        if (Auth::guard('adherent-api')->check()) {
            Auth::guard('adherent-api')->user()->token()->revoke();
        }
        return response()->json(['success' => 'Vous êtes maintenant déconnecté'], 200);
    }

    public function getMember()
    {
        $adherent = Auth::guard('adherent-api')->user();
        return response()->json(['success' => $adherent, 'etat' => 'true'], 200);
    }
}
