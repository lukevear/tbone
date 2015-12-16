<?php

require __DIR__ . '/../../vendor/autoload.php';

use TBone\TBone;
use TBone\TBoneEvent;

$router = new TBone;

$router->addHandler(TBoneEvent::ROUTE_NOT_FOUND, function() {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => TBoneEvent::ROUTE_NOT_FOUND]);
});

$router->get('/', function() {
    header('Content-Type: application/json');
    echo json_encode(['route' => '/']);
});

$router->get('/get', function() {
    header('Content-Type: application/json');
    echo json_encode(['route' => '/get']);
});

$router->post('/post', function() {
    header('Content-Type: application/json');
    echo json_encode(['route' => '/post']);
});

$router->put('/put', function() {
    header('Content-Type: application/json');
    echo json_encode(['route' => '/put']);
});

$router->delete('/delete', function() {
    header('Content-Type: application/json');
    echo json_encode(['route' => '/delete']);
});

$router->route();