<?php


use Google\Client;
use Illuminate\Support\Facades\Route;


// https://github.com/googleapis/google-api-php-client/blob/main/examples/simple-file-upload.php
// guide of github document


Route::get('/', function () {
    return view('welcome');
});


Route::get('/drive', function() {
    $client = new Client();
    $client->setClientId('746729766449-vttdgudm57h90gl7s9uin3ekph8h9f3c.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://127.0.0.1:8000/google-drive/callback');
    $client->setScopes([
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ]);

    $url = $client->createAuthUrl();
    return $url;
});

Route::get('/google-drive/callback', function() {
    $client = new Client();
    $client->setClientId('746729766449-vttdgudm57h90gl7s9uin3ekph8h9f3c.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://127.0.0.1:8000/google-drive/callback');
    $code = request('code');
    $access_token = $client->fetchAccessTokenWithAuthCode($code);
    return $access_token;
});

Route::get('upload', function() {
    $client = new Client();
    $access_token = 'ya29.a0AbVbY6NaEYmUuqJBzIlp04ha1g2t4hf0W3gceouSL8grggsv7gJJDPh8LeiBW7gW0nQY3dl722QZ3YQNs-qQUxTVWL3A524yFybbFNRagQpZjewAJpbjVLeXgqXc3e0lXSaCLqLuhlX01MSeV9JbJW7BdTcvaCgYKAYMSARMSFQFWKvPll3T7EzJ7n0OwVNBif3P8LA0163';

    $client->setAccessToken($access_token);
    $service = new Google\Service\Drive($client);
    $file = new Google\Service\Drive\DriveFile();

    DEFINE("TESTFILE", 'testfile-small.txt');
    if (!file_exists(TESTFILE)) {
        $fh = fopen(TESTFILE, 'w');
        fseek($fh, 1024 * 1024);
        fwrite($fh, "!", 1);
        fclose($fh);
    }


    $file = new Google\Service\Drive\DriveFile();
    $file->setName("Hello World!");
    $service->files->create(
        $file,
        [
            'data' => file_get_contents(TESTFILE),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
        ]
    );


});