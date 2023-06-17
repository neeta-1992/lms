<?php

use App\Models\CompensationTable;
use App\Models\CoverageType;
use App\Models\DownPayment;
use App\Models\Entity;
use App\Models\GlAccount;
use App\Models\NoticeTemplate;
use App\Models\PolicyTermsOption;
use App\Models\ProcessingTable;
use App\Models\RateTable;
use App\Models\State;
use App\Models\StateProgramSetting;
use App\Models\User;
use Illuminate\Support\Str;

if (!function_exists('form_dropdown')) {
    function form_dropdown($name = '', $options = [], $selected = null, $extra = null, $isValueKey = false)
    {

        is_array($extra) ? extract($extra) : $extra;
        $class = isset($class) ? $class : '';
        $placeholder = isset($placeholder) ? $placeholder : '';

        $dataSelected = isset($dataSelected) ? "data-selected='{$dataSelected}'" : '';
        $readonly = isset($readonly) ? "readonly='readonly'" : '';
        $disabled = isset($disabled) ? "disabled='disabled'" : '';
        $islivewire = isset($islivewire) ? true : false;

        $class = preg_match("/ui dropdown/i", $class) ? $class : "ui dropdown {$class}";
        $multiple = isset($multiple) ? "multiple" : '';
        $required = isset($required) ? 'required' : '';

        $id = isset($id) ? $id : $name;
        $optionHtml = "<option value=''>{$placeholder}</option>";
        $iselected = "";
        $selected = isset($selected) ? $selected : '';
        $selectedvalue = (!empty($selected) && is_array($selected)) ? json_encode($selected) : $selected;

        if (!empty($options)) {
            foreach ($options as $key => $value) {

                $value = removeWhiteSpace($value);
                $key = $isValueKey == false ? $key : $value;
                // $key   = removeWhiteSpace($key);
                if (!empty($selected) && is_array($selected)) {
                    if (in_array($key, $selected)) {
                        $iselected = 'selected';
                    }
                } else {
                    $iselected = $key == $selected ? 'selected' : '';
                }

                $optionHtml .= "<option value='{$key}' $iselected>{$value}</option>";
            }
        }
        if ($islivewire) {
            $name = $name;
        } else {
            $name = "name='{$name}'";
        }
        $html = "<select $name class='{$class}' id='{$id}' {$multiple} {$required} {$disabled} {$dataSelected}>{$optionHtml}</select>";
        return $html;
    }
}
if (!function_exists('timeZoneDropDown')) {
    function timeZoneDropDown($string = "")
    {
        $array = [
            "America/New_York" => "Eastern Standard Time (GMT-05:00)",
            "America/Chicago" => "Central Standard Time (GMT-06:00)",
            "America/Denver" => "Mountain Standard Time (GMT-07:00)",
            "America/Los_Angeles" => "Pacific Standard Time (GMT-08:00)",
            "America/Anchorage" => "Alaska Standard Time (GMT-09:00)",
            "Pacific/Honolulu" => "Hawaii Standard Time (GMT-10:00)",
        ];
        return $array;
    }
}
if (!function_exists('taskName')) {
    function taskName($data = "")
    {
        $nameArr = $key = "";
        $isAdmin = false;
        if (is_array($data)) {
            $nameArr = isset($data['nameArr']) ? $data['nameArr'] : '';
            $isAdmin = isset($data['isAdmin']) ? $data['isAdmin'] : false;
        } else {
            $key = $data;
        }
        $array = [
            "assess_late_fees" => "Assess Late Fees",
            "assess_recurring_processing_fees" => "Assess Recurring Processing Fees",
            "close_accounts" => "Close Accounts",
            "delete_expired_quotes" => "Delete Expired Quotes",
            "email_task_history" => "Email Task History",
            "email_queue_send_unsent" => "Email Queue Send Unsent",
            "generate_agent_notice_of_cancelled_accounts" => "Generate Agent Notice of Cancelled Accounts",
            "generate_insured_billing_statements" => "Generate Insured Billing Statements",
            "generate_pending_cancellation_notices" => "Generate Pending Cancellation Notices",
            "generate_unearned_premium_not_received_notices" => "Generate Unearned Premium Not Received Notices",
            "unsuspend_accounts" => "Unsuspend Accounts",
            "update_account_status_and_generate_notices" => "Update Account Status and Generate Notices",
            "write_off_inactive_accounts" => "Write Off Inactive Accounts",
            "process_recurring_payments" => "Process recurring payments",
        ];
        if (config('fortify.prefix') == "enetworks" || $isAdmin == true) {
            $array['company_setup'] = 'Company Setup';
        }

        if (!empty($nameArr)) {
            $array = array_diff_key($array, array_flip((array) $nameArr));
        }

        if (!empty($key)) {
            return isset($array[$key]) ? $array[$key] : '';
        }

        ksort($array);
        return $array;
    }
}
if (!function_exists('howOften')) {
    function howOften($key = "")
    {
        $array = [
            "daily" => "Daily",
            "daily_excluding_weekends" => "Daily Excluding Weekends",
            "weekly" => "Weekly",
            "monthly" => "Monthly",
        ];
        if (!empty($key)) {
            return isset($array[$key]) ? $array[$key] : '';
        }
        return $array;
    }
}

