<?php


use Google\Client;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/drive', function() {
    $client = new Client();
    $client->setClientId('746729766449-vttdgudm57h90gl7s9uin3ekph8h9f3c.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http:://localhost:8000/google-drive/callback');
    $client->setScopes([
        'https://www.googleapi.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ]);

    $url = $client->createAuthUrl();
    return $url;
});