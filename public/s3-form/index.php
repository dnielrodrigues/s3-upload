<?php

/**
 * bootstrap do composer
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use Aws\S3\S3Client;


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



/**
 * S3 list obj
 */
if ( isset($_GET['action']) && $_GET['action'] == 'list' ) {

    $command = $client->getCommand( 'listObjects' , [ 'Bucket' => $bucket ]);
    $request = $client->createPresignedRequest($command, '+20 minutes');
    $url = $request->getUri();
    print '<a href="' . $url . '">' . $url . '</a>';


/**
 * S3 get
 */
} elseif ( isset($_GET['action']) && $_GET['action'] == 'get' ) {
    print "get - ???";

// ...
} elseif (false) {
    # code...


/**
 * S3 upload
 */
} else{

    // $client = new \Aws\S3\S3Client([
    //     'version' => 'latest',
    //     'region' => $region,
    // ]);
    // $bucket = $bucket;

    // Set some defaults for form input fields
    $formInputs = ['acl' => 'public-read'];

    // Construct an array of conditions for policy
    $options = [
        ['acl' => 'public-read'],
        ['bucket' => $bucket],
        ['starts-with', '$key', 'teste/'],
    ];

    // Optional: configure expiration time string
    $expires = '+20 minutes';

    $postObject = new \Aws\S3\PostObjectV4(
        $client,
        $bucket,
        $formInputs,
        $options,
        $expires
    );

    // Get attributes to set on an HTML form, e.g., action, method, enctype
    $formAttributes = $postObject->getFormAttributes();

    // Form input fields
    $formInputs = $postObject->getFormInputs();

    // imprime obsevacoes para a configuracao do FORM
    // print json_encode( $formAttributes , JSON_UNESCAPED_UNICODE );

    // imprime json de requisitos do FORM
    // print json_encode( $formInputs , JSON_UNESCAPED_UNICODE );


    // testes
    var_dump($formAttributes);
    var_dump($formInputs);

}


?><html>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
    </head>
    <body>

    <form action="<?php print $formAttributes['action']; ?>" method="<?php print $formAttributes['method']; ?>" enctype="<?php print $formAttributes['enctype']; ?>">

        <br><br> key: <br>
        <input type="input"  name="key" value="teste/<?php print $formInputs['key']; ?>" />

        <input type="hidden" name="acl" value="<?php print $formInputs['acl']; ?>" />

        <br><br> credential: <br>
        <input type="text"   name="X-Amz-Credential" value="<?php print $formInputs['X-Amz-Credential']; ?>" />

        <br><br> algoritmo: <br>
        <input type="text"   name="X-Amz-Algorithm" value="<?php print $formInputs['X-Amz-Algorithm']; ?>" />

        <br><br> data: <br>
        <input type="text"   name="X-Amz-Date" value="<?php print $formInputs['X-Amz-Date']; ?>" />

        <br><br> policy: <br>
        <input type="hidden" name="Policy" value='<?php print $formInputs['Policy']; ?>' />

        <br><br> assinatura: <br>
        <input type="hidden" name="X-Amz-Signature" value="<?php print $formInputs['X-Amz-Signature']; ?>" />

        <br><br> arquivo: <br>
        <input type="file"   name="file" /> <br />

        <!-- The elements after this will be ignored -->
        <br><br>
        <input type="submit" name="submit" value="Upload to Amazon S3" />

        <!-- NOT REQUIRED

        <input type="hidden" name="success_action_redirect" value="http://sigv4examplebucket.s3.amazonaws.com/successful_upload.html" />
        <input type="input"  name="Content-Type" value="image/jpeg" />
        <input type="hidden" name="x-amz-meta-uuid" value="14365123651274" /> 
        <input type="hidden" name="x-amz-server-side-encryption" value="AES256" /> 
        <input type="input"  name="x-amz-meta-tag" value="" /><br /> -->

    </form>
  
</html>



    
    











