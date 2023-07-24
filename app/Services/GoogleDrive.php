<?php
namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;


class GoogleDrive {


    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function uploadFile($zipFileName, $access_token) {
        

    $this->client->setAccessToken($access_token);
    $service = new Drive($this->client);
    $file = new DriveFile();

    // DEFINE("TESTFILE", 'testfile-small.txt');
    // if (!file_exists(TESTFILE)) {
    //     $fh = fopen(TESTFILE, 'w');
    //     fseek($fh, 1024 * 1024);
    //     fwrite($fh, "!", 1);
    //     fclose($fh);
    // }
//dd($zipFileName);
    
    //$file->setName("Hello World!");
    $service->files->create(
        $file,
        [
            'data' => file_get_contents("$zipFileName"),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
        ]
    );
    
    }
}