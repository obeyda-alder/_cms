<?php

return [
    'users_type' => [
        'ALL',
        // 'ROOT',
        'ADMIN',
        'EMPLOYEE',
        'MASTER_AGENT',
        'SUB_AGENT',
        'CUSTOMER',
    ],
    'api_routes' => [
        'login'                 => config('app.api').'auth/login',
        'refresh'               => config('app.api').'auth/refresh',
        'users'   => [
            'index'             => config('app.api').'users/u/all_users_data',
            'edit'              => config('app.api').'users/u/edit',
            'create'            => config('app.api').'users/u/create',
            'update'            => config('app.api').'users/u/update',
            'soft_delete'       => config('app.api').'users/u/soft_delete',
            'delete'            => config('app.api').'users/u/delete',
            'restore'           => config('app.api').'users/u/restore',
            'default'           => config('app.api').'users/u/default',
        ],
        'addresses' => [
            'Countries'         => config('app.api').'addresses/get_Countries',
            'Cities'            => config('app.api').'addresses/get_Cities',
            'Municipalites'     => config('app.api').'addresses/get_Municipalites',
            'Neighborhoodes'    => config('app.api').'addresses/get_Neighborhoodes',
        ],
        'operations' => [
            'make'              => config('app.api').'make_operations',
        ],
        'packing' => [
            'order'             => config('app.api').'users/u/packing_order',
            'check_orders'      => config('app.api').'users/u/check_orders',
        ],
        'history' => [
            'unit'              => config('app.api').'users/u/units_history',
            'money'             => config('app.api').'users/u/money_history',
        ],
        'categories'   => [
            'index'             => config('app.api').'categories',
            'edit'              => config('app.api').'categories/edit',
            'create'            => config('app.api').'categories/create',
            'update'            => config('app.api').'categories/update',
            'delete'            => config('app.api').'categories/delete',
            'soft_delete'       => config('app.api').'categories/soft_delete',
            'restore'           => config('app.api').'categories/restore',
        ],



        //config... relations_type - operations - unit_type - relation_unit_type_with_operations
        'relations_type' => [
            'index'  => config('app.api').'relations_type',
            'create' => config('app.api').'relations_type/create',
            'delete' => config('app.api').'relations_type/delete',
        ],
        'operations' => [
            'index'  => config('app.api').'operations',
            'create' => config('app.api').'operations/create',
            'delete' => config('app.api').'operations/delete',
        ],
        'unit_type' => [
            'index'  => config('app.api').'unit_type',
            'create' => config('app.api').'unit_type/create',
            'delete' => config('app.api').'unit_type/delete',
        ],
        'relation_unit_type_with_operations' => [
            'index'  => config('app.api').'relation_unit_type_with_operations',
            'create' => config('app.api').'relation_unit_type_with_operations/create',
            'delete' => config('app.api').'relation_unit_type_with_operations/delete',
        ],
    ]
];
