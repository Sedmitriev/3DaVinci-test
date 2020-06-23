<?php

require __DIR__ . '/vendor/autoload.php'; 
use Symfony\Component\Console\Application;
use GuzzleHttp\Client; 

$configFile = __DIR__ . '/config.json';
$config = json_decode(file_get_contents($configFile), true);

$client = new GuzzleHttp\Client(['base_uri' => 'https://api.github.com/']);
$response = $client->request('GET', 'users');
$users = json_decode($response->getBody()->getContents(), true);

$app = new Application(); 
$app->add(new Sedmit\DaVinci\StartCommand($users, $config)); 
$app->run();
