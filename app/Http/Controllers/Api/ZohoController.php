<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\StoreDealRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ZohoController extends Controller
{
    protected $apiDomain;
    protected $apiAccessToken;

    public function __construct()
    {
        $this->apiDomain = env('ZOHO_API_DOMAIN');
        $this->apiAccessToken = $this->getZohoAccessToken();
    }

    public function getAccounts()
    {
        $url = $this->apiDomain . "/crm/v7/Accounts?fields=Account_Name&per_page=10";

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->apiAccessToken,
            "Content-Type" => "application/json"
        ])->get($url);

        return $response->json();
    }

    public function createAccount(StoreAccountRequest $request)
    {

        $url = $this->apiDomain . "/crm/v7/Accounts";

        $data = [
            "data" => [
                [
                    "Website" => $request->website,
                    "Phone" => $request->phone,
                    "Account_Name" => $request->name,
                ]
            ]
        ];

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->apiAccessToken,
            "Content-Type" => "application/json"
        ])->post($url, $data);

        return $response->json();
    }

    public function createDeal(StoreDealRequest $request)
    {

        $url = $this->apiDomain . "/crm/v7/Deals";

        $data = [
            "data" => [
                [
                    "Account_Name" => [
                        "id" => $request->account_id,
                    ],
                    "Type" => "New Business",
                    "Closing_Date" => $request->closing_date,
                    "Deal_Name" => $request->name,
                    "Stage" => $request->stage,
                ]
            ]
        ];

        $response = Http::withHeaders([
            "Authorization" =>  "Bearer " . $this->apiAccessToken,
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

            $response = Http::asForm()->post($accountsUrl . "/oauth/v2/token", [
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
