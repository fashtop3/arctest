<?php

namespace App\Http\Controllers;

use App\Service;
use App\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use  App\User;

class SubscriptionController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'/*, ['except' => ['callback']]*/);
    }

    /**
     * Get user subscribed plans
     * @return mixed
     */
    public function index()
    {
        $subs = Subscription::where("user_id", Auth::user()->id)->get();
        return response()->json($subs, 200);
    }

    /**
     * Do a service subscription
     * @return mixed
     */
    public function initTransaction(Request $request)
    {
        //validate request parameters
        $this->validate($request, [
            'service_id' => 'integer|required|exists:services,id'
        ]);

        $service = Service::find($request->input('service_id'));//->get();

        $result = array();
        //Set other parameters as keys in the $postdata array
        $postdata = array(
            "email" => Auth::user()->email,
            'amount' => $service->price,
            'reference' => uniqid(),
            "plan" => $service->plan,
            'callback_url' => 'http://192.168.99.100/api/subscriptions/callback?service_id=2'
        );
        $url = "https://api.paystack.co/transaction/initialize";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            "authorization: Bearer " . getenv('PAYSTACK_SEC'),
            'Content-Type: application/json',

        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec($ch);

        curl_close($ch);

        if ($request) {
            $result = json_decode($request, true);
        }
        return response()->json($result, 200);
    }

    /**
     * Handle subscription validation
     * @param Request $request
     * @return mixed
     */
    public function callback(Request $request)
    {

        //validate request parameters
        $this->validate($request, [
            'trxref' => 'string|required|max:50',
            'service_id' => 'integer|required|exists:services,id'
        ]);

        $curl = curl_init();
        $reference = $request->get('trxref');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . getenv('PAYSTACK_SEC'),
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the Paystack API
            return response()->json(array("status" => false, "message" => 'Curl returned error: ' . $err), 400);
        }

        $tranx = json_decode($response);


        if (!$tranx->status) {
            // there was an error from the API
            return response()->json(["status" => false, "message" => 'API returned error: ' . $tranx->message], 400);
        }

        if ('success' == $tranx->data->status) {
            // transaction was successful...
            // create an entry for recurring subscription
            $recur_sub = [
                "reference_id" => $tranx->data->reference,
                "user_id" => Auth::user()->id,
                "service_id" => $request->get('service_id'),
                "auth_token" => $tranx->data->authorization->authorization_code,
                "price" => $tranx->data->amount
            ];

            $subscription = Subscription::firstOrCreate($recur_sub);

            return response()->json($subscription, 200);
        }

        return response()->json(array("status" => false, "message" => "Transaction failed"), 200);
    }
}
