<?php
return [
    'relations_type'                     => 'The relationship of the relations type through which it adds relations to the user at the time of the actions',
    'operations'                         => 'Operations are user actions associated with a relations type',
    'unit_type'                          => 'Units This process is linked to the type of user through which a treasury of units is created when any user is created according to its type',
    'relation_unit_type_with_operations' => 'The type of unit of relationship with operations, which is the process of linking units with operations at any process in the system',
    'configurations' => [
        'global'                             => 'config',
        'create'                             => 'Create',
        'relations_type'                     => 'Relations type',
        'operations'                         => 'Operations',
        'unit_type'                          => 'Unit type',
        'relation_unit_type_with_operations' => 'Relation unit type with operations',
        'table' => [
            'relation_type'   => 'relation type',
            'user_type'       => 'user type',
            'type_en'         => 'type en',
            'type_ar'         => 'type ar',
            'relation'        => 'relation',
            'user_type'       => 'user type',
            'type'            => 'type',
            'continued'       => 'continued',
            'from_unit_type'  => 'from unit type',
            'from_continued'  => 'from continued',
            'to_unit_type'    => 'to unit type',
            'to_continued'    => 'to continued',
            'operation_en'    => 'operation en',
            'operation_ar'    => 'operation ar',
            'relation_type'   => 'relation type',
            'user_type'       => 'user type',
            'actions'         => 'actions',
        ],
    ],
    'model' => [
        'create_config' => 'create config',
        'relations_type' => [
            'from_users_type' => [
                'label' => 'from users type',
                'placeholder' => 'from users type',
                'help' => 'from users type',
            ],
            '_to_' => [
                'label' => 'to',
                'placeholder' => 'to',
                'help' => 'to',
            ],
            'to_user_type' => [
                'label' => 'users type',
                'placeholder' => 'users type',
                'help' => 'users type',
            ],
            'user_type' => [
                'label' => 'owner type',
                'placeholder' => 'owner type',
                'help' => 'owner type',
            ],
        ],
        'operations' => [
            'type_en' => [
                'label' => 'name operation in en',
                'placeholder' => 'name operation in en',
                'help' => 'name operation in en',
            ],
            'type_ar' => [
                'label' => 'name operation in ar',
                'placeholder' => 'name operation in ar',
                'help' => 'name operation in ar',
            ],
            'relation_id' => [
                'label' => 'select relation type to add operations',
                'placeholder' => 'select relation type to add operations',
                'help' => 'select relation type to add operations',
            ],
        ],
        'unit_type' => [
            'type' => [
                'label' => 'name unit type',
                'placeholder' => 'name unit type',
                'help' => 'name unit type',
            ],
            'continued' => [
                'label' => 'continued',
                'placeholder' => 'continued',
                'help' => 'continued',
            ],
        ],
        'relation_unit_type_with_operations' => [
            'operation_id' => [
                'label' => 'select operation in user type',
                'placeholder' => 'select operation in user type',
                'help' => 'select operation in user type',
            ],
            'from_unit_type_id' => [
                'label' => 'select from unit type in user type',
                'placeholder' => 'select from unit type in user type',
                'help' => 'select from unit type in user type',
            ],
            'to_unit_type_id' => [
                'label' => 'select to unit type in user type',
                'placeholder' => 'select to unit type in user type',
                'help' => 'select to unit type in user type',
            ],
        ],
        'currencies' => [
            'currency' => [
                'label' => 'Currency',
                'placeholder' => 'Currency',
                'help' => 'Currency',
            ],
            'name' => [
                'label' => 'Country Name',
                'placeholder' => 'Country Name',
                'help' => 'Country Name',
            ],
            'price' => [
                'label' => 'Price',
                'placeholder' => 'Price',
                'help' => 'Price',
            ],
        ],
    ],
    'global' => [
        'create'          => 'create',
        'currencies'      => 'currencies',
        'table' => [
            'flag'        => 'Flag',
            'name'        => 'Name',
            'currency'    => 'Currency',
            'price'       => 'Price',
            'created_at'  => 'Created At',
            'actions'     => 'Actions'
        ],
    ],
];
