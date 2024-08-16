<?php

return [
    'module' => [
        [
            'title' => '帖子',
            'icon' => 'fa fa-file',
            'name' => [
                'post'
            ],
            'subModule' => [
                [
                    'title' => '帖子组',
                    'route' => 'post.catalogue.index',
                ],
                [
                    'title' => '帖子',
                    'route' => 'post.index',
                ]
            ]
        ],
        [
            'title' => '用户',
            'icon' => 'fa fa-user',
            'name' => [
                'user'
            ],
            'subModule' => [
                [
                    'title' => '用户组',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => '用户',
                    'route' => 'user.index',
                ]
            ]
        ],
        [
            'title' => '通用',
            'icon' => 'fa fa-file',
            'name' => [
                'language'
            ],
            'subModule' => [
                [
                    'title' => '语言',
                    'route' => 'language.index',
                ]
            ]
        ]
    ]
];