if (!function_exists('statusArr')) {
    function statusArr($key = null)
    {
        $array = [
            1 => "Enable",
            0 => "Disable",
        ];
        if (isset($key)) {
            return isset($array[$key]) ? $array[$key] : '';
        }
        return $array;
    }
}

if (!function_exists('stateDropDown')) {
    function stateDropDown(array $array = [])
    {
        $keyType = !empty($array['keyType']) ? $array['keyType'] : 'state';
        $stateId = !empty($array['stateId']) ? $array['stateId'] : '';
        $addKey = !empty($array['addKey']) ? $array['addKey'] : '';
        $onDB = !empty($array['onDB']) ? (bool) $array['onDB'] : false;
        $state = new State;
        if ($onDB) {
            $state = $state->on('company_mysql');
        }
        $state = $state->select('id', 'state');
        if (!empty($stateId)) {
            $state = $state->whereNotIn('id', $stateId);
        }
        $state = $state->get()?->toArray();
        $state = array_column($state, 'state', $keyType);
        if (!empty($addKey)) {
            $state = array_merge($addKey, $state);
        }
        //   $state = array_merge([null => 'Select State'], $state);

        return $state;
    }
}

if (!function_exists('emailImapDropDown')) {
    function emailImapDropDown($string = "")
    {
        $array = [
            "IMAP" => "IMAP",
            "POP3" => "POP3",
        ];
        return $array;
    }
}

if (!function_exists('emailPortDropDown')) {
    function emailPortDropDown($string = "")
    {
        $array = [
            "25" => "25",
            "26" => "26",
            "110" => "110",
            "143" => "143",
            "465" => "465",
            "587" => "587",
        ];
        return $array;
    }
}

