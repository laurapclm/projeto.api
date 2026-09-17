<?php

require_once __DIR__ . '/vendor/autoload.php';

$generator = new \OpenApi\Generator();

$openapi = $generator->generate([
    __DIR__ . '/Controller'
]);

file_put_contents(
    __DIR__ . '/openapi.json',
    $openapi->toJson()
);

echo "Documentação Swagger gerada em openapi.json\n";