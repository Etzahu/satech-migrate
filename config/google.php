<?php

return [
    /*
    |----------------------------------------------------------------------------
    | Google application name
    |----------------------------------------------------------------------------
    */
    'application_name' => env('GOOGLE_APPLICATION_NAME', ''),

    /*
    |----------------------------------------------------------------------------
    | Default Google Spreadsheet ID
    |----------------------------------------------------------------------------
    */
    'default_spreadsheet_id' => env('GOOGLE_DEFAULT_SPREADSHEET_ID', '1ha_45TdVN7odz-64yKlXlvjXD66O5zfXG7HKeamFJfU'),

    /*
    |----------------------------------------------------------------------------
    | Google OAuth 2.0 access
    |----------------------------------------------------------------------------
    |
    | Keys for OAuth 2.0 access, see the API console at
    | https://developers.google.com/console
    |
    */
    'client_id' => env('GOOGLE_SHEETS_CLIENT_ID', ''),
    'client_secret' => env('GOOGLE_SHEETS_CLIENT_SECRET', ''),
    'redirect_uri' => env('GOOGLE_SHEETS_REDIRECT', ''),
    'scopes' => [
        \Google\Service\Sheets::SPREADSHEETS,
        \Google\Service\Drive::DRIVE,
    ],
    'access_type' => 'online',
    'prompt' => 'consent select_account',

    /*
    |----------------------------------------------------------------------------
    | Google developer key
    |----------------------------------------------------------------------------
    |
    | Simple API access key, also from the API console. Ensure you get
    | a Server key, and not a Browser key.
    |
    */
    'developer_key' => env('GOOGLE_DEVELOPER_KEY', ''),

    /*
    |----------------------------------------------------------------------------
    | Google service account
    |----------------------------------------------------------------------------
    |
    | Set the credentials JSON's location to use assert credentials, otherwise
    | app engine or compute engine will be used.
    |
    */
    'service' => [
        /*
        | Enable service account auth or not.
        */
        'enable' => env('GOOGLE_SHEETS_SERVICE_ENABLED', false),

        /*
         * Path to service account json file. You can also pass the credentials as an array
         * instead of a file path.
         */
        'file' => storage_path('app/google-service-account.json'),
    ],

    /*
    |----------------------------------------------------------------------------
    | Additional config for the Google Client
    |----------------------------------------------------------------------------
    |
    | Set any additional config variables supported by the Google Client
    | Details can be found here:
    | https://github.com/google/google-api-php-client/blob/master/src/Google/Client.php
    |
    | NOTE: If client id is specified here, it will get over written by the one above.
    |
    */
    'config' => [],
];
