<?php

return [
    'path' => 'api/swagger',
    'urls' => [
        [
            'url' => 'api-docs/public/index.yaml',
            'name' => 'Публичный'
        ],
        [
            'url' => 'api-docs/account/index.yaml',
            'name' => 'Аккаунт'
        ]
    ],
];
