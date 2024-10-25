<?php

    use Coco\aria2\Aria2;

    require '../vendor/autoload.php';

    $aria2Server = 'http://dev5017:6800/jsonrpc';
    $aria2Token  = 'abc123';

    $client = new Aria2($aria2Server, $aria2Token);

    $url  = 'http://xxx/bot6026303511:AAGvMcaxTRBbcPxs_ShGu-G4CffyCyI_6Ek/getFile?file_id=BAACAgUAAx0CdpNB3AACA_lnCmfGwrqejh50zlYygw10eZPuLAACFA0AAt8JQFT9G9PKdqAsszYE';
    $test = $client->doRequest('addUri', [
        [$url],
        [
            "out" => 'out1.json',
            "dir" => realpath('./aaaa'),
        ],
    ]);

    print_r($test);