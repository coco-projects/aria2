<?php

    use Coco\aria2\Aria2;

    require '../vendor/autoload.php';

    $aria2Server = 'http://dev5017:6800/jsonrpc';
    $aria2Token  = 'abc123';

    $client = new Aria2($aria2Server, $aria2Token);


//    $test = $client->getGlobalStat();
//    $test = $client->getVersion();
//    $test = $client->getSessionInfo();
    $test = $client->getGlobalStat();

    print_r($test);

