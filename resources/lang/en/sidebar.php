<?php

return [
    'module' => [
        [
            'title' => 'Post',
            'icon' => 'fa fa-file',
            'name' => [
                'post'
            ],
            'subModule' => [
                [
                    'title' => 'Post Group',
                    'route' => 'post.catalogue.index',
                ],
                [
                    'title' => 'Post',
                    'route' => 'post.index',
                ]
            ]
        ],
        [
            'title' => 'User',
            'icon' => 'fa fa-user',
            'name' => [
                'user',
                'permission'
            ],
            'subModule' => [
                [
                    'title' => 'User Group',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'User',
                    'route' => 'user.index',
                ],
                [
                    'title' => 'Permission',
                    'route' => 'permission.index',
                ]
            ]
        ],
        [
            'title' => 'General',
            'icon' => 'fa fa-file',
            'name' => [
                'language'
            ],
            'subModule' => [
                [
                    'title' => 'Language',
                    'route' => 'language.index',
                ]
            ]
        ]
    ]
];
