<?php

/**
 * bootstrap do composer
 */
require_once __DIR__ . '/../../../vendor/autoload.php';

use Aws\S3\S3Client;

/**
 * Amazon S3 params
 */
$key = S3_KEY;
$secret = S3_SECRET;
$region = S3_REGION;
$bucket = S3_BUCKET;


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


/**
 * S3 upload
 */
$formInputs = ['acl' => 'public-read'];
$options = [
    ['acl' => 'public-read'],
    ['bucket' => $bucket],
    ['starts-with', '$key', 'teste/'],
];
$expires = '+20 minutes';

// config
$postObject = new \Aws\S3\PostObjectV4(
    $client,
    $bucket,
    $formInputs,
    $options,
    $expires
);
$formAttributes = $postObject->getFormAttributes();
$formInputs = $postObject->getFormInputs();

// result
$result = array_merge( $formAttributes , $formInputs );
print json_encode( $result , JSON_UNESCAPED_UNICODE );