if (!function_exists('encryptionTypeDropDown')) {
    function encryptionTypeDropDown($string = "")
    {
        $array = [
            "Secure SSL" => "Secure SSL",
            "Secure TLS" => "Secure TLS",
            "Non-SSL/TLS" => "Non-SSL/TLS",
        ];
        return $array;
    }
}
if (!function_exists('actionNoticeTemplates')) {
    function actionNoticeTemplates($string = "")
    {
        $array = [
            "appointment_status" => "Appointment Status Email",
            "agent_unlock_quote_request_completed" => "Agent Unlock Quote Request - Completed",
            "agent_request_for_quote_activation" => "Agent Request for Quote Activation",
            "agent_unlock_quote_request_requested" => "Agent Unlock Quote Request - Requested",
            "company_inMail_to_agent" => "Company InMail to Agent",
            "esignature_2sv_email_to_agent" => "E-signature 2SV Email to Agent",
            "welcome_email_to_agents" => "Welcome Email to Agents",
            "your_payment_has_posted" => "Your Payment has Posted Email",
            "send_finance_agreement_to_insured" => "Send E-signature Finance Agreement to Insured",
            "ach_cover_letter" => "ACH Cover Letter",
            "ap_cover_letter" => "AP Cover Letter",
            "ap_memorandum" => "AP Memorandum",
            "agent_notice_of_cancelled_accounts" => "Agent Notice Of Cancelled Accounts",
            "billing_statement" => "Billing Statement",
            "billing_statement_on_demand" => "Billing Statement On-Demand",
            "auto_pay_enrollment_notification" => "Auto Pay Enrollment Notification",
            "auto_pay_cancellation_notification" => "Auto Pay Cancellation Notification",
            "auto_pay_cancellation_confirmation" => "Auto Pay Cancellation Confirmation",
            "ach_auto_pay_cancellation" => "ACH Auto Pay Cancellation",
            "ach_auto_pay_cancellation_notification" => "ACH Auto Pay Cancellation Notification",
            "appointment_suspended" => "Appointment Suspended",
            "agency_appointment_suspended" => "Agency Appointment Suspended",
            "ach_auto_pay_enrollment" => "ACH Auto Pay Enrollment",
            "agent_inMail_to_insured" => "Agent InMail to Insured",
            "cancel_letter_1" => "Cancel Letter 1",
            "cancel_letter_2" => "Cancel Letter 2",
            "collection" => "Collection",
            "collection_without_cancellation_notice" => "Collection Without Cancellation Notice",
            "cancellation_notice" => "Cancellation Notice",
            "check" => "Check",
            "credit_card_cover_letter" => "Credit Card Cover Letter",
            "cancellation_follow_up_letter" => "Cancellation Follow Up Letter",
            "credit_card_auto_pay_cancellation" => "Credit Card Auto Pay Cancellation",
            "credit_card_auto_pay_enrollment" => "Credit Card Auto Pay Enrollment",
            "credit_card_payment_cover_letter" => "Credit Card Payment Cover Letter",
            "email_receipt" => "Email Receipt",
            "flat_cancellation" => "Flat Cancellation",
            "intent_to_cancel" => "Intent to Cancel",
            "intent_to_cancel_follow_up" => "Intent To Cancel Follow-Up",
            "late_fee_due" => "Late Fees Due",
            "ledger_balance_statement" => "Ledger Balance Statement",
            "level_1_without_cancellation_letter" => "Level 1 Without Cancellation Letter",
            "level_2_without_cancellation_letter" => "Level 2 Without Cancellation Letter",
            "level_1_without_cancellation_statement" => "Level 1 Without Cancellation Statement",
            "manual_account_refund" => "Manual Account Refund",
            "notice_of_financed_premium" => "Notice of Financed Premium",
            "overage_down_payment" => "Overage Down Payment",
            "payemnt_coupon_cover_letter" => "Payment Coupon Cover Letter",
            "payment_coupon_cover_letter_replacement" => "Payment Coupon Cover Letter - Replacement",
            "pending_cancellation_notice" => "Pending Cancellation Notice",
            "past_due_warning" => "Past Due Warning",
            "payoff_balance" => "Payoff Balance",
            "payment_received_after_cancellation" => "Payment Received After Cancellation",
            "payment_confirmation" => "Payment Confirmation",
            "e_payment_confirmation" => "E-Payment Confirmation",
            "payment_coupons" => "Payment Coupons",
            "paid_in_full" => "Paid In Full",
            "partial_payment_advances_due_date" => "Partial Payment - Advances Due Date",
            "partial_payment_does_not_advances_due_date" => "Partial Payment - Does Not Advance Due Date",
            "reinstatement_request" => "Reinstatement Request",
            "rp_cover_letter" => "RP Cover Letter",
            "returned_check" => "Returned Check",
            "remittance_to_company_check_per_policy" => "Remittance to Company Check Per Policy",
            "remittance_to_company_ach" => "Remittance to Company ACH",
            "remittance_to_company_ach_details" => "Remittance to Company ACH Details",
            "remittance_to_company_check_per_account" => "Remittance to Company Check Per Account",
            "remittance_to_company_check_per_statement" => "Remittance to Company Check Per Statement",
            "remittance_to_company_check_per_statement_details" => "Remittance to Company Check Per Statement Details",
            "remittance_to_company_draft_per_quote" => "Remittance to Company Draft Per Quote",
            "remittance_to_company_notification" => "Remittance to Company Notification",
            "refund_for_overpaid_account" => "Refund For Overpaid Account",
            "rescission_notice" => "Rescission Notice",
            "short_down_payment" => "Short Down Payment",
            "statement_billing_cover_letter" => "Statement Billing Cover Letter",
            "temporary_company_created_by_agent" => "Temporary Company Created by Agent",
            "unearned_premium_not_received" => "Unearned Premium Not Received",
            "uneraned_premium_statement" => "Uneraned Premium Statement",
            "agent_return_commission_due" => "Agent Return Commission Due",
            "insured_installment_due" => "Insured Installment Due",
            "electronic-payment-confirmation" => "Electronic Payment Confirmation",
            "recurring_ach_autopay_enrollment_notification" => "Recurring Ach Autopay Enrollment Notification",
            "collection" => "Collection Notice",
            "autopay_cancellation_confirmation" => "AutoPay Cancellation Confirmation",
            "ach_auto_pay_cancellation_confirmation" => "Ach auto pay cancellation confirmation",
            "appointment_status" => "Appointment Status",
        ];
        return $array;
    }
}

