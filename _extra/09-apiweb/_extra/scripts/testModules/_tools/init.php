<?php

$scriptDir = dirname(__DIR__);
$vendorDir = dirname(dirname(dirname($scriptDir))).'/vendor';

require_once $vendorDir.'/autoload.php';

require_once __DIR__.'/class/AbstractClient.php';
require_once __DIR__.'/class/RestClient.php';
require_once __DIR__.'/class/SoapClient.php';

$sampleFile = __DIR__.'/params.sample.php';
$paramsFile = $scriptDir.'/params.php';

if (!is_file($paramsFile)) {
    copy($sampleFile, $paramsFile);
}

require_once $paramsFile;

if ($params['soap_token'] == '@toGenerateInBackOffice') {
    echo "
    You must modify the param.php file before using this script.
    
    File: $paramsFile

";
    exit;
}
