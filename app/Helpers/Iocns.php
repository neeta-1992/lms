<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Str;

class Iocns
{

    public static function addIons()
    {

        $pageTitle = dynamicPageTitle('page');
        $pageTitle = Str::singular($pageTitle);
        $method = Route::currentRouteName() ?? "null.null.null";
        $activePage = activePageName();
        if (empty($activePage)) {
            return [];
        }

        list($userType, $routeName, $functionName) = explode('.', $method);
        $route = $functionName == 'index' ? "{$userType}.{$routeName}." : "";
        $routeUrl = "{$userType}.{$routeName}.";

        $addUrl = routeCheck($route . "create");
        $addTitle = removeWhiteSpace("Add {$pageTitle}");
        if (auth()->check()) {
            $userType = auth()->user()?->user_type ?? 0;
            $compunyId = session()->get('adminCompanyId');
            if ($userType == 1 && empty($compunyId)) {
                $arr = self::adminTablesIons($pageTitle, $addTitle, $addUrl, $route);
            } else {
                $arr = self::companyTablesIocns($pageTitle, $addTitle, $addUrl, $route, $routeUrl);
            }
        }

        return isset($arr[$activePage]) ? ($arr[$activePage]) : [];
    }

    public static function adminTablesIons($pageTitle, $addTitle, $addUrl, $route)
    {
        $arr = [
            "finance-company" => [
                "finance-company" => [
                    'Search' => ['status' => false],
                    'Refresh' => ['status' => false],
                    'Column' => ['status' => false],
                    'export' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "finance-company-logs" => [
                    'Search' => ['status' => false],
                    'Refresh' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'url', 'action' =>$addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
            ],
            "state-setting" => [
                "state-setting" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "state-setting-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "coverage-type" => [
                "coverage-type" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "coverage-type-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "finance-agreement" => [
                "finance-agreement" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                    'css' => ['status' => true, 'text' => __('labels.css'), 'actiontype' => 'url', 'action' => routeCheck($route . "css"), 'nomenuoption' => true, 'icon' => ''],

                ],
                "finance-agreement-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
                "finance-agreement-meta-tag-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle . " Css", 'actiontype' => 'button'],
                ],
            ],
            "notice-templates" => [
                "notice-templates" => [
                    'Search' => ['status' => true],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                    'css' => ['status' => true, 'text' => __('labels.css'), 'actiontype' => 'url', 'action' => routeCheck($route . "css"), 'nomenuoption' => true, 'icon' => ''],
                    'notice_hedaer_and_footer' => ['status' => true, 'text' => __('labels.notice_hedaer_and_footer'), 'actiontype' => 'url', 'action' => routeCheck($route . "header-footer",['type'=>'notice']), 'nomenuoption' => true, 'icon' => ''],
                    'email_hedaer_and_footer' => ['status' => true, 'text' => __('labels.email_hedaer_and_footer'), 'actiontype' => 'url', 'action' => routeCheck($route . "header-footer",['type'=>'email']), 'nomenuoption' => true, 'icon' => ''],
                ],
                "notice-templates-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
                "notice-templates-meta-tag-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle . " Css", 'actiontype' => 'button'],
                ],
            ],
            "rate-table" => [
                "rate-table" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "rate-table-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "scheduled-task" => [
                "scheduled-task" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "scheduled-task-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "gl-account" => [
                "gl-account" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "gl-account-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "user-groups" => [
                "user-groups" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "user-groups-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "cancellation-reasons" => [
                "cancellation-reasons" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "cancellation-reasons-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "insurance-company" => [
                "insurance-company" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "insurance-company-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
                "insurance-company-contacts" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Contact", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `add-contact`']],
                    /*  'cancel' => ['status' => true,'text'=>__('labels.cancel'),'actiontype'=>'attributes','action'=>
                ['x-on:click'=>'backPage=true']], */
                ],
                "insurance-company-quotes" => [
                    'Other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action' =>
                ['x-on:click' => 'open=`logs`']],
                'cancel' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'attributes', 'action' =>
                ['x-on:click' => 'open=`general-information`']],
                ],
            ],
        ];

        return $arr;

    }

    public static function companyTablesIocns($pageTitle, $addTitle, $addUrl, $route, $routeUrl = null)
    {
        $arr = [
            "coverage-type" => [
                "coverage-type" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "coverage-type-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "finance-agreement" => [
                "finance-agreement" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                    'css' => ['status' => true, 'text' => __('labels.css'), 'actiontype' => 'url', 'action' => routeCheck($route . "css"), 'nomenuoption' => true, 'icon' => ''],
                ],
                "finance-agreement-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
                "finance-agreement-meta-tag-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle . " Css", 'actiontype' => 'button'],
                ],
            ],
            "notice-templates" => [
                "notice-templates" => [
                    'Search' => ['status' => true],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                    'css' => ['status' => true, 'text' => __('labels.css'), 'actiontype' => 'url', 'action' => routeCheck($route . "css"), 'nomenuoption' => true, 'icon' => ''],
                    'notice_hedaer_and_footer' => ['status' => true, 'text' => __('labels.notice_hedaer_and_footer'), 'actiontype' => 'url', 'action' => routeCheck($route . "header-footer",['type'=>'notice']), 'nomenuoption' => true, 'icon' => ''],
                    'email_hedaer_and_footer' => ['status' => true, 'text' => __('labels.email_hedaer_and_footer'), 'actiontype' => 'url', 'action' => routeCheck($route . "header-footer",['type'=>'email']), 'nomenuoption' => true, 'icon' => ''],
                ],
                "notice-templates-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
                "notice-templates-meta-tag-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle . " Css", 'actiontype' => 'button'],
                ],
            ],
            "rate-table" => [
                "rate-table" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "rate-table-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "gl-account" => [
                "gl-account" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => false, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "gl-account-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "scheduled-task" => [
                "scheduled-task" => [
                    'Search' => ['status' => false],
                    //  'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "scheduled-task-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "user-groups" => [
                "user-groups" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "user-groups-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "insurance-company" => [
                "insurance-company" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "insurance-company-logs" => [
                    'Search' => ['status' => false],

                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "insurance-company-contacts" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Contact", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `add-contact`']],
                    /*  'cancel' => ['status' => true,'text'=>__('labels.cancel'),'actiontype'=>'attributes','action'=>
                ['x-on:click'=>'backPage=true']], */
                ],
                "insurance-company-quotes" => [
                  /*   'Other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action' =>
                ['x-on:click' => 'open=`logs`']], */
                'cancel' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'attributes', 'action' =>
                ['x-on:click' => 'open=`general-information`']], 
                ],
                "insurance-company-attachments" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Attachment", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `attachmentsForm`;attachmentsEditUrl=null']],
                    /* 'other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action'
                    =>
                    ['x-on:click' => 'open = `logs`']], */
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' =>
                        routeCheck($routeUrl . "index")],
                ],
            ],
            "general-agents" => [
                "general-agents" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "general-agents-logs" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "general-agents-contacts" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Contact", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `contactsForm`;contactsEditUrl=null']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],

                ],
                "general-agents-quotes" => [
                    //  'Search' => ['status' => true],
                    //  'Refresh' => ['status' => true],
                    //  'Column' => ['status' => true],
                    /*    'Other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action' =>
                ['x-on:click' => 'open=`logs`']],
                'cancel' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'attributes', 'action' =>
                ['x-on:click' => 'backPage=true']], */
                ],
                "general-agents-attachments" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Attachment", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `attachmentsForm`;attachmentsEditUrl=null']],
                    /* 'other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action'
                    =>
                    ['x-on:click' => 'open = `logs`']], */
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' =>
                        routeCheck($routeUrl . "index")],
                ],

                "general-agents-accounts" => [
                    /*    'Search' => ['status' => true], */
                    //   'Refresh' => ['status' => true],
                    //   'Column' => ['status' => true],
                    /*       'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action'
                =>routeCheck($routeUrl."index")],
                 */
                ],
            ],
            "user-guide" => [
                "user-guide" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "user-guide-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "state-setting" => [
                "state-setting" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "state-setting-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],


            "company-gl-account" => [
                "company-gl-account" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "company-gl-account-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "homepage-message" => [
                "homepage-message" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "homepage-message-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "scheduled-tasks" => [
                "scheduled-tasks" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "scheduled-tasks-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "compensation-table" => [
                "compensation-table" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "compensation-table-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "policy-cancel-terms-options" => [
                "policy-cancel-terms-options" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "policy-cancel-terms-options-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "processing-fee-tables" => [
                "processing-fee-tables" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "processing-fee-tables-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "cancellation-reasons" => [
                "cancellation-reasons" => [
                    'Search' => ['status' => false],
                    //'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "cancellation-reasons-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "program-settings" => [
                "program-settings" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "program-settings-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
                "program-settings-override-settings" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => __("labels.add") . ' ', 'actiontype' =>'attributes', 'action' => ['x-on:click' => 'ruleTable=`ruleForm`;ruleEditUrl=null']],
                    'Other' => ['status' => true, 'text' => __("labels.delete") . ' ', 'actiontype' =>
                    'attributes', 'action' => ['data-deleted' => 'isDelete', 'data-delete-url' => routeCheck('company.program-settings.delete'),'x-on:click' => 'ruleTable=`table`;ruleEditUrl=null']],
                ],
            ],

            "territory-settings" => [
                "territory-settings" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "territory-settings-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "account-settings" => [
                "account-settings" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "account-settings-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "down-payment-rules" => [
                "down-payment-rules" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "down-payment-rules-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
                "down-payment-rules-fee-table" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => __("labels.add") . ' ' . __("labels.rule"), 'actiontype' =>
                        'attributes', 'action' =>
                        ['x-on:click' => 'ruleTable=`ruleForm`;ruleEditUrl=null']],
                    'Other' => ['status' => true, 'text' => __("labels.delete") . ' ' . __("labels.rule"), 'actiontype' => 'attributes', 'action' =>
                        ['data-deleted' => 'isDelete', 'data-delete-url' => routeCheck('company.down-payment-rules.delete')]],
                ],
            ],

            "prospects" => [
                "prospects" => [
                    'Column' => ['status' => false],
                    'Search' => ['status' => false],
                    'Other' => ['status' => true, 'text' => 'Find Prospects', 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open=`isForm`']],
                ],
                "prospects-logs" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' =>
                        routeCheck($routeUrl . "index")],
                ],

                "prospects-contacts" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Contact", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `contactsForm`;contactsEditUrl=null']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "prospects-offices" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Office", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `officeForm`;officeEditUrl=null']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' =>
                        routeCheck($routeUrl . "index")],
                ],
            ],

            "finance-company-users" => [
                "finance-company-users" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "finance-company-users-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "brokers" => [
                "brokers" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "brokers-logs" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "brokers-contacts" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Contact", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `contactsForm`;contactsEditUrl=null']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "brokers-attachments" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Attachment", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `attachmentsForm`;attachmentsEditUrl=null']],
                    /* 'other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action'
                    =>
                    ['x-on:click' => 'open = `logs`']], */
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' =>
                        routeCheck($routeUrl . "index")],
                ],
            ],
            "lienholders" => [
                "lienholders" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "lienholders-logs" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "lienholders-contacts" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Contact", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `contactsForm`;contactsEditUrl=null']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "lienholders-attachments" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Attachment", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `attachmentsForm`;attachmentsEditUrl=null']],
                    /* 'other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action'
                    =>
                    ['x-on:click' => 'open = `logs`']], */
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' =>
                        routeCheck($routeUrl . "index")],
                ],
            ],

            "insureds" => [
                "insureds" => [
                    'Search' => ['status' => false],
                    'Refresh' => ['status' => false],
                    'Column' => ['status' => false],
                    'export' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl,
                        'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "insureds-logs" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "insureds-users" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add User", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `userForm`;usersEditUrl=null']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "insureds-attachments" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Attachment", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `attachmentsForm`;attachmentsEditUrl=null']],
                    /* 'other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action'
                    =>
                    ['x-on:click' => 'open = `logs`']], */
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' =>
                        routeCheck($routeUrl . "index")],
                ],
            ],

            "sales-organizations" => [
                "sales-organizations" => [
                    'Search' => ['status' => false],
                    'Refresh' => ['status' => false],
                    'Column' => ['status' => false],
                    'export' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl,
                        'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "sales-organizations-logs" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "sales-organizations-offices" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Office", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `officeForm`;officeEditUrl=null']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "sales-organizations-users" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add User", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `userForm`;usersEditUrl=null']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "sales-organizations-attachments" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Attachment", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `attachmentsForm`;attachmentsEditUrl=null']],
                    /*  'other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `logs`']], */
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
            ],

            "bank-accounts" => [
                "bank-accounts" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "bank-accounts-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "accounts" => [
                "accounts" => [
                    'Search' => ['status' => true],
                    'Refresh' => ['status' => true],
                    /*   'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'], */
                ],
                "accounts-logs" => [
                    'Search' => ['status' => false],
                    'exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `account_information`']],
                ],
                "accounts-payment-schedule-table" => [
                    'Search' => ['status' => false],
                    'export' => ['status' => true,'class'=>'d-none'],
                    'CSV' => ['status' => true,'text'=>'CSV','actiontype'=>'attributes','action'=>['class'=>'downloadCsv'],'class'=>'downloadCsv'],
                    'Add' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' =>'open = `account_information`']],
                ],
                "accounts-payment-transaction-history" => [
                    'Search' => ['status' => false],
                    'Refresh' => ['status' => true],

                    'exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' =>'open = `account_information`']],
                ],
                "accounts-account-alerts" => [
                    'Search' => ['status' => false],
                    'Refresh' => ['status' => true],
                    'Add' => ['status' => true, 'text' => __('labels.add')." ". __('labels.alert'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'accountAlertInsertOrUpdate()']],
                    'exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `account_information`']],
                ],
                "accounts-notes" => [
                    'Search' => ['status' => false],
                    'Refresh' => ['status' => true],
                    'Add' => ['status' => true, 'text' => __('labels.add')." ". __('labels.note'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'accountNotes()']],
                    'exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `account_information`']],
                ],
                "accounts-quote-list" => [
                    'Search' => ['status' => false],


                    'exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `account_information`']],
                ],
                "accounts-notice-history" => [
                    'Search' => ['status' => false],


                    'exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `account_information`']],
                ],
                "accounts-find" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => __('labels.find')." ".__('labels.account'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => "open = `isForm`"]],
                    'Exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'url', 'action' => routeCheck('company.dashboard')],
                ],
            ],
            "notice-insurance-company" => [
                "notice-insurance-company" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "notice-insurance-company-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "quotes" => [
                "quotes" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "quote_settings-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => "Quote Settings", 'actiontype' => 'button'],
                ],
                "quotes-tasks" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => __('labels.add').' '.__('labels.task'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `addTasks`']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'attributes', 'action' =>  ['x-on:click' => 'open = `terms`']],
                ],
                "quotes-tasks-delete" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'attributes', 'action' =>  ['x-on:click' => 'open = `terms`']],
                ],
                "quotes-notes" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => __('labels.add').' '.__('labels.notes'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `addNotes`']],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'attributes', 'action' =>  ['x-on:click' => 'open = `terms`']],
                ],
                "quotes-notes-delete" => [
                    'Search' => ['status' => false],

                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'attributes', 'action' =>  ['x-on:click' => 'open = `terms`']],
                ],
                "quotes-esignature" => [
                    'Search' => ['status' => false],

                ],
                "quotes-find" => [
                    'Search' => ['status' => true],
                    'Refresh' => ['status' => true],
                    'Column' => ['status' => true],
                    'export' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `isForm`']],
                ],
            ],
            "quote-status-settings" => [
                "quote-status-settings" => [
                    'Search' => ['status' => false],
                    //   'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "quote-status-settings-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'button'],
                ],
            ],
            "group-permissions" => [
                "group-permissions" => [
                    'Search' => ['status' => false],
                    'Exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'url', 'action' => routeCheck('company.dashboard')],
                ],
                "group-permissions-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => 'Groups & Permission', 'actiontype' => 'button'],
                ],
            ],
            "account-status-settings" => [
                "account-status-settings" => [
                    'Search' => ['status' => true],
                    'Refresh' => ['status' => false],
                    'Column' => ['status' => false],
                    'export' => ['status' => false],
                    'Exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'url', 'action' => routeCheck('company.dashboard')],
                ],
                "account-status-settings-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],

            "agents" => [
                "agents" => [
                    'Search' => ['status' => false],
                    'Refresh' => ['status' => false],
                    'Column' => ['status' => false],
                    'export' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "agents-logs" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "agents-offices" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Office", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `officeForm`;officeEditUrl=null']],
                    /*  'other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `logs`']], */
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "agents-users" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add User", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `userForm`;usersEditUrl=null']],

                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
                "agents-attachments" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => "Add Attachment", 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `attachmentsForm`;attachmentsEditUrl=null']],
                    /*  'other' => ['status' => true, 'text' => __('labels.logs'), 'actiontype' => 'attributes', 'action' =>
                    ['x-on:click' => 'open = `logs`']], */
                    'other' => ['status' => true, 'text' => __('labels.cancel'), 'actiontype' => 'url', 'action' => routeCheck($routeUrl . "index")],
                ],
            ],
            "notices" => [
                "general-agents-notice-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => 'General Agent Notices', 'actiontype' => 'button'],
                ],
                "agents-notice-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => 'Agent Notices', 'actiontype' => 'button'],
                ],
                "insurance-companies-notice-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => 'Insurance Companies Notices', 'actiontype' => 'button'],
                ],
                "insureds-notice-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => 'Insureds Notices', 'actiontype' => 'button'],
                ],
                "general-agents-notice-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => 'General Agent Notices', 'actiontype' => 'button'],
                ],
                "general-agents-notice-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => 'General Agent Notices', 'actiontype' => 'button'],
                ],
            ],
            "setting" => [
                "account-setting-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => "Account Settings", 'actiontype' => 'button'],
                ],
                "electronic-payment-setting-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => "Electronic Payment Settings", 'actiontype' => 'button'],
                ],
                "nacha-ach-setting-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => "NACHA File and ACH Settings", 'actiontype' => 'button'],
                ],
                "company-default-setting-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => "Company Default", 'actiontype' => 'button'],
                ],
            ],
            "find-user" => [
                "find-user-user" => [
                    'Search' => ['status' => true],
                    'Refresh' => ['status' => true],
                    'Column' => ['status' => true],
                    'export' => ['status' => false],
                    'other' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>
                        ['x-on:click' => 'open = `isForm`']],
                ],
                "find-user-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => __('Edit User'), 'actiontype' => 'button'],
                ],
            ],
            "user-security-settings" => [
                "user-security-settings" => [
                    /*  'Search' => ['status' => true],
                    'Refresh' => ['status' => true],
                    'Column' => ['status' => true],
                    'export' => ['status' => false], */
                    'Exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'url', 'action' =>
                        routeCheck('company.dashboard')],
                ],
                "user-security-settings-logs" => [
                    'Search' => ['status' => false],
                    'Edit' => ['status' => true, 'text' => $pageTitle, 'actiontype' => 'button'],
                ],
            ],
            "task" => [
                "task" => [
                    'Search' => ['status' => false],
                    'Add' => ['status' => true, 'text' => $addTitle, 'actiontype' => 'url', 'action' => $addUrl, 'nomenuoption' => true, 'icon' => 'fa-user'],
                ],
                "task-logs" => [
                    'Search' => ['status' => false],
                    'other' => ['status' => true, 'text' => "Task", 'actiontype' => 'attributes',
                        'action' =>
                        ['x-on:click' => 'open = `general-information`']],

                ],
            ],
            "daily-notices" => [

                "daily-notices-list" => [
                    'Search' => ['status' => false],
                    'ADD' => ['status' => true, 'text' => "Process Notices", 'actiontype' => 'attributes', 'action' => ['data-action'=>'process_notices']],
                    'Exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'url', 'action' => routeCheck('company.daily-notices.index')],
                ],
            ],
            "verify-entered-payments" => [

                "verify-entered-payments-find-payment" => [
                   // 'Search' => ['status' => false],
                  //  'ADD' => ['status' => true, 'text' => "Process Notices", 'actiontype' => 'attributes', 'action' => ['data-action'=>'process_notices']],
                    'other' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'attributes', 'action' =>  ['x-on:click' => 'open = `isForm`']],
                ],
                "verify-entered-payments-entered-payments-history" => [
                    'Exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'url', 'action' => routeCheck('company.dashboard')],
                ],
                "verify-entered-payments-commit-find-payment" => [
                    'ADD' => ['status' => true, 'text' => __('labels.nacha_file'), 'actiontype' => 'attributes', 'action' =>  ['data-action-download'=>'nacha']],
                    'Other' => ['status' => true, 'text' => __('labels.iif_file'), 'actiontype' => 'attributes', 'action' =>  ['data-action-download'=>'iif']],
                    'Exit' => ['status' => true, 'text' => __('labels.exit'), 'actiontype' => 'url', 'action' => routeCheck('company.dashboard')],
                ],
            ],

        ];
        return $arr;
    }

}
