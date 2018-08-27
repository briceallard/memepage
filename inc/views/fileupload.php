<?php

// handle multiple files to amazon s3 bucket here
require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../config.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => $aws_region,
    'credentials' => [
      'key' => $aws_key,
      'secret' => $aws_secret
    ]
]);

if ($_FILES['file']['error'] !== UPLOAD_ERR_OK){
  echo "no file uwu";
  exit;
}

try {
    $conn = $GLOBALS['conn'];

    // Upload data.
    $result = $s3->putObject([
        'Bucket'      => $aws_bucket,
        'Key'         => 'img/'.$_FILES['file']['name'],
        'Body'        => file_get_contents($_FILES['file']['tmp_name']),
        'ContentType' => $_FILES['file']['type']
    ]);

    $link = isset($aws_cname) && $aws_cname == 1 ? str_replace("s3.amazonaws.com/", "", $result['ObjectURL']) : $result['ObjectURL'];

    // insert into db here
    $conn->insert('images', ['name', 'type'], [$_FILES['file']['name'], $_FILES['file']['type']]);

    header('Content-Type: text/plain');
    echo $link;
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
exit;
