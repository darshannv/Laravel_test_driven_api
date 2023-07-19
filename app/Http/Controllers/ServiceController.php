<?php

namespace App\Http\Controllers;

use Google\Client;
use App\Models\WebService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ServiceController extends Controller
{

    public const DRIVE_SCOPES = [
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ];

    public function connect(Request $request, Client $client) {

        if($request->service === 'google-drive') {
            $client->setScopes(self::DRIVE_SCOPES);
            $url = $client->createAuthUrl();
            return response(['url' => $url]);
        }
    }

    public function callback(Request $request, Client $client)  {

        $access_token = $client->fetchAccessTokenWithAuthCode($request->code);

        $service = WebService::create(['user_id' => auth()->id(),
        'token' => json_encode(['access_token' => $access_token]),
        'name' => 'google-drive'
        ]);

        return $service;
    }
}