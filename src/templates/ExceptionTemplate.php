<?php

/**
 * 變數列表
 *
 * $exceptionTitle
 * $exceptionContent
 * $requestTitle
 * $requestContent
 * $envTitle
 * $envContent
 * $timeTitle
 * $timeContent
 * $traceTitle
 * $traceContent
 */

return [
    'blocks' => [
        [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => sprintf("*%s*\n```\n%s\n```\n", $exceptionTitle ?? 'Exception', $exceptionContent ?? ''),
            ],
        ],
        [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => sprintf("*%s*\n```\n%s\n```\n", $requestTitle ?? 'Request', $requestContent ?? ''),
            ],
        ],
        [
            'type' => 'section',
            'fields' => [
                [
                    'type' => 'mrkdwn',
                    'text' => sprintf("*%s*\n```\n%s\n```\n", $envTitle ?? 'Environment', $envContent ?? ''),
                ],
                [
                    'type' => 'mrkdwn',
                    'text' => sprintf("*%s*\n```\n%s\n```\n", $timeTitle ?? 'Time', $timeContent ?? ''),
                ],
            ],
        ],
    ],
    'attachments' => [
        [
            'color' => 'danger',
            'title' => sprintf('%s', $traceTitle ?? 'Trace'),
            'text' => sprintf('%s',$traceContent ?? ''),
        ]
    ],
];