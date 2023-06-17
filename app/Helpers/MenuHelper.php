<?php
namespace App\Helpers;

use App\Models\User;

class MenuHelper
{

    public static function menu()
    {
        if (auth()->check()) {
            $userType = auth()->user()?->user_type ?? 0;
            if ($userType == User::ADMIN) {
                return self::adminMenu();
            } elseif ($userType == User::INSURED) {

                $menu = self::insuredMenu();
                return $menu;
            } elseif ($userType == User::AGENT) {
                $menu = self::agentMenu();
                return $menu;
            } elseif ($userType == User::SALESORG) {

                $menu = self::salesOrganizationsMenu();
                return $menu;
            } else {
                $menuArr = [
                    [
                        "title" => "Dashboard",
                        "url" => ('company.dashboard'),
                    ],
                ];
                $menu = self::companyMenu();
                $companyMenu = array_merge($menuArr, $menu);
                return $companyMenu;
            }
        }
    }

    private static function adminMenu()
    {
        $menuArr = [
            'dashboard' => [
                "title" => "Dashboard",
                "url" => ('admin.dashboard'),
            ],
        ];

        $adminMene = [
            'company' => [
                "title" => "Company", 
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Finance Companies",
                        "url" => ('admin.finance-company.index'),
                    ],
                    /*  [
                    "title" => "Add Finance Companies",
                    "url" => ('admin.finance-company.create'),
                    ], */
                    [
                        "title" => "State Settings",
                        "url" => ('admin.state-settings.index'),
                    ],
                    [
                        "title" => "Finance Agreements",
                        "url" => ('admin.finance-agreement.index'),
                    ],
                    [
                        "title" => "Notice Templates",
                        "url" => ('admin.notice-templates.index'),
                    ],
                    [
                        "title" => "Notice Templates Shortcodes",
                        "url" => ('admin.notice-template-shortcodes.index'),
                    ],
                    [
                        "title" => " General Agents",
                        "url" => ('admin.general-agent.index'),
                    ],
                    [
                        "title" => "Insurance Companies",
                        "url" => ('admin.insurance-company.index'),
                    ],
                    [
                        "title" => "Coverage Types",
                        "url" => ('admin.coverage-type.index'),
                    ],
                    [
                        "title" => "Rate Tables",
                        "url" => ('admin.rate-table.index'),
                    ],
                    /*  [
                    "title" => "User Guides",
                    "url"  => Route::has('admin.user-guide.index') ? route('admin.user-guide.index'),
                    ], */
                    [
                        "title" => "GL Accounts",
                        "url" => ('admin.general-ledger-accounts.index'),
                    ],
                    [
                        "title" => "User Groups",
                        "url" => ('admin.user-group.index'),
                    ],
                    [
                        "title" => "Scheduled Tasks",
                        "url" => ('admin.scheduled-task.index'),
                    ],
                    [
                        "title" => "Cancellation Reasons",
                        "url" => ('admin.cancellation-reasons.index'),
                    ],
                ],
            ],
        ];

        $compunyId = session()->get('adminCompanyId');
        if(!empty($compunyId)){
            $companyMenu   = self::companyMenu();
            $adminMene['company']['dropdown'] = 'no';
            $adminMene['company']['class'] = 'company-menu';
        
            $submenu =     isset($companyMenu['settings']['submenu']) ?  array_merge($adminMene,$companyMenu['settings']['submenu']) : $adminMene;
           
            $companyMenu['settings']['submenu'] = $submenu;
           
            $menuArr =  array_merge($menuArr, $companyMenu);
          //  dd($menuArr);
        }else{
            $menuArr =  array_merge($menuArr, $adminMene);
        }
