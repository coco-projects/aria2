<?php

    use Coco\aria2\Aria2System;

    require '../vendor/autoload.php';

    $aria2Server = 'http://dev5017:6800/jsonrpc';
    $aria2Token  = 'abc123';

    $client = new Aria2System($aria2Server, $aria2Token);

    $url = 'http://xxx/bot6026303511:AAGvMcaxTRBbcPxs_ShGu-G4CffyCyI_6Ek/getFile?file_id=BAACAgUAAx0CdpNB3AACA_lnCmfGwrqejh50zlYygw10eZPuLAACFA0AAt8JQFT9G9PKdqAsszYE';

    $client->addCall('addUri', [
        [$url],
        [
            "out" => 'out1.json',
            "dir" => realpath('./aaaa'),
        ],
    ]);

    $client->addCall('addUri', [
        [$url],
        [
            "out" => 'out2.json',
            "dir" => realpath('./aaaa'),
        ],
    ]);

//    $result = $client->doRequest('multicall', [$client->calls]);

    $result = $client->multicall();

    print_r($result);



