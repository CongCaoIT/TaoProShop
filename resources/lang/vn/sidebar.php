<?php

return [
    'module' => [
        [
            'title' => 'QL Sản phẩm',
            'icon' => 'fa fa-cube',
            'name' => [
                'product',
                'attribute'
            ],
            'subModule' => [
                [
                    'title' => 'Nhóm Sản phẩm',
                    'route' => 'product.catalogue.index',
                ],
                [
                    'title' => 'Sản phẩm',
                    'route' => 'product.index',
                ],
                [
                    'title' => 'Loại thuộc tính',
                    'route' => 'attribute.catalogue.index',
                ],
                [
                    'title' => 'Thuộc tính',
                    'route' => 'attribute.index',
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
