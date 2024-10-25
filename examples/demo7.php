<?php

    use Coco\aria2\Aria2System;

    require '../vendor/autoload.php';

    $aria2Server = 'http://dev5017:6800/jsonrpc';
    $aria2Token  = 'abc123';

    $client = new Aria2System($aria2Server, $aria2Token);

    $url = 'http://xxx/bot6026303511:AAGvMcaxTRBbcPxs_ShGu-G4CffyCyI_6Ek/getFile?file_id=BAACAgUAAx0CdpNB3AACA_lnCmfGwrqejh50zlYygw10eZPuLAACFA0AAt8JQFT9G9PKdqAsszYE';

    $client->addUriToDownload($url, 'test1.json', realpath('./aaaa'));
    $client->addUriToDownload($url, 'test2.json', realpath('./aaaa'));

    $result = $client->multicall();

    print_r($result);



