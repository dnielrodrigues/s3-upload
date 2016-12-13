<?php

/**
 * bootstrap e composer
 */
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../config.php';


use Aws\S3\S3Client;
use Aws\S3\PostObjectV4;


// params ...
$key = S3_KEY;
$secret = S3_SECRET;
$region = S3_REGION;
$bucket = S3_BUCKET;
$prefixKey = S3_PREFIX_KEY;


// Amazon S3 client ...
$client = new S3Client([
    'credentials' => [
        'key'    => $key,
        'secret' => $secret
    ],
    'region' => $region,
    'version' => 'latest',
]);


// config basica ...
$formInputs = ['acl' => 'public-read'];
$options = [
    [ 'acl' => 'public-read' ],
    [ 'bucket' => $bucket ],
    [ 'starts-with' , '$key' , $prefixKey ],
];
$expires = '+20 minutes';


// instancia obj upload para o S3 ...
$postObj = new PostObjectV4(
    $client,
    $bucket,
    $formInputs,
    $options,
    $expires
);


// seta a pasta onde vai o arquivo ...
$objKey = $prefixKey . '/' . $postObj->getFormInputs()['key'];
$postObj->setFormInput( 'key' , $objKey );


// resultado ...
$formAttributes = $postObj->getFormAttributes();
$formInputs = $postObj->getFormInputs();
$result = array_merge( $formAttributes , $formInputs );


// retorno ...
print json_encode( $result , JSON_UNESCAPED_UNICODE );










