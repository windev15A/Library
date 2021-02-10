<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function doPayment(Request $request){
       $price = $request->get('amount');
       $tokenStrip = $request->get('tokenId');

       Stripe::setApiKey(env("STRIPE_SECRET"));
        try {
            Charge::create([
                "amount" => $price,
                "currency" => "eur",
                "source" => $tokenStrip,
                "description" => "Test laravel payment"
            ]);
        } catch (ApiErrorException $e) {
            return response()->json(["error2" => $e],401);
        }
        return response()->json(['success' => 'Payment successful!'], 200);
    }
}
