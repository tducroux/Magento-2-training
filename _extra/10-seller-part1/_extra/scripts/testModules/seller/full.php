<?php
require __DIR__.'/../_tools/init.php';

// Initialize the client
$client = new \SmileCoreTest\RestClient();
$client->setDebug(true);
$client->setMagentoParams($params);
$client->connect();


for ($k=1; $k<100; $k++) {
    $object = [
        'object' => [
            'identifier' => 'seller_'.$k,
            'name'       => 'Seller Test '.$k,
        ]
    ];

    $client->post('rest/V1/seller/', $object);
}
