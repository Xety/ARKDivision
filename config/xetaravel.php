<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Xetaravel Site
    |--------------------------------------------------------------------------
    |
    | Here are each configuration related to Xetaravel itself. Those value are
    | used everywhere around the application.
    */
    'site' => [
        'description' => 'You will find content related to web development like tutorials, my personal tests on new technologies etc',
        'github_url' => 'https://github.com/XetaIO/Xetaravel',
        'contact_email' => 'contact@xeta.io',
        'analytics_tracker_code' => 'UA-40328289-2',
        'full_url' => 'https://discuss.ark-division.fr',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | All pagination settings used to paginate the queries.
    */
    'pagination' => [
        'notification' => [
            'notification_per_page' => 10
        ],
        'reward' => [
            'reward_per_page' => 10
        ],
        'user' => [
            'user_per_page' => 15
        ],
        'discuss' => [
            'conversation_per_page' => 15,
            'post_per_page' => 10
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Flood Rules
    |--------------------------------------------------------------------------
    |
    | All flood rules that apply at various point on the site. They are all in seconds.
    */
    'flood' => [
       'general' => 30,
        'discuss' => [
            'conversation' => 60
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Discuss
    |--------------------------------------------------------------------------
    |
    |
    */
    'discuss' => [
        'categories_sidebar' => 2, //15,
        // The number in days.
        'info_message_old_conversation' => 92
    ],

    /*
    |--------------------------------------------------------------------------
    | Donations
    |--------------------------------------------------------------------------
    |
    |
    */
    'donation' => [
        // Set the expiration delay used for members.
        'expire' => '+6 months',
         // The interval of donations amount to get a color.
        'color_interval' => 10,
        // The interval of donations amount to get a skin.
        'skin_interval' => 15,
        // The interval of donations amount to get a reward.
        'reward_interval' => 20,
        // The interval between two asked colors to avoid spam.
        'interval_between_asking_color' => 48,
        // The interval between two asked skins to avoid spam.
        'interval_between_asking_skin' => 48
    ],

    /*
    |--------------------------------------------------------------------------
    | Steam
    |--------------------------------------------------------------------------
    |
    |
    */
    'steam' => [
        'api_key' => 'EADF3D7361EA97FE3FC1D0DE86364537',
        'api_url' => 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=%s&steamids=%s',
        'profile_url' => 'https://steamcommunity.com/profiles/%s/'
    ],

    /*
    |--------------------------------------------------------------------------
    | Pastebin
    |--------------------------------------------------------------------------
    |
    |
    */
    'pastebin' => [
        'banlist_url' => 'https://pastebin.com/raw/LPCDZxDs'
    ]
];