if (!function_exists('monthsDropDown')) {
    function monthsDropDown($type = "name")
    {
        $monthArr = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i));
            $key = $type == "name" ? strtolower($monthName) : $i;
            $monthArr[$key] = $monthName;
        }
        return $monthArr;
    }
}

if (!function_exists('dayListDropDown')) {
    function dayListDropDown($month = null)
    {
        $totalDay = !empty($month) ? date('t', strtotime($month)) : date('t');
        $arr = [];
        for ($i = 1; $i <= $totalDay; $i++) {
            $arr[$i] = $i;
        }
        return $arr;
    }
}

if (!function_exists('coverageTypeDropDown')) {
    function coverageTypeDropDown(mixed $array = null): mixed
    {
        $addOption = !empty($array['addOption']) ? $array['addOption'] : [];

        $getData = CoverageType::getData()->orderBy('id', 'DESC')->get()?->toArray();
        $resArr = !empty($getData) ? array_column($getData, 'name', 'id') : [];
        $resArr = !empty($addOption) ? array_merge($addOption, $resArr) : $resArr;

        return $resArr;
    }
}
if (!function_exists('rateTableDropDown')) {
    function rateTableDropDown(mixed $type = null): mixed
    {
        $getData = RateTable::getData()->orderBy('id', 'DESC')->get()?->toArray();
        $resArr = !empty($getData) ? array_column($getData, 'name', 'id') : [];
        if (!empty($type)) {
            return isset($resArr[$type]) ? $resArr[$type] : '';
        }
        return $resArr;
    }
}
if (!function_exists('compensationTableDropDown')) {
    function compensationTableDropDown(mixed $type = null): mixed
    {
        $getData = CompensationTable::getData()->whereStatus(1)->whereEn('compensation', 'Agent compensation')->orderBy('id', 'DESC')->get()?->toArray();
        $resArr = !empty($getData) ? array_column($getData, 'name', 'id') : [];
        return $resArr;
    }
}
if (!function_exists('glAccountDropDown')) {
    function glAccountDropDown(array $array = null): array
    {
        try {
            $onDB = isset($array['onDB']) ? $array['onDB'] : false;
            $select = isset($array['select']) ? $array['select'] : '';
            $getData = new GlAccount;
            if ($onDB) {
                $getData = $getData->on('company_mysql');
            }
            $getData = $getData->get()?->toArray();
            if (!empty($select)) {
                $getData = !empty($getData) ? array_column($getData, $select, 'id') : [];
                $getData = !empty($getData) ? array_filter($getData) : [];
            }

            return $getData;
        } catch (\Throwable $th) {
            return [];
        }

    }
}

if (!function_exists('stateProgramSetting')) {
    function stateProgramSetting(array $array = null): mixed
    {
        try {
            $getData = StateProgramSetting::getData([])->get()?->toArray();
            $getData = array_column($getData, 'name', 'id');
            return $getData;
        } catch (\Throwable $th) {
            return [];
        }

    }
}
if (!function_exists('downPaymentDropDown')) {
    function downPaymentDropDown(array $array = null): mixed
    {
        try {
            $getData = DownPayment::getData([])->get()?->toArray();

            $getData = array_column($getData, 'name', 'id');
            return $getData;
        } catch (\Throwable $th) {
            return [];
        }
    }
}
if (!function_exists('processingTableDropDown')) {
    function processingTableDropDown(array $array = null): mixed
    {
        try {
            $getData = ProcessingTable::getData([])->get()?->toArray();

            $getData = array_column($getData, 'name', 'id');
            return $getData;
        } catch (\Throwable $th) {
            return [];
        }
    }
}

