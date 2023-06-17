<?php

return [
    "state_setting" => [
        "refund_send_check" => [
            "title" => "Refund Send Check To",
            "content" => "The default recipient for refund checks.",
        ],
        "spread_method" => [
            "title" => "Interest Spread Method",
            "content" => "The calculation method used to spread the interest across the payment schedule.",
        ],
        "interest_earned_start_date" => [
            "title" => "Interest Earned Start Date",
            "content" => "",
        ],
        "interest_earned_stop_date" => [
            "title" => "?",
            "content" => "",
        ],
        "agent_rebates" => [
            "title" => "Agent Rebate",
            "content" => "When Allowed, an agent can receive compensation for a quote. State Settings rules & regulations for more information.",
        ],
        "policies_short_rate" => [
            "title" => "Default Policies to Short Rate",
            "content" => "When enabled, a short rate calculation will be used to determine the unearned premium on the Quote. Short Rate increases the Down Payment required amount.",
        ],
        "licensed_personal" => [
            "title" => "Licensed for Personal",
            "content" => "When set to “Yes,” you can create personal quotes.",
        ],
        "policies_commercial" => [
            "title" => "Licensed for Commercial",
            "content" => "When set to “Yes,” you can create commercial quotes.",
        ],		
    ],
	"finance-company" => [
		"primary_address" => [
		"title" => "Company Primary Address",
		"content" => "Finance company principal place of business a/k/a physical address",
		],
		"server_email" => [
		"title" => "Coupons/Invoices/Statement Address",
		"content" => "This is the mailing address for Coupons, Invoices, and Statements Address. Address will show in all Coupons, Invoices, and Statements as mailing address.",
		],
		"payment_coupons_address" => [
		"title" => "Fax Email Server Domain",
		"content" => "In many cases is the same as the Finance Company Domain Name",
		],				
	],
	"account-settings" => [
		"maximum_write_off_amount" => [
		"title" => "Maximum Write-Off Amount",
		"content" => "When closing an account if the insured owes LESS than this amount they will NOT be billed, the account will be closed and the balance will be written off.",
		],
		"payment_thershold_amount" => [
		"title" => "Payment Threshold Amount",
		"content" => "When processing a payment, if the payment is short by less than this amount, it 
will be considered a full payment and the installment number will be updated.",
		],
		"maximum_notices_to_process" => [
		"title" => "Maximum Notices To Process",
		"content" => "When processing notices, the maximum number of notices that can be 
processed at the same time. Blank will process all notices at once.",
		],				
	],


	
	/* 
	"" => [
		"field_name" => [
		"title" => "",
		"content" => "",
		],
		"server_email" => [
		"title" => "",
		"content" => "",
		],
		"" => [
		"title" => "",
		"content" => "",
		],				
	],
	*/  
];
