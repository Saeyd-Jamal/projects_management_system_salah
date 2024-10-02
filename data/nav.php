<?php

return [
    'general' => [
        'title' => 'العام',
        'icon' => 'fe fe-globe',
        'items' => [
            'accreditations.new' => [
                'title' => 'مشروع جديد',
                'route' => 'accreditations.create',
                'icon' => 'fe fe-plus',
                'permission' => 'create',
                'model' => 'App\\Models\AccreditationProject',
            ],
            'accreditations' => [
                'title' => 'الإعتمادية',
                'route' => 'accreditations.index',
                'icon' => 'fe fe-folder',
                'permission' => 'view',
                'model' => 'App\\Models\AccreditationProject',
                'badge' => [
                    'type' => 'count',
                    'color' => 'gradient-info',
                ],
            ],
        ]
    ],
    'management' => [
        'title' => 'الإدارة',
        'icon' => 'fe fe-box',
        'items' => [
            'allocations' => [
                'title' => 'التخصيصات',
                'route' => 'allocations.index',
                'icon' => 'fe fe-trello',
                'permission' => 'view',
                'model' => 'App\\Models\Allocation',

            ],
            'executives' => [
                'title' => 'التنفيذات',
                'route' => 'executives.index',
                'icon' => 'fe fe-watch',
                'permission' => 'view',
                'model' => 'App\\Models\Executive',
            ],
            'reports' => [
                'title' => 'التقارير',
                'route' => 'reports.index',
                'icon' => 'fe fe-file',
                'permission' => 'reports.view',
            ],
        ]
    ],
    'system_settings' => [
        'title' => 'إعدادات النظام',
        'icon' => 'fe fe-settings',
        'items' => [
            'users' => [
                'title' => 'المستخدمين',
                'route' => 'users.index',
                'icon' => 'fe fe-users',
                'permission' => 'view',
                'model' => 'App\\Models\User',
            ],
            'roles' => [
                'title' => 'الصلاحيات',
                'route' => 'roles.index',
                'icon' => 'fe fe-key',
                'permission' => 'view',
                'model' => 'App\\Models\Role',
            ],
            'currencies' => [
                'title' => 'العملات',
                'route' => 'currencies.index',
                'icon' => 'fe fe-dollar-sign',
                'permission' => 'view',
                'model' => 'App\\Models\Currency',
            ],
            'items' => [
                'title' => 'الأصناف',
                'route' => 'items.index',
                'icon' => 'fe fe-list',
                'permission' => 'view',
                'model' => 'App\\Models\Item',
            ],
        ]
    ],
    /*
    'cataloguing' => [
        'title' => 'التخصيصات',
        'icon' => 'fe fe-puzzle-piece',
        'items' => [
            'brokers' => [
                'title' => 'الوسطاء',
                'route' => 'brokers.index',
                'icon' => 'fe fe-truck',
                'permission' => 'view',
                'model' => 'App\\Models\Broker',
            ],
            'organizations' => [
                'title' => 'المؤسسات',
                'route' => 'organizations.index',
                'icon' => 'fe fe-building',
                'permission' => 'view',
                'model' => 'App\\Models\Organization',
            ],
            'projects' => [
                'title' => 'المشاريع',
                'route' => 'projects.index',
                'icon' => 'fe fe-diagram-project',
                'permission' => 'view',
                'model' => 'App\\Models\Project',
            ],

        ]
    ],
    */
];
