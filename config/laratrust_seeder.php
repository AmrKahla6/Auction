<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'main'               => 'r',
            'users'              => 'c,r,u,d',
            'members'            => 'r',
            'commercia_member'   => 'r,d',
            'regular_member'     => 'r,d',
            'categories'         => 'c,r,u,d',
            'governorates'       => 'c,r,u,d',
            'cities'             => 'c,r,u,d',
            'auctions'           => 'r,d',
            'acution_slider'     => 'u',
            'acution_cancle'     => 'u',
            'auction_types'      => 'c,r,u,d',
            'tenders'            => 'r,d',
            'advertisements'     => 'c,r,u,d',
            'common_questions'   => 'c,r,u,d',
            'favorites'          => 'r,d',
            'contacts'           => 'r,d',
            'sliders'            => 'c,r,u,d',
            'setting'            => 'r',
            'abouts'             => 'r,u',
            'terms'              => 'r,u',
            'privicies'          => 'r,u',
        ],
        'admin' => [],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
