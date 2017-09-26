<?php
require __DIR__.'/../_tools/init.php';

// Initialize the client
$client = new \SmileCoreTest\RestClient();
$client->setDebug(true);
$client->setMagentoParams($params);
$client->connect();


$client->get('rest/V1/products/24-UB02');
$client->get('rest/V1/categories/3');
