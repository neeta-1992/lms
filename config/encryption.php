<?php

    /*
    |--------------------------------------------------------------------------
    | Encryption Congif Keys
    |--------------------------------------------------------------------------
    */
    return [
        'enable_encryption' => env("ENCRYPTION_STATUS"),
        'encrypt_method'    => env("ENCRYPTION_METHOD"),
        'encrypt_key'       => env("ENCRYPTION_KEY")
    ];