if (!function_exists('agentUsers')) {
    function agentUsers(array $array = null): mixed
    {
        try {
            $entityId = !empty($array['agencyId']) ? $array['agencyId'] : '';

            $getData = User::getData(['dEntityId' => $entityId])->get()?->toArray();

            $getData = array_column($getData, 'name', 'id');
            return $getData;
        } catch (\Throwable $th) {
            return [];
        }
    }
}
if (!function_exists('agencyType')) {
    function agencyType(array $array = null): mixed
    {
        try {
            $entityId = !empty($array['agencyId']) ? $array['agencyId'] : '';
            $all = !empty($array['all']) ? $array['all'] : false;
            $agency = Entity::getData(['type' => Entity::AGENT])->get()?->pluck('name', 'id')?->toArray();
            if (!empty($all)) {
                $defaultArr = ['all' => 'All'];
                $agency = $defaultArr + $agency;
            }
            return $agency;
        } catch (\Throwable $th) {
            return [];
        }
    }
}
if (!function_exists('policyTermsOption')) {
    function policyTermsOption(array $array = null): mixed
    {
        try {
            $policy_terms = PolicyTermsOption::getData()->selectRaw('CONCAT(days," ","days") as days_text,days')->get()?->pluck('days_text', 'days')?->toArray();

            return $policy_terms;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return [];
        }
    }
}

