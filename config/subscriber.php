<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Subscriber Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default subscriber options for your application.
    | You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'subscribers' => 'subscribers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscriber Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a subscriber provider. This defines how the
    | subscribers are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'subscribers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Subscriber::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscribers
    |--------------------------------------------------------------------------
    |
    |
    */

    'subscribers' => [
        'subscribers' => [
            'provider' => 'subscribers',
            'table' => 'subscribers',
        ],
    ],
];
