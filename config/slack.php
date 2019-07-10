<?php

return [
    // clients: 可設定多組 client 面對不同的 slack channel 及用途
    'clients'   =>  [
        // 格式: 'clientName' => [],
        // service provider 將綁定 "slack-{clientName}" 在 container 中
        'error-report' => [
            'endpoint' => '',               // slack web hook url
            'channel'  => '',               // slack channel name
            'username' => 'Error Report'   // slack messages' user name
        ],
    ],
];