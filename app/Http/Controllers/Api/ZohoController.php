<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ZohoController extends Controller
{
    private $owner_id = 807524000000432001;

    public function createAccount(Request $request)
    {

        $token = $this->getZohoAccessToken();

        $accountsUrl = env('ZOHO_API_DOMAIN');
        $url = $accountsUrl."/crm/v7/Accounts";


        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $token,
            "Content-Type" => "application/json",
            'Cookie'        => '_zcsr_tmp=c34e06dc-94a6-4ffc-a3e7-074ba22638ab; crmcsr=c34e06dc-94a6-4ffc-a3e7-074ba22638ab'
        ])->post($url, [
            "data" => [
                [

                    "Ownership" => "Private",
                    "Description" => "Design your own layouts that align your business processes precisely.",
                    "Rating" => "Active",
                    "Website" => "crm.zoho.com",
                    "Phone" => "988844559",
                    "Account_Name" => "Account_Name",
                ]
            ]
        ]);

        return $response->json();
    }

    public function createDeal(Request $request)
    {
        $token = $this->getZohoAccessToken();
        $accountsUrl = env('ZOHO_API_DOMAIN');

        $accesToken = Cache::get('zoho_access_token');
        $url = $accountsUrl . "/crm/v7/Deals";

        $data = [
            "data" => [
                [
                    "Owner" => [
                        "id" => $this->owner_id,
                    ],
                    "Account_Name" => [
                        "id" => $this->owner_id,
                    ],
                    "Contact_Name" => [
                        "id" => $this->owner_id,
                    ],
                    "Type"=> "New Business",
			        "Description" => "Design your own layouts that align your business processes precisely.
			         Assign them to profiles appropriately.",
                    "Deal_Name" => "Bearer " . $request->name,
                    "Stage" => $request->stage,
                ]
            ]
        ];

        $response = Http::withHeaders([
            "Authorization" => $accesToken,
            "Content-Type" => "application/json"
        ])->post($url, $data);

        return $response->json();
    }

    public function getZohoAccessToken()
    {
        $tokenData = Cache::get('zoho_access_token');

        if (!$tokenData) {
            $refresh_token = env('ZOHO_REFRESH_TOKEN');
            $clientId = env('ZOHO_CLIENT_ID');
            $clientSecret = env('ZOHO_CLIENT_SECRET');
            $accountsUrl = env('ZOHO_ACCOUNTS_URL');

            $response = Http::asForm()->post($accountsUrl."/oauth/v2/token", [
                "client_id" => $clientId,
                "client_secret" => $clientSecret,
                "refresh_token" => $refresh_token,
                "grant_type" => "refresh_token"
            ]);

            $tokenData = $response->json();
            Cache::put('zoho_access_token', $tokenData['access_token'], now()->addHours(1));
        }

        return $tokenData;
    }

}
