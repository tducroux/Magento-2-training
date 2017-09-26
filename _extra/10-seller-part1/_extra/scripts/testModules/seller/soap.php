<?php
require __DIR__.'/../_tools/init.php';

// Initialize the client
$client = new \SmileCoreTest\SoapClient();
$client->setDebug(true);
$client->setMagentoParams($params);
$client->addService('trainingSellerSellerRepositoryV1');

$object = [
    'object' => [
        'identifier' => 'cots',
        'name'       => 'Constantin Tsiolkovski',
    ]
];

$search = [
    'searchCriteria' => [
        'filterGroups' => [
            [
                'filters' => [
                    [
                        'field'          => 'identifier',
                        'conditionType'  => 'like',
                        'value'          => '%cot%'
                    ]
                ]
            ]
        ]
    ],
];

$client->trainingSellerSellerRepositoryV1Save($object);
$client->trainingSellerSellerRepositoryV1GetByIdentifier(['objectIdentifier' => $object['object']['identifier']]);
$client->trainingSellerSellerRepositoryV1DeleteByIdentifier(['objectIdentifier' => $object['object']['identifier']]);

$sp = $client->trainingSellerSellerRepositoryV1Save($object);
$client->trainingSellerSellerRepositoryV1GetById(['objectId' => $sp->sellerId]);
$client->trainingSellerSellerRepositoryV1GetList($search);
$client->trainingSellerSellerRepositoryV1DeleteById(['objectId' => $sp->sellerId]);
