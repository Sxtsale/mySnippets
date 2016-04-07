<?php

use App\User;

return [
    'model' => User::class,
    'table' => 'oauth_identities',
    'providers' => [
        'github' => [
            'client_id' => '1235ebbafa8cb2ab7e90',
            'client_secret' => '90dda4bb06e07ff5bcf269f5a96f6993d9c06526',
            'redirect_uri' => 'http://snippets.dev/github/login',
            'scope' => [],
        ],
    ],
];
