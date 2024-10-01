<?php

return [
    'general' => [
        'title' => 'العام',
        'icon' => 'fa-solid fa-globe',
        'items' => [
            'accreditations.new' => [
                'title' => 'مشروع جديد',
                'route' => 'accreditations.create',
                'icon' => 'fa-solid fa-plus',
                'permission' => 'create',
                'model' => 'App\\Models\AccreditationProject',
            ],
            'accreditations' => [
                'title' => 'الإعتمادية',
                'route' => 'accreditations.index',
                'icon' => 'fa-solid fa-folder',
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
        'icon' => 'fa-solid fa-toolbox',
        'items' => [
            'allocations' => [
                'title' => 'التخصيصات',
                'route' => 'allocations.index',
                'icon' => 'fa-solid fa-calculator',
                'permission' => 'view',
                'model' => 'App\\Models\Allocation',

            ],
            'executives' => [
                'title' => 'التنفيذات',
                'route' => 'executives.index',
                'icon' => 'fa-solid fa-gears',
                'permission' => 'view',
                'model' => 'App\\Models\Executive',
            ],
            'reports' => [
                'title' => 'التقارير',
                'route' => 'reports.index',
                'icon' => 'fa-solid fa-file-lines',
                'permission' => 'reports.view',
            ],
        ]
    ],
    'system_settings' => [
        'title' => 'إعدادات النظام',
        'icon' => 'fas fa-cog',
        'items' => [
            'users' => [
                'title' => 'المستخدمين',
                'route' => 'users.index',
                'icon' => 'fas fa-users',
                'permission' => 'view',
                'model' => 'App\\Models\User',
            ],
            'roles' => [
                'title' => 'الصلاحيات',
                'route' => 'roles.index',
                'icon' => 'fa-solid fa-scale-balanced',
                'permission' => 'view',
                'model' => 'App\\Models\Role',
            ],
            'currencies' => [
                'title' => 'العملات',
                'route' => 'currencies.index',
                'icon' => 'fa-solid fa-coins',
                'permission' => 'view',
                'model' => 'App\\Models\Currency',
            ],
            'items' => [
                'title' => 'الأصناف',
                'route' => 'items.index',
                'icon' => 'fa-solid fa-toolbox',
                'permission' => 'view',
                'model' => 'App\\Models\Item',
            ],
        ]
    ],
    /*
    'cataloguing' => [
        'title' => 'التخصيصات',
        'icon' => 'fa-solid fa-puzzle-piece',
        'items' => [
            'brokers' => [
                'title' => 'الوسطاء',
                'route' => 'brokers.index',
                'icon' => 'fa-solid fa-truck',
                'permission' => 'view',
                'model' => 'App\\Models\Broker',
            ],
            'organizations' => [
                'title' => 'المؤسسات',
                'route' => 'organizations.index',
                'icon' => 'fa-solid fa-building',
                'permission' => 'view',
                'model' => 'App\\Models\Organization',
            ],
            'projects' => [
                'title' => 'المشاريع',
                'route' => 'projects.index',
                'icon' => 'fa-solid fa-diagram-project',
                'permission' => 'view',
                'model' => 'App\\Models\Project',
            ],

        ]
    ],
    */
];
