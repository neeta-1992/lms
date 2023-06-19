<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Config Setting
    |--------------------------------------------------------------------------
    |
    */

    'quote' => [
       'number_of_payment'      => 9,
       'minimum_earned'         => 25,
       'down_percent'           => 25,
       'interest_rate'          => 7.95,
       'setup_fee'              => 20,
       'billing_schedule'       => 'Monthly',
       'otp_valid'              =>5,
       'finance_view'           => 10,
    ],

    'account_status_setting' => [
        'account_days_overdue'      =>'5',
        'personal_lines_days'       =>'10',
        'commercial_lines_days'     =>'10',
        'commercial_lines'          =>'5',
        'personal_lines'            =>'5',
        'fewer_days_remaining'      =>'0',
        'cancellation_notice_days'  =>'30',
        'sending_cancel_days'       =>'15',
        'sending_cancel_days_collection'    =>'15',
        'most_recent_date_days'     =>'25',
        'cancel_date_commercial_lines'  =>'10',
        'cancel_date_personal_lines'    =>'10'
    ],


    /* square Payment getway details */
    'square' => [
        'test' => [
            'square_application_name'   => env('APP_NAME'),
            'square_application_id'     => 'sandbox-sq0idb-Bps1Q57Qd7H6wC5T5ifU_Q',
            'square_access_token'       => 'EAAAEDUEVvi0cJeOFvYNFbt-_pyLHWT5WEWsqAjRwGsbJ24srWjzdJ8lu7Fp5h-U',
            'square_location_id'        => 'LKXDXZ6H6TJ2P',
        ],
        'live' => [
            'square_application_name'   => env('APP_NAME'),
            'square_application_id'     => 'sandbox-sq0idb-Bps1Q57Qd7H6wC5T5ifU_Q',
            'square_access_token'       => 'EAAAEDUEVvi0cJeOFvYNFbt-_pyLHWT5WEWsqAjRwGsbJ24srWjzdJ8lu7Fp5h-U',
            'square_location_id'        => 'LKXDXZ6H6TJ2P',
        ]
    ],  

];
