<?php

return [
    'module' => [
        [
            'title' => 'QL Bài viết',
            'icon' => 'fa fa-file',
            'name' => [
                'post'
            ],
            'subModule' => [
                [
                    'title' => 'Nhóm bài viết',
                    'route' => 'post.catalogue.index',
                ],
                [
                    'title' => 'Bài viết',
                    'route' => 'post.index',
                ]
            ]
        ],
        [
            'title' => 'QL thành viên',
            'icon' => 'fa fa-user',
            'name' => [
                'user',
                'permission'
            ],
            'subModule' => [
                [
                    'title' => 'Nhóm thành viên',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'Thành viên',
                    'route' => 'user.index',
                ],
                [
                    'title' => 'Quyền',
                    'route' => 'permission.index',
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
