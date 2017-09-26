<?php
require __DIR__.'/../_tools/init.php';

// Initialize the client
$client = new \SmileCoreTest\SoapClient();
$client->setDebug(true);
$client->setMagentoParams($params);
$client->addService('catalogProductRepositoryV1');
$client->addService('catalogCategoryRepositoryV1');

$client->catalogProductRepositoryV1Get(['sku' => '24-UB02']);
$client->catalogCategoryRepositoryV1Get(['categoryId' => 3]);

