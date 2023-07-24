<?php

namespace App\Http\Controllers;

use Google\Client;
use App\Models\Task;
use App\Services\Zipper;
use App\Models\WebService;
use Illuminate\Http\Request;
use App\Services\GoogleDrive;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

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
        'token' => $access_token,
        'name' => 'google-drive'
        ]);

        return $service;
    }

    public function store(WebService $web_service, GoogleDrive $drive) {

        //we need to fetch last 7 days of tasks

        $tasks = Task::where('created_at', '>=', now()->subDays(7))->get();
        //dd($tasks->toJson());

        $jsonFileName = 'task_dump.json';
        Storage::put("/public/temp/$jsonFileName", TaskResource::collection($tasks)->toJson());

       $zipFileName = Zipper::createZipOf($jsonFileName);
        //dd($zipFileName);
       $access_token = $web_service->token['access_token'];
       //dd($access_token);
       $drive->uploadFile($zipFileName, $access_token);

        Storage::deleteDirectory('/public/temp');
        return response('uploaded', Response::HTTP_CREATED);
    }

   
}