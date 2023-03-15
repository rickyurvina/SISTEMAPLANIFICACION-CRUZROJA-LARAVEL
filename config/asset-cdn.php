<?php

return [

    'use_cdn' => env('USE_CDN', false),

    'cdn_url' => env('CDN_URL', ''),

    'filesystem' => [
        'disk' => 'azure-assets',

        'options' => [
            //
        ],
    ],

    'files' => [
        'ignoreDotFiles' => true,

        'ignoreVCS' => true,

        'include' => [
            'paths' => [
                'css',
                'img',
                'js',
                'vendor'
            ],
            'files' => [
                //
            ],
            'extensions' => [
                //
            ],
            'patterns' => [
                //
            ],
        ],

        'exclude' => [
            'paths' => [
                //
            ],
            'files' => [
                //
            ],
            'extensions' => [
                //
            ],
            'patterns' => [
                //
            ],
        ],
    ],

];