/* dd( $menuArr); */
        //$menuArr = !empty($compunyId) ? array_merge($menuArr, self::companyMenu()) : array_merge($menuArr, $adminMene);
        return $menuArr;
    }

    private static function companyMenu()
    {

        $menuArr = [

            "general" =>  [
                "title" => "General",
                "url" => '',
                "submenu" => [
                    [
                        "title" => " Company Information",
                        "url" => ('company.finance-company.index'),
                    ],
                    [
                        "title" => "Finance Agreements",
                        "url" => ('company.finance-agreement.index'),
                    ],
                    [
                        "title" => " Notice Templates",
                        "url" => ('company.notice-templates.index'),
                    ],
                    [
                        "title" => "Notice Templates Shortcodes",
                        "url" => ('company.notice-template-shortcodes.index'),
                    ],
                    [
                        "title" => "Homepage Message",
                        "url" => ('company.homepage-message.index'),
                    ],
                    [
                        "title" => "Scheduled Tasks",
                        "url" => ('company.scheduled-tasks.index'),
                    ],

                ],
            ],
            'quotes'=>[
                "title" => "Quotes",
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Find/Edit Quotes",
                        "url" => ('company.quotes.find-quotes'),
                    ],
                    [
                        "title" => "New Quote",
                        "url"   => ('company.quotes.create'),
                    ],
                    [
                        "title" => "Quotes",
                        "url" => ('company.quotes.index'),
                    ],
                    [
                        "title" => "Quotes In Activation",
                        "url" => ('company.quotes.quotes-activation'),
                    ],
                ],
            ],

            /* [
                "title" => "Accounts",
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Find/Edit Accounts",
                        "url" => ('company.accounts.find-accounts'),
                    ],
                    [
                        "title" => "Accounts",
                        "url" => ('company.accounts.index'),
                    ],
                ],
            ], */
          /*   [
                "title" => "Settings",
                "url" => '',
                "class" => 'mega_menu',
                "submenu" => [
                    [
                        "title" => "Account Settings",
                        "url" => ('company.settings.account-setting'),
                    ],
                    [
                        "title" => "Processing Fee Table",
                        "url" => ('company.processing-fee-tables.index'),
                    ],

                    [
                        "title" => "Account Status Settings",
                        "url" => ('company.account-status-settings.index'),
                    ],
                    [
                        "title" => "Policy Cancel Terms Options",
                        "url" => ('company.policy-cancel-terms-options.index'),
                    ],
                    [
                        "title" => "Activation Review Layout",
                        "url" => "",
                    ],
                    [
                        "title" => "Quote Settings",
                        "url" => ('company.quotes.quote-settings'),
                    ],

                    [
                        "title" => "Cancellation Reasons",
                        "url" => ('company.cancellation-reasons.index'),
                    ],

                    [
                        "title" => "Quote Status Settings",
                        "url" => ('company.quote-status-settings.index'),
                    ],

                    [
                        "title" => "Compensation Tables",
                        "url" => ('company.compensation-table.index'),
                    ],
                    [
                        "title" => "Rate Tables",
                        "url" => ('company.rate-table.index'),
                    ],

                    [
                        "title" => "Company Defaults",
                        "url" => ('company.settings.company-defaults'),
                    ],

                    [
                        "title" => "State Program Settings",
                        "url" => ('company.program-settings.index'),
                    ],
                    [
                        "title" => "Coverage Types",
                        "url" => ('company.coverage-type.index'),
                    ],

                    [
                        "title" => "State Settings",
                        "url" => ('company.state-settings.index'),
                    ],

                    [
                        "title" => "Down Payment Rules",
                        "url" => ('company.down-payment-rules.index'),
                    ],

                    [
                        "title" => "Territory Settings",
                        "url" => ('company.territory-settings.index'),
                    ],

                    [
                        "title" => "Electronic Payment Settings",
                        "url" => "company.settings.electronic-payment-settings",
                    ],

                    [
                        "title" => "User Groups",
                        "url" => ('company.user-group.index'),
                    ],
                    [
                        "title" => "NACHA and ACH File Settings",
                        "url" => ('company.settings.ach-settings'),
                    ],
                  
                ],
            ], */
            "settings" => [
                "title" => "Settings",
                "url" => '',
                "class" => 'more_mega_menu',
                "dropdown" => "no",
                "submenu" => [
                   
                    [
                        "title" => "Accounts",
                        "url" => '',
                        "dropdown" => "no",
                        "class" => "accounts-menu",
                        "submenu" => [
                            [
                                "title" => "Find/Edit Accounts",
                                "url" => ('company.accounts.find-accounts'),
                            ],
                            [
                                "title" => "Accounts",
                                "url" => ('company.accounts.index'),
                            ],
                        ],
                    ],
                  
                    [
                        "title" => "Settings",
                        "url" => '',
                        "dropdown" => "no",
                        "class" => 'mega_menu settings-menu' ,
                    
                        "submenu" => [
                            [
                                "title" => "Account Settings",
                                "url" => ('company.settings.account-setting'),
                            ],
                            [
                                "title" => "Processing Fee Table",
                                "url" => ('company.processing-fee-tables.index'),
                            ],
        
                            [
                                "title" => "Account Status Settings",
                                "url" => ('company.account-status-settings.index'),
                            ],
                            [
                                "title" => "Policy Cancel Terms Options",
                                "url" => ('company.policy-cancel-terms-options.index'),
                            ],
                            [
                                "title" => "Activation Review Layout",
                                "url" => "",
                            ],
                            [
                                "title" => "Quote Settings",
                                "url" => ('company.quotes.quote-settings'),
                            ],
        
                            [
                                "title" => "Cancellation Reasons",
                                "url" => ('company.cancellation-reasons.index'),
                            ],
        
                            [
                                "title" => "Quote Status Settings",
                                "url" => ('company.quote-status-settings.index'),
                            ],
        
                            [
                                "title" => "Compensation Tables",
                                "url" => ('company.compensation-table.index'),
                            ],
                            [
                                "title" => "Rate Tables",
                                "url" => ('company.rate-table.index'),
                            ],
        
                            [
                                "title" => "Company Defaults",
                                "url" => ('company.settings.company-defaults'),
                            ],
        
                            [
                                "title" => "State Program Settings",
                                "url" => ('company.program-settings.index'),
                            ],
                            [
                                "title" => "Coverage Types",
                                "url" => ('company.coverage-type.index'),
                            ],
        
                            [
                                "title" => "State Settings",
                                "url" => ('company.state-settings.index'),
                            ],
        
                            [
                                "title" => "Down Payment Rules",
                                "url" => ('company.down-payment-rules.index'),
                            ],
        
                            [
                                "title" => "Territory Settings",
                                "url" => ('company.territory-settings.index'),
                            ],
        
                            [
                                "title" => "Electronic Payment Settings",
                                "url" => "company.settings.electronic-payment-settings",
                            ],
        
                            [
                                "title" => "User Groups",
                                "url" => ('company.user-group.index'),
                            ],
                            [
                                "title" => "NACHA and ACH File Settings",
                                "url" => ('company.settings.ach-settings'),
                            ],
                          
                        ],
                    ]

                    
                ],
            ],
            'more_menu'=>[
                "title" => "...",
                "arrowIcon" => false,
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Daily Processing",
                        "url" => '',
                        "submenu" => [
                            [
                                "title" => "Daily Notices",
                                "url" => ('company.daily-notices.index'),
                            ],
                        ],
                    ],
                    [
                        "title" => "Payments",
                        "url" => '',
                        "submenu" => [
                            [
                                "title" => "Enter Payments",
                                "url" => ('company.payment.enter-payments'),
                            ],
                            [
                                "title" => "Verify Entered Payments",
                                "url" => ('company.payment.verify-entered-payments'),
                            ],

                            [
                                "title" => "Entered Payments History",
                                "url" => ('company.payment.entered-payments-history'),
                            ],
                            [
                                "title" => "ACH Payment History",
                                "url" => ('company.payment.ach-payments-history'),

                            ],
                        ],
                    ],
                    [
                        "title" => "Notices",
                        "url" => '',
                        "submenu" => [
                            [
                                "title" => "Notice Agents",
                                "url" => 'company.notices.agents',
                            ],
                            [
                                "title" => "Notice Insurance Companies",
                                "url" => 'company.notices.insurance-companies',
                            ],
                            [
                                "title" => "Notice Insureds",
                                "url" => 'company.notices.insureds',
                            ],
                            [
                                "title" => "Notice General Agents",
                                "url" => 'company.notices.general-agents',
                            ],
                            [
                                "title" => "Notice Sales Organizations",
                                "url" => 'company.notices.sales-organizations',
                            ],
                            [
                                "title" => "Notice Brokers",
                                "url" => 'company.notices.brokers',
                            ],
                            [
                                "title" => "Notice Lienholders",
                                "url" => 'company.notices.lienholders',
                            ],
                        ],
                    ],
                    [
                        "title" => "Accounting",
                        "url" => '',
                        "submenu" => [
                            [
                                "title" => "Bank Accounts",
                                "url" => 'company.bank-accounts.index',
                            ],
                            [
                                "title" => "GL Accounts",
                                "url" => ('company.general-ledger-accounts.index'),
                            ],
                            [
                                "title" => "Default GL Accounts",
                                "url" => 'company.default-gl-accounts.index',
                            ],
                        ],
                    ],
                    [
                        "title" => "Entity Manager",
                        "url" => '',
                        "submenu" => [
                            [
                                "title" => "Insurance Companies",
                                "url" => 'company.insurance-companies.index',
                            ],
                            [
                                "title" => "Agents",
                                "url" => ('company.agents.index'),
                            ],
                            [
                                "title" => "General Agents",
                                "url" => ('company.general-agents.index'),
                            ],
                            [
                                "title" => "Brokers",
                                "url" => ('company.brokers.index'),
                            ],
                            [
                                "title" => "Insureds",
                                "url" => ('company.insureds.index'),
                            ],
                            [
                                "title" => "Lienholders",
                                "url" => ('company.lienholders.index'),
                            ],
                            [
                                "title" => "Sales Organizations",
                                "url" => ('company.sales-organizations.index'),
                            ],
                            [
                                "title" => "Finance Company Users",
                                "url" => ('company.finance-company-users.index'),
                            ],
                        ],
                    ],
                    [
                        "title" => "Users",
                        "url" => '',
                        "submenu" => [
                            [
                                "title" => "Find/Edit User",
                                "url" => 'company.find-user.index',
                            ],
                            [
                                "title" => "Add New User",
                                "url" => 'company.find-user.new-user',
                            ],
                            [
                                "title" => "User Groups & Permissions",
                                "url" => ('company.group-permissions.index'),
                            ],
                            [
                                "title" => "Payment Method Permissions",
                                "url" => 'company.settings.payment-method-permissions',
                            ],
                            [
                                "title" => "User Security Settings",
                                "url" => 'company.user-security-settings.index',
                            ],

                        ],
                    ],
                    [
                        "title" => "Marketing",
                        "url" => '',
                        "submenu" => [
                            [
                                "title" => "Find/Edit Prospects",
                                "url" => ('company.prospects.index'),
                            ],
                             [
                                "title" => "New Prospect",
                                "url" => ('company.prospects.create'),
                            ],

                        ],
                    ],
                    [

                        "title" => "Payables",
                        "url" => '',
                        "submenu" => [
                            [
                                "title" => "Process Payables",
                                "url" => ('company.payables.process-payables'),
                            ],
                            [
                                "title" => "Payable History",
                                "url" => ('company.payables.payable-history'),
                            ],
                            [
                                "title" => "Find Payables",
                                "url" => ('company.payables.find-payables'),
                            ],

                        ],
                    ], [

                        "title" => "Reports",

                        "url" => '',

                        "submenu" => [

                            [

                                "title" => "Year End Report",

                                "url" => ('company.Report.year-end-reports'),

                            ],

                            [

                                "title" => "Earned Interest Report",

                                "url" => ('company.Report.earned-interest-reports'),

                            ],

                            [

                                "title" => "General Ledger",

                                "url" => ('company.Report.general-ledger'),

                            ],

                            [

                                "title" => "Expected Revenue Report",

                                "url" => ('company.Report.expected-revenue-report'),

                            ],

                        ],

                    ],
                ],
            ],

        ];

        return $menuArr;
    }

    private static function insuredMenu()
    {
        $menuArr = [
            [
                "title" => "Dashboard",
                "url" => ('company.dashboard'),
            ],
            [
                "title" => "Quotes",
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Find/Edit Quotes",
                        "url" => ('company.quotes.find-quotes'),
                    ],
                    [
                        "title" => "New Quote",
                        "url" =>  ('company.quotes.create'),
                    ],
                    [
                        "title" => "Quotes",
                        "url" => ('company.quotes.index'),
                    ],
                    [
                        "title" => "Quotes In Activation",
                        "url" => ('company.quotes.quotes-activation'),
                    ],
                ],
            ],

            [
                "title" => "Accounts",
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Find/Edit Accounts",
                        "url" => ('company.accounts.find-accounts'),
                    ],
                    [
                        "title" => "Accounts",
                        "url" => ('company.accounts.index'),
                        
                    ],
                ],
            ],

        ];

        return $menuArr;
    }


    private static function agentMenu()
    {
        $menuArr = [
            [
                "title" => "Dashboard",
                "url" => ('company.dashboard'),
            ],
            [
                "title" => "Quotes",
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Find/Edit Quotes",
                        "url" => ('company.quotes.find-quotes'),
                    ],
                    [
                        "title" => "New Quote",
                        "url" =>  ('company.quotes.create'),
                    ],
                    [
                        "title" => "Quotes",
                        "url" => ('company.quotes.index'),
                    ],
                    [
                        "title" => "Quotes In Activation",
                        "url" => ('company.quotes.quotes-activation'),
                    ],
                ],
            ],

            [
                "title" => "Accounts",
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Find/Edit Accounts",
                        "url" => ('company.accounts.find-accounts'),
                    ],
                    [
                        "title" => "Accounts",
                        "url" => ('company.accounts.index'),
                    ],
                ],
            ],

        ];

        return $menuArr;
    }

    private static function salesOrganizationsMenu()
    {
        $menuArr = [
            [
                "title" => "Dashboard",
                "url" => ('company.dashboard'),
            ],
            [
                "title" => "Marketing",
                "url" => '',
                "submenu" => [
                    [
                        "title" => "Prospects",
                        "url" => ('company.prospects.index'),
                    ],

                ],
            ],

        ];

        return $menuArr;
    }
}
