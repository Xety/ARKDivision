<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Xetaravel Site
    |--------------------------------------------------------------------------
    |
    | Here are each configuration related to Division itself. Those value are
    | used everywhere around the application.
    */
    'site' => [
        'description' => 'You will find content related to web development like tutorials, my personal tests on new technologies etc',
        'github_url' => 'https://github.com/Xety',
        'contact_email' => 'contact@ark-division.fr',
        'analytics_tracker_code' => 'UA-40328289-2',
        'full_url' => 'https://discuss.ark-division.fr',
        'main' => 'https://ark-division.fr'
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
        'transaction' => [
            'transaction_per_page' => 10
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
        'categories_sidebar' => 15,
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
    | Paypal
    |--------------------------------------------------------------------------
    |
    |
    */
    'paypal' => [
        'production' => [
            'client_id' => 'AQKS69kpyM_1NuMP3WPFqmfNTPBNJIVKilpY-eMV4Rvk0qYjDjf8BHqYUeUs1pWkTWci1qrbJ23UNWek',
            'client_secret' => 'EExTSko5nKF-o7n_yJ58ndyMUS-F-tZFO6SwsNMo3KFuDYkt2lkSC2SjHXYac18YgHMtx7JQM5lj6bMy'
        ],
        'test' => [
            'client_id' => 'AcIUDaNhHuI9c2TPHdJfknSVhNGhtkXTMwBLOiRMzQVlajP9zJ-xkFuQEuW5KicPGvAYfJpSgkV42nkl',
            'client_secret' => 'ENs3pI02g-g8t8ZOstpQIKh-3rETScck4ruS596cdCUm7JzcumWve-7Nvl6fFCJX33_DzJShr1SH-hXg'
        ]
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
    | Twitch
    |--------------------------------------------------------------------------
    |
    |
    */
    'twitch' => [
        'profile_url' => 'https://www.twitch.tv/%s'
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
    ],

    /*
    |--------------------------------------------------------------------------
    | ARKLog
    |--------------------------------------------------------------------------
    |
    |
    */
    'arklog' => [
        // Set the expiration delay used for ARKLog free access.
        'expire' => '+48 hours',
    ]
];
