<?php

return [
    'module' => [
        [
            'title' => 'QL thành viên',
            'icon' => 'fa fa-user',
            'name' => [
                'user'
            ],
            'subModule' => [
                [
                    'title' => 'QL nhóm thành viên',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'QL thành viên',
                    'route' => 'user.index',
                ]
            ]
        ],
        [
            'title' => 'QL Bài viết',
            'icon' => 'fa fa-file',
            'name' => [
                'post'
            ],
            'subModule' => [
                [
                    'title' => 'QL nhóm bài viết',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'QL bài viết',
                    'route' => 'user.index',
                ]
            ]
        ],
        [
            'title' => 'Cấu hình chung',
            'icon' => 'fa fa-file',
            'name' => [
                'language'
            ],
            'subModule' => [
                [
                    'title' => 'QL Ngôn ngữ',
                    'route' => 'language.index',
                ]
            ]
        ]
    ]
];