if (!function_exists('salesOrganizationType')) {
    function salesOrganizationType(array $array = null): mixed
    {
        try {
            $entityId = !empty($array['agencyId']) ? $array['agencyId'] : '';
            $default = !empty($array['default']) ? $array['default'] : false;
            $all = !empty($array['all']) ? $array['all'] : false;

            $agency = Entity::getData(['type' => Entity::SALESORG])->get()?->pluck('name', 'id')?->toArray();
            if (!empty($default)) {
                $defaultArr = [0 => 'Default'];
                $agency = $defaultArr + $agency;
            }
            if (!empty($all)) {
                $defaultArr = ['all' => 'All'];
                $agency = $defaultArr + $agency;
            }
            //  dd( $agency);
            return $agency;
        } catch (\Throwable $th) {
            return [];
        }
    }
}
if (!function_exists('rateTableTypeDropDown')) {
    function rateTableTypeDropDown(string $key = null): mixed
    {
        $arr = ['rate' => 'Add on rate ($ per $100)', 'fixed' => 'Fixed', 'indexed' => 'Indexed'];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}
if (!function_exists('rateTableAccountType')) {
    function rateTableAccountType(string $key = null): mixed
    {
        $arr = ['all' => 'All Types', 'commercial' => 'Commercial', 'personal' => 'Personal'];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

if (!function_exists('noticeTemplateType')) {
    function noticeTemplateType(string $key = null): mixed
    {
        $arr = [
            'account' => 'Per account',
            'policy' => 'Per Policy',
            'email' => 'Per Email',
            'quote' => 'Per Quote',
            'cron' => 'Cron',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

if (!function_exists('weekDropDown')) {
    function weekDropDown(string $key = null): mixed
    {
        $arr = [
            "sunday" => 'Sunday',
            "monday" => 'Monday',
            "tuesday" => 'Tuesday',
            "wednesday" => 'Wednesday',
            "thursday" => 'Thursday',
            "friday" => 'Friday',
            "saturday" => 'Saturday',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}
if (!function_exists('entityType')) {
    function entityType(string $key = null): mixed
    {
        $arr = [
            1 => 'Corporation',
            2 => 'Limited Liability Company',
            3 => 'Partnership',
            4 => 'Sole Proprietor',
            5 => 'Other',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}
if (!function_exists('userType')) {
    function userType(string $key = null): mixed
    {
        $arr = [1 => 'Admin', 3 => 'Insured', 4 => 'Agent', 5 => 'Sales organization', 6 => 'Finance company user'];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

if (!function_exists('timePicker')) {
    function timePicker(array $array = null): mixed
    {
        $start = !empty($array['start']) ? $array['start'] : "00:00";
        $end = !empty($array['end']) ? $array['end'] : "23:30";
        $min = !empty($array['min']) ? $array['min'] : "30";
        $tStart = strtotime($start);
        $tEnd = strtotime($end);
        $tNow = $tStart;
        $arr = [];
        while ($tNow <= $tEnd) {
            $value = date("h:i A", $tNow);
            $arr[$value] = $value;
            $tNow = strtotime("+{$min} minutes", $tNow);
        }
        return $arr;
    }
}

if (!function_exists('noticesDescriptionText')) {
    function noticesDescriptionText(array $array = null): mixed
    {

        $type = !empty($array['type']) ? $array['type'] : '';
        $key = !empty($array['key']) ? $array['key'] : '';
        $send_to = !empty($array['send_to']) ? $array['send_to'] : $type;
        $onDB = isset($array['onDB']) ? $array['onDB'] : false;
        $select = isset($array['select']) ? $array['select'] : '';
        $getData = new NoticeTemplate;
        if ($onDB) {
            $getData = $getData->on('company_mysql');
        }

        if (!empty($send_to)) {
            $getData = $getData->whereEncrypted('send_to', $send_to)->orWhereEncrypted('send_to', "Any");
        }
        $getData = $getData->groupBy("name")->orderByEncrypted('name', 'ASC')->get()?->toArray();

        /*->map(function ($item,$key) {
        $item->slug = Str::slug($item->name);
        return $item;
        })?*/

        if (!empty($select)) {
            $getData = !empty($getData) ? array_column($getData, $select, 'action') : [];
            $getData = !empty($getData) ? array_filter($getData) : [];
        }
        $arr = $getData;

        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

/*
Ueser Type Arr
 */

if (!function_exists('userguidesArr')) {
    function userguidesArr(string $key = null): mixed
    {
        $arr = [4 => 'Agents', 3 => 'General Agents', 7 => 'Insurance Companies'];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

/*
Login Ueser Type Arr
 */

if (!function_exists('loginUserTypeArr')) {
    function loginUserTypeArr(string $key = null): mixed
    {
        $arr = [User::AGENT => 'Agents', User::COMPANYUSER => 'Finance Company Users', User::INSURED => 'Insureds', User::SALESORG => 'Sales Organizations'];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}
if (!function_exists('agencyStatus')) {
    function agencyStatus(string $key = null): mixed
    {
        $arr = [1 => 'Enable', 6 => 'On Watch', 2 => 'Temporary', 0 => 'Disable', 5 => 'Suspended', 7 => 'Terminated'];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}
if (!function_exists('taskStatus')) {
    function taskStatus(string $key = null, $list = false): mixed
    {
        $arr = [4 => "Open", 3 => "In Progress", 2 => 'Completed'];
        if ($list) {
            $arr[1] = 'Close';
            // $arr[5] = 'Reopen';
        }
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

if (!function_exists('prospectsStatuArr')) {
    function prospectsStatuArr(string $key = null): mixed
    {

        $arr = [
            1 => '1st Appointment Follow-Up',
            2 => '2nd Appointment Follow-Up',
            3 => 'Agency Approved - Won!',
            4 => 'Appointment Rescheduled',
            5 => 'Appointment Scheduled',
            6 => 'Initial Call',
            7 => 'Initial Call Follow Up',
            8 => 'Initial Email',
            9 => 'Initial Email Follow-up',
            10 => 'Not Interested',
            11 => 'Prospect',
            12 => 'Unqualified',
            13 => 'Using Other Finance Company',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

if (!function_exists('paymentdropdown')) {
    function paymentdropdown(string $key = null): mixed
    {
        $arr = [
            "no_permissions" => 'No Permissions',
            "enter_payments" => 'Enter Payments',
            "enter_and_process_payments" => 'Enter and Process Payments',
            "must_process_payment" => 'Must Process Payment',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : ‘’;
        }
        return $arr;
    }
}

if (!function_exists('emailNotificationDropDown')) {
    function emailNotificationDropDown(string $key = null): mixed
    {
        $arr = [
            "insured" => 'Insured',
            "agent" => 'Agent',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : ‘’;
        }
        return $arr;
    }
}

if (!function_exists('policyTermDropDown')) {
    function policyTermDropDown(string $key = null): mixed
    {
        $arr = [
            "6 Months" => '6 Months',
            "12 Months" => '12 Months',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : ‘’;
        }
        return $arr;
    }
}
if (!function_exists('OverridesettingValues')) {
    function OverridesettingValues()
    {
        $OverridesettingValues = array(
            "1" => array("type" => "select", "option" => "Rule of 78,Actuaries"),
            "2" => array("type" => "text"),
            "3" => array("type" => "text"),
            "4" => array("type" => "text"),
            "5" => array("type" => "text", "class" => "Dollar"),
            "6" => array("type" => "text", "class" => "Dollar"),
            "7" => array("type" => "radio", "option" => "Yes,No"),
            "8" => array("type" => "select", "option" => "Insured,Agent,Insured or Agent"),
            "9" => array("type" => "select", "option" => "Agent,Insured"),
            "10" => array("type" => "select", "option" => "Yes,No"),
            "11" => array("type" => "select", "option" => "Yes,No"),
            "12" => array("type" => "select", "option" => "Allow,Prohibited"),
            "13" => array("type" => "text"),
            "14" => array("type" => "text", "class" => "Dollar"),
            "15" => array("type" => "text", "class" => "percentage"),
            "16" => array("type" => "text", "class" => "Dollar"),
            "17" => array("type" => "text", "class" => "percentage"),
            "18" => array("type" => "radio", "option" => "Yes,No"),
            "19" => array("type" => "text", "class" => "percentage"),
            "20" => array("type" => "text", "class" => "Dollar"),
            "21" => array("type" => "text", "class" => "Dollar"),
            "22" => array("type" => "text", "class" => "Dollar"),
            "23" => array("type" => "text"),
            "24" => array("type" => "text", "class" => "Dollar"),
            "25" => array("type" => "text", "class" => "percentage"),
            "26" => array("type" => "text", "class" => "Dollar"),
            "27" => array("type" => "text", "class" => "percentage"),
            "28" => array("type" => "text", "class" => "Dollar"),
            "29" => array("type" => "text", "class" => "percentage"),
            "30" => array("type" => "text", "class" => "Dollar"),
            "31" => array("type" => "text", "class" => "percentage"),
            "32" => array("type" => "text", "class" => "Dollar"),
            "33" => array("type" => "select", "option" => "Allowed,Prohibited"),
            "34" => array("type" => "radio", "option" => "Yes,No"),
            "35" => array("type" => "text", "class" => "Dollar"),
            "36" => array("type" => "text", "class" => "percentage"),
            "37" => array("type" => "text", "class" => "Dollar"),
            "38" => array("type" => "text", "class" => "percentage"),
            "39" => array("type" => "radio", "option" => "Yes,No"),
            "40" => array("type" => "text", "class" => "percentage"),
            "41" => array("type" => "text", "class" => "Dollar"),
            "42" => array("type" => "text", "class" => "Dollar"),
            "43" => array("type" => "text", "class" => "Dollar"),
            "44" => array("type" => "text"),
            "45" => array("type" => "text", "class" => "Dollar"),
            "46" => array("type" => "text", "class" => "percentage"),
            "47" => array("type" => "text", "class" => "Dollar"),
            "48" => array("type" => "text", "class" => "percentage"),
            "49" => array("type" => "text", "class" => "Dollar"),
            "50" => array("type" => "text", "class" => "percentage"),
            "51" => array("type" => "text", "class" => "Dollar"),
            "52" => array("type" => "text", "class" => "percentage"),
            "53" => array("type" => "text", "class" => "Dollar"),
            "54" => array("type" => "select", "option" => "Allowed,Prohibited"),
            "55" => array("type" => "radio", "option" => "Yes,No"),
            "56" => array("type" => "text"),
            "57" => array("type" => "text"),
            "58" => array("type" => "text"),
        );
        return $OverridesettingValues;
    }
}
if (!function_exists('Overridesettings')) {
    function Overridesettings($key = null)
    {
        $Overridesettings = array(
            "1" => "Interest spread method",
            "2" => "Personal days from due date to intent-to-cancel",
            "3" => "Personal days from intent-to-cancel to cancel",
            "4" => "Personal days from cancel to effective cancel",
            "5" => "NSF fee ($)",
            "6" => "Maximum charge off ($)",
            "7" => "Can late fees accrue",
            "8" => "Refund payable to",
            "9" => "Refund send check to",
            "10" => "Licensed for personal",
            "11" => "Licensed for commercial",
            "12" => "Agent authority to sign contracts",
            "13" => "State authority",
            "14" => "Personal minimum earned interest ($)",
            "15" => "Personal maximum interest rate (%)",
            "16" => "Personal maximum setup fee ($)",
            "17" => "Personal setup fee percent in down (%)",
            "18" => "Personal compute max setup fee per account",
            "19" => "Personal late fee (%)",
            "20" => "Personal late fee add ($)",
            "21" => "Personal minimum late fee ($)",
            "22" => "Personal maximum late fee ($)",
            "23" => "Personal days before late fee",
            "24" => "Personal cancellation fee ($)",
            "25" => "Personal other fee for credit card (%)",
            "26" => "Personal other fee for credit card ($)",
            "27" => "Personal other fee for echecks/ach (%)",
            "28" => "Personal other fee for echecks/ach ($)",
            "29" => "Personal other fee for recurring credit card (%)",
            "30" => "Personal other fee for recurring credit card ($)",
            "31" => "Personal other fee for recurring echecks/ach (%)",
            "32" => "Personal other fee for recurring echecks/ach ($)",
            "33" => "Personal agent rebates",
            "34" => "Personal default policies to short rate",
            "35" => "Commercial minimum earned interest ($)",
            "36" => "Commercial maximum interest rate (%)",
            "37" => "Commercial maximum setup fee ($)",
            "38" => "Commercial setup fee percent in down (%)",
            "39" => "Commercial compute max setup fee per account",
            "40" => "Commercial late fee (%)",
            "41" => "Commercial late fee add ($)",
            "42" => "Commercial minimum late fee ($)",
            "43" => "Commercial maximum late fee ($)",
            "44" => "Commercial days before late fee",
            "45" => "Commercial cancellation fee ($)",
            "46" => "Commercial other fee for credit card (%)",
            "47" => "Commercial other fee for credit card ($)",
            "48" => "Commercial other fee for echecks/ach (%)",
            "49" => "Commercial other fee for echecks/ach ($)",
            "50" => "Commercial other fee for recurring credit card (%)",
            "51" => "Commercial other fee for recurring credit card ($)",
            "52" => "Commercial other fee for recurring echecks/ach (%)",
            "53" => "Commercial other fee for recurring echecks/ach ($)",
            "54" => "Commercial agent rebates",
            "55" => "Commercial default policies to short rate",
            "56" => "Commercial days from due date to intent-to-cancel",
            "57" => "Commercial days from intent-to-cancel to cancel",
            "58" => "Commercial days from cancel to effective cancel",
        );

        if (!empty($key)) {
            return isset($Overridesettings[$key]) ? $Overridesettings[$key] : '';
        }
        return $Overridesettings;
    }
}
if (!function_exists('achAccounTypeDropDown')) {
    function achAccounTypeDropDown(string $key = null): mixed
    {
        $arr = [
            "Business Checking" => 'Business Checking',
            "Personal Checking" => 'Personal Checking',
            "Saving Account" => 'Saving Account',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

if (!function_exists('accountPaymentMethod')) {
    function accountPaymentMethod(string $key = null): mixed
    {
        $arr = [
            "Check" => 'Check',
            "Money Order" => 'Money Order',
            "Cashiers Check" => 'Cashiers Check',
            "Wire" => 'Wire',
            "Credit Card" => 'Credit Card',
            "eCheck" => 'eCheck',
        ];
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $arr;
    }
}

if (!function_exists('accountStatus')) {
    function accountStatus($key = null){
		$AccountStatusArr = array();
		$AccountStatusArr[0] = array('html'=>'','text'=>'','colorclass'=>'');
		$AccountStatusArr[1] = array('html'=>'<span class="badge badge-success">Account Current</span>','text'=>'Account Current','colorclass'=>'iconcolorgreen');
		$AccountStatusArr[2] = array('html'=>'<span class="badge badge-warning background-orange">Intent to Cancel</span>','text'=>'Intent to Cancel','colorclass'=>'iconcolororange');
		$AccountStatusArr[3] = array('html'=>'<span class="badge badge-danger background-red">Cancel</span>','text'=>'Cancel','colorclass'=>'iconcolorred');
		$AccountStatusArr[4] = array('html'=>'<span class="badge badge-danger background-red">Cancel 1</span>','text'=>'Cancel 1','colorclass'=>'iconcolorred');
		$AccountStatusArr[5] = array('html'=>'<span class="badge badge-danger background-red">Cancel 2</span>','text'=>'Cancel 2','colorclass'=>'iconcolorred');
		$AccountStatusArr[6] = array('html'=>'<span class="badge badge-danger background-red">Collection</span>','text'=>'Collection','colorclass'=>'iconcolorred');
		$AccountStatusArr[7] = array('html'=>'<span class="badge badge-light background-grey">Closed</span>','text'=>'Closed','colorclass'=>'iconcolorgrey');
		$AccountStatusArr[8] = array('html'=>'<span class="badge badge-danger background-red">Flat Cancel</span>','text'=>'Flat Cancel','colorclass'=>'iconcolorred');
        if (!empty($key)) {
            return isset($arr[$key]) ? $arr[$key] : '';
        }
        return $AccountStatusArr;
	}
}


 	