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
            'users'              => 'c,r,u,d',
            'members'            => 'r,d',
            'categories'         => 'c,r,u,d',
            'governorates'       => 'c,r,u,d',
            'cities'             => 'c,r,u,d',
            'auctions'           => 'r,d',
            'auction_types'      => 'c,r,u,d',
            'tenders'            => 'r,d',
            'advertisements'     => 'c,r,u,d',
            'common_questions'   => 'c,r,u,d',
            'favorites'          => 'r,d',
            'contacts'           => 'r,d',
            'sliders'            => 'c,r,u,d',
            'abouts'             => 'r,u',
            'terms'              => 'r,u',
            'privicies'          => 'r,d',
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
