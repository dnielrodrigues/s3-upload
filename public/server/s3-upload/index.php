<?php

/**
 * bootstrap do composer
 */
require_once __DIR__ . '/../../../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\CommandInterface;
use Psr\Http\Message\RequestInterface;


/**
 * Amazon S3 params
 */
$key = 'AKIAJ6YEPVBWJXYDYJPA';
$secret = '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';
$region = 'us-east-1';
$bucket = 'info-homolog';

/**
 * Amazon S3 client
 */
$client = new S3Client([
    'credentials' => [
        'key'    => $key,
        'secret' => $secret
    ],
    'region' => $region,
    'version' => 'latest',
]);


// S3 list obj
if ( isset($_GET['action']) && $_GET['action'] == 'list' ) {

    $command = $client->getCommand( 'listObjects' , [ 'Bucket' => $bucket ]);
    $request = $client->createPresignedRequest($command, '+20 minutes');
    $url = $request->getUri();
    print '<a href="' . $url . '">' . $url . '</a>';


// S3 get
} elseif ( isset($_GET['action']) && $_GET['action'] == 'get' ) {
    print "get - ???";

// ...
} elseif (false) {
    # code...


// S3 upload
} else{

    //

}








