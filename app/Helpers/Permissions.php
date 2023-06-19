<?php
namespace App\Helpers;
use App\Models\User;
class Permissions
{
    public static function permissions($typeId)
    {

        $permissions = "";
        switch ($typeId) {
            case User::COMPANYUSER:
                $permissions = self::financeCompanyUsersPermissions();
                break;
            case User::AGENT:
                $permissions = self::agentpermission();
                break;
            case User::INSURED:
                $permissions = self::insurdsPermission();
                break;
            case User::SALESORG:
                $permissions = self::salesOrganizationsPermission();
                break;
            default:
                $permissions = [];
                break;
        }
        return $permissions;
    }


    public static function reports($typeId)
    {
        $reports = "";
        switch ($typeId) {
            case User::COMPANYUSER:
                $reports = self::financeCompanyReports();
                break;
            case User::AGENT:
                $reports = self::agentReport();
                break;
            case User::INSURED:
                $reports = [];
                break;
            case User::SALESORG:
                $reports = self::salesReport();
                break;
            default:
                $reports = [];
                break;
        }

        return $reports;
    }

    private static function financeCompanyUsersPermissions()
    {
        $arr = [
            [
                "text" => __('labels.Account'),
                "key" => 'account',
                "permissions" => [
                    ['text' => __('labels.find_account'), 'name' => 'find_account', 'route' => ''],
                    ['text' => __('labels.account_quote_view_document_images'), 'name' =>
                        'account_quote_view_document_images', 'route' => ''],
                    ['text' => __('labels.view_payment_schedule_history'), 'name' =>
                        'view_payment_schedule_history', 'route' => ''],
                    ['text' => __('labels.view_transaction_history'), 'name' => 'view_transaction_history', 'route' => ''],
                    ['text' => __('labels.view_notice_history'), 'name' => 'view_notice_history', 'route' => ''],
                    ['text' => __('labels.reprint_payment_letter'), 'name' => 'reprint_payment_letter', 'route' => ''],
                    ['text' => __('labels.reprint_payment_coupons'), 'name' => 'reprint_payment_coupons', 'route' => ''],
                    ['text' => __('labels.add_ap_endorsement_and_new_policy'), 'name' =>
                        'add_ap_endorsement_and_new_policy', 'route' => ''],
                    ['text' => __('labels.add_notes'), 'name' => 'add_notes', 'route' => ''],
                    ['text' => __('labels.view_notes'), 'name' => 'view_notes', 'route' => ''],
                    ['text' => __('labels.enter_return_premium_commission'), 'name' =>
                        'enter_return_premium_commission', 'route' => ''],
                    ['text' => __('labels.process_entered_payments'), 'name' => 'process_entered_payments', 'route' => ''],
                    ['text' => __('labels.enter_payments'), 'name' => 'enter_payments', 'route' => ''],
                    ['text' => __('labels.account_quote_confirm_signed_agreement'), 'name' =>
                        'account_quote_confirm_signed_agreement', 'route' => ''],
                    ['text' => __('labels.flat_cancel'), 'name' => 'flat_cancel', 'route' => ''],
                    ['text' => __('labels.manual_status_changes'), 'name' => 'manual_status_changes', 'route' => ''],
                    ['text' => __('labels.suspend_unsuspend'), 'name' => 'suspend_unsuspend', 'route' => ''],
                    ['text' => __('labels.adjust_interest'), 'name' => 'adjust_interest', 'route' => ''],
                    ['text' => __('labels.adjust_fees'), 'name' => 'adjust_fees', 'route' => ''],
                    ['text' => __('labels.create_late_fee_payoff_balance_notices'), 'name' =>
                        'create_late_fee_payoff_balance_notices', 'route' => ''],
                    ['text' => __('labels.manuel_refund'), 'name' => 'manuel_refund', 'route' => ''],
                    ['text' => __('labels.write_off_principal_interest'), 'name' => 'write_off_principal_interest', 'route' => ''],
                    ['text' => __('labels.change_buy_rate'), 'name' => 'change_buy_rate', 'route' => ''],
                    ['text' => __('labels.change_agent'), 'name' => 'change_agent', 'route' => ''],
                    ['text' => __('labels.edit_policy_related_payables'), 'name' => 'edit_policy_related_payables', 'route' => ''],
                    ['text' => __('labels.confirm_policy_information'), 'name' => 'confirm_policy_information', 'route' => ''],
                    ['text' => __('labels.confirm_cancelled_policies'), 'name' => 'confirm_cancelled_policies', 'route' => ''],
                    ['text' => __('labels.change_insured_payment_info'), 'name' => 'change_insured_payment_info', 'route' => ''],
                    ['text' => __('labels.view_policy'), 'name' => 'view_policy', 'route' => ''],
                    ['text' => __('labels.view_endorsement'), 'name' => 'view_endorsement', 'route' => ''],
                    ['text' => __('labels.edit_policy'), 'name' => 'edit_policy', 'route' => ''],
                    ['text' => __('labels.edit_endorsement'), 'name' => 'edit_endorsement', 'route' => ''],
                    ['text' => __('labels.adjust_payables'), 'name' => 'adjust_payables', 'route' => ''],
                    ['text' => __('labels.enter_down_payment'), 'name' => 'enter_down_payment', 'route' => ''],
                    ['text' => __('labels.update_department_code'), 'name' => 'update_department_code', 'route' => ''],
                    ['text' => __('labels.suspend_unsuspend_notices'), 'name' => 'suspend_unsuspend_notices', 'route' => ''],
                    ['text' => __('labels.confirm_carrier_acknowledgement_of_policies'), 'name' =>
                        'confirm_carrier_acknowledgement_of_policies', 'route' => ''],
                    ['text' => __('labels.issue_drafts_prior_to_effective_date'), 'name' =>
                        'issue_drafts_prior_to_effective_date', 'route' => ''],
                    ['text' => __('labels.adjust_payable_dates_in_to_the_future'), 'name' =>
                        'adjust_payable_dates_in_to_the_future', 'route' => ''],
                    ['text' => __('labels.enable_disable_agency_control_over_noc'), 'name' =>
                        'enable_disable_agency_control_over_noc', 'route' => ''],
                    ['text' => __('labels.account_quote_view_any_where_listed_on_policy'), 'name' =>
                        'account_quote_view_any_where_listed_on_policy', 'route' => ''],
                    ['text' => __('labels.edit_refund_control'), 'name' => 'edit_refund_control', 'route' => ''],
                    ['text' => __('labels.edit_cross_collateral_account'), 'name' =>
                        'edit_cross_collateral_account', 'route' => ''],
                    ['text' => __('labels.delete_account'), 'name' => 'delete_account', 'route' => ''],
                    ['text' => __('labels.view_unearned_premium'), 'name' => 'view_unearned_premium', 'route' => ''],
                    ['text' => __('labels.hold_payable'), 'name' => 'hold_payable', 'route' => ''],
                    ['text' => __('labels.void_payable_payment'), 'name' => 'void_payable_payment', 'route' => ''],
                    ['text' => __('labels.view_finance_charge_detail'), 'name' => 'view_finance_charge_detail', 'route' => ''],
                    ['text' => __('labels.edit_min_earned_percent'), 'name' => 'edit_min_earned_percent', 'route' => ''],
                    ['text' => __('labels.edit_recourse_amount'), 'name' => 'edit_recourse_amount', 'route' => ''],
                    ['text' => __('labels.change_insured'), 'name' => 'change_insured', 'route' => ''],
                    ['text' => __('labels.edit_payee_for_policy_payable'), 'name' =>
                        'edit_payee_for_policy_payable', 'route' => ''],
                    ['text' => __('labels.split_payables'), 'name' => 'split_payables', 'route' => ''],
                    ['text' => __('labels.ap_quote_allow_when_account_iis_not_current'), 'name' =>
                        'ap_quote_allow_when_account_iis_not_current', 'route' => ''],
                    ['text' => __('labels.view_general_ledger_per_account'), 'name' =>
                        'view_general_ledger_per_account', 'route' => ''],
                    ['text' => __('labels.view_processing_fee_on_the_account'), 'name' =>
                        'view_processing_fee_on_the_account', 'route' => ''],
                    ['text' => __('labels.edit_processing_fee_on_the_account'), 'name' =>
                        'edit_processing_fee_on_the_account', 'route' => ''],
                    ['text' => __('labels.edit_insured_ach'), 'name' => 'edit_insured_ach', 'route' => ''],
                    ['text' => __('labels.agency_lnsured_view_any_where_ga_is_listed_on_policy'), 'name' =>
                        'agency_lnsured_view_any_where_ga_is_listed_on_policy', 'route' => ''],
                    ['text' => __('labels.view_edit_setup_fee_payables_and_payments'), 'name' =>
                        'view_edit_setup_fee_payables_and_payments', 'route' => ''],
                    ['text' => __('labels.opt_out_of_add_on_product'), 'name' => 'opt_out_of_add_on_product', 'route' => ''],
                    ['text' => __('labels.view_account_write_off_recovery'), 'name' =>
                        'view_account_write_off_recovery', 'route' => ''],
                    ['text' => __('labels.view_policy_related_payables'), 'name' => 'view_policy_related_payables', 'route' => ''],
                    ['text' => __('labels.enter_payment_when_certified_funds_required'), 'name' =>
                        'enter_payment_when_certified_funds_required', 'route' => ''],
                    ['text' => __('labels.override_advance_due_date'), 'name' => 'override_advance_due_date', 'route' => ''],
                    ['text' => __('labels.reverse_payment'), 'name' => 'reverse_payment', 'route' => ''],
                    ['text' => __('labels.reverse_fees'), 'name' => 'reverse_fees', 'route' => ''],
                ],
            ],
            ["text" => __('labels.quote'),
                "key" => 'quote',
                "permissions" => [
                    ['text' => __('labels.new_quote'), 'name' => 'new_quote', 'route' => ''],
                    ['text' => __('labels.find_quote'), 'name' => 'find_quote', 'route' => ''],
                    ['text' => __('labels.issue_drafts_from_quote'), 'name' => 'issue_drafts_from_quote', 'route' => ''],
                    ['text' => __('labels.issue_drafts_to_agent'), 'name' => 'issue_drafts_to_agent', 'route' => ''],
                    ['text' => __('labels.add_notes'), 'name' => 'add_notes', 'route' => ''],
                    ['text' => __('labels.view_user_notes'), 'name' => 'view_user_notes', 'route' => ''],
                    ['text' => __('labels.view_agency_compensation'), 'name' => 'view_agency_compensation', 'route' => ''],
                    ['text' => __('labels.show_interest_rate_from_rate_table_on_quote'), 'name' =>
                        'show_interest_rate_from_rate_table_on_quote', 'route' => ''],
                    ['text' => __('labels.monitor_company_outstandings'), 'name' =>
                        'monitor_company_outstandings', 'route' => ''],
                    ['text' => __('labels.allow_minimum_earned_override'), 'name' =>
                        'allow_minimum_earned_override', 'route' => ''],
                    ['text' => __('labels.create_temporary_companies'), 'name' => 'create_temporary_companies', 'route' => ''],
                    ['text' => __('labels.choose_origination_state'), 'name' => 'choose_origination_state', 'route' => ''],
                    ['text' => __('labels.edit_agent_compensation'), 'name' => 'edit_agent_compensation', 'route' => ''],
                    ['text' => __('labels.quote_account_add_edit_additional_insured'), 'name' =>
                        'quote_account_add_edit_additional_insured', 'route' => ''],
                    ['text' => __('labels.edit_number_of_payments'), 'name' => 'edit_number_of_payments', 'route' => ''],
                    ['text' => __('labels.pre_approve_quotes'), 'name' => 'pre_approve_quotes', 'route' => ''],
                    ['text' => __('labels.view_pre_approvals_for_quotes'), 'name' =>
                        'view_pre_approvals_for_quotes', 'route' => ''],
                    ['text' => __('labels.edit_pre_approvals_for_quotes'), 'name' =>
                        'edit_pre_approvals_for_quotes', 'route' => ''],
                    ['text' => __('labels.copy'), 'name' => 'copy', 'route' => ''],
                    ['text' => __('labels.lower_interest_rate'), 'name' => 'lower_interest_rate', 'route' => ''],
                    ['text' => __('labels.retain_payments_during_activation'), 'name' =>
                        'retain_payments_during_activation', 'route' => ''],
                    ['text' => __('labels.always_allow_equal_payments'), 'name' => 'always_allow_equal_payments', 'route' => ''],
                    ['text' => __('labels.allow_print_agreement_if_past_due'), 'name' =>
                        'allow_print_agreement_if_past_due', 'route' => ''],
                    ['text' => __('labels.edit_base_buy_rate'), 'name' => 'edit_base_buy_rate', 'route' => ''],
                    ['text' => __('labels.edit_territories'), 'name' => 'edit_territories', 'route' => ''],
                    ['text' => __('labels.edit_private_labels'), 'name' => 'edit_private_labels', 'route' => ''],
                    ['text' => __('labels.edit_funding_delay_tables'), 'name' => 'edit_funding_delay_tables', 'route' => ''],
                    ['text' => __('labels.edit_prime_rates'), 'name' => 'edit_prime_rates', 'route' => ''],
                    ['text' => __('labels.edit_compensation_tables'), 'name' => 'edit_compensation_tables', 'route' => ''],
                    ['text' => __('labels.edit_coverage_types'), 'name' => 'edit_coverage_types', 'route' => ''],
                    ['text' => __('labels.request_exception'), 'name' => 'request_exception', 'route' => ''],
                    ['text' => __('labels.fund_other'), 'name' => 'fund_other', 'route' => ''],
                    ['text' => __('labels.show_rate_table'), 'name' => 'show_rate_table', 'route' => ''],
                    ['text' => __('labels.view_compensation_table_name'), 'name' =>
                        'view_compensation_table_name', 'route' => ''],
                    ['text' => __('labels.allow_user_to_esignature'), 'name' => 'allow_user_to_esignature', 'route' => ''],
                    ['text' => __('labels.edit_remittance_date'), 'name' => 'edit_remittance_date', 'route' => ''],
                    ['text' => __('labels.edit_first_payment_due_date'), 'name' => 'edit_first_payment_due_date', 'route' => ''],
                    ['text' => __('labels.create_permanent_companies'), 'name' => 'create_permanent_companies', 'route' => ''],
                    ['text' => __('labels.ap_quote_edit_payment_terms'), 'name' =>
                        'ap_quote_edit_payment_terms', 'route' => ''],
                    ['text' => __('labels.move_to_in_progress_status'), 'name' => 'move_to_in_progress_status', 'route' => ''],
                    ['text' => __('labels.move_to_void_status'), 'name' => 'move_to_void_status', 'route' => ''],
                    ['text' => __('labels.ap_quote_edit_policy_expiration_date'), 'name' =>
                        'ap_quote_edit_policy_expiration_date', 'route' => ''],
                    ['text' => __('labels.view_exposure'), 'name' => 'view_exposure', 'route' => ''],
                    ['text' => __('labels.quote_edit_policy_cancel_terms'), 'name' =>
                        'quote_edit_policy_cancel_terms', 'route' => ''],
                    ['text' => __('labels.view_general_system_notes'), 'name' => 'view_general_system_notes', 'route' => ''],
                    ['text' => __('labels.view_compensation_system_notes'), 'name' =>
                        'view_compensation_system_notes', 'route' => ''],
                    ['text' => __('labels.view_processing_fee_on_the_quote_end_during_quote_activation'), 'name' =>
                        'view_processing_fee_on_the_quote_end_during_quote_activation', 'route' => ''],
                    ['text' => __('labels.override_processing_fee_on_the_quote'), 'name' =>
                        'override_processing_fee_on_the_quote', 'route' => ''],
                    ['text' => __('labels.edit_processing_fee_during_quote_activation'), 'name' =>
                        'edit_processing_fee_during_quote_activation', 'route' => ''],
                    ['text' => __('labels.edit_insured_ach'), 'name' => 'edit_insured_ach', 'route' => ''],
                    ['text' => __('labels.issue_drafts_between_net_and_gross'), 'name' =>
                        'issue_drafts_between_net_and_gross', 'route' => ''],
                    ['text' => __('labels.delete_quote'), 'name' => 'delete_quote', 'route' => ''],
                    ['text' => __('labels.enable_shortrate_checkbox'), 'name' => 'enable_shortrate_checkbox', 'route' => ''],
                    ['text' => __('labels.delete_version_of_quote'), 'name' => 'delete_version_of_quote', 'route' => ''],
                    ['text' => __('labels.delete_expired_quotes'), 'name' => 'delete_expired_quotes', 'route' => ''],
                    ['text' => __('labels.edit_recourse_amount'), 'name' => 'edit_recourse_amount', 'route' => ''],
                    ['text' => __('labels.billing_schedule'), 'name' => 'billing_schedule', 'route' => ''],
                    ['text' => __('labels.request_e_signatures'), 'name' => 'request_e_signatures', 'route' => ''],
                    ['text' => __('labels.enter_down_payments_before_activation_and_activation_review'), 'name' =>
                        'enter_down_payments_before_activation_and_activation_review', 'route' => ''],
                    ['text' => __('labels.view_edit_effective_date'), 'name' => 'view_edit_effective_date', 'route' => ''],
                    ['text' => __('labels.edit_interest_rate'), 'name' => 'edit_interest_rate', 'route' => ''],
                    ['text' => __('labels.adjust_setup_fee'), 'name' => 'adjust_setup_fee', 'route' => ''],
                    ['text' => __('labels.request_for_activation'), 'name' => 'request_for_activation', 'route' => ''],
                ],
            ],

            [
                "text" => __('labels.setting_quote'),
                "key" => 'setting_quote',
                "permissions" => [
                    ['text' => __('labels.view_rate_tables'), 'name' => 'view_rate_tables', 'route' => ''],
                    ['text' => __('labels.edit_rate_tables'), 'name' => 'edit_rate_tables', 'route' => ''],
                    ['text' => __('labels.view_down_payment_rules'), 'name' => 'view_down_payment_rules', 'route' => ''],
                    ['text' => __('labels.edit_down_payment_rules'), 'name' => 'edit_down_payment_rules', 'route' => ''],
                    ['text' => __('labels.edit_policy_cancel_term_options_list'), 'name' =>
                        'edit_policy_cancel_term_options_list', 'route' => ''],
                ],
            ],
            [
                "text" => __('labels.entity'),
                "key" => 'entity',
                "permissions" => [
                    ['text' => __('labels.find_edit_agents'), 'name' => 'find_edit_agents', 'route' => ''],
                    ['text' => __('labels.find_insureds'), 'name' => 'find_insureds', 'route' => ''],
                    ['text' => __('labels.find_finance_company_users'), 'name' => 'find_finance_company_users', 'route' => ''],
                    ['text' => __('labels.find_view_agents'), 'name' => 'find_view_agents', 'route' => ''],
                    ['text' => __('labels.find_edit_companies'), 'name' => 'find_edit_companies', 'route' => ''],
                    ['text' => __('labels.find_view_insurance_companies'), 'name' =>
                        'find_view_insurance_companies', 'route' => ''],
                    ['text' => __('labels.findlview_general_agencies'), 'name' => 'findlview_general_agencies', 'route' => ''],
                    ['text' => __('labels.find_view_lienholder_companies'), 'name' =>
                        'find_view_lienholder_companies', 'route' => ''],
                    ['text' => __('labels.find_view_sales_organizations'), 'name' =>
                        'find_view_sales_organizations', 'route' => ''],
                    ['text' => __('labels.find_view_other_companies'), 'name' => 'find_view_other_companies', 'route' => ''],
                    ['text' => __('labels.company_edit_temporary_status'), 'name' =>
                        'company_edit_temporary_status', 'route' => ''],
                    ['text' => __('labels.company_delete'), 'name' => 'company_delete', 'route' => ''],
                    ['text' => __('labels.edit_company_defaults'), 'name' => 'edit_company_defaults', 'route' => ''],
                    ['text' => __('labels.view_company_notes'), 'name' => 'view_company_notes', 'route' => ''],
                    ['text' => __('labels.add_company_notes'), 'name' => 'add_company_notes', 'route' => ''],
                    ['text' => __('labels.edit_insured'), 'name' => 'edit_insured', 'route' => ''],
                    ['text' => __('labels.insured_edit_credit_report'), 'name' =>
                        'insured_edit_credit_report', 'route' => ''],
                    ['text' => __('labels.view_alert_notes'), 'name' => 'view_alert_notes', 'route' => ''],
                    ['text' => __('labels.insured_edit_notes'), 'name' => 'insured_edit_notes', 'route' => ''],
                    ['text' => __('labels.insured_view_edit_ofac_compliance'), 'name' =>
                        'insured_view_edit_ofac_compliance', 'route' => ''],
                    ['text' => __('labels.edit_insured_ein'), 'name' => 'edit_insured_ein', 'route' => ''],
                    ['text' => __('labels.view_feiwssn_last_four_digits'), 'name' =>
                        'view_feiwssn_last_four_digits', 'route' => ''],
                    ['text' => __('labels.edit_agency_tax_id'), 'name' => 'edit_agency_tax_id', 'route' => ''],
                    ['text' => __('labels.view_fein_ssn_all_digits'), 'name' => 'view_fein_ssn_all_digits', 'route' => ''],
                    ['text' => __('labels.view_unmasked_insured_ach_bank_account_number'), 'name' =>
                        'view_unmasked_insured_ach_bank_account_number', 'route' => ''],
                    ['text' => __('labels.view_partial_masked_insured_ach_bank_account_number'), 'name' =>
                        'view_partial_masked_insured_ach_bank_account_number', 'route' => ''],
                    ['text' => __('labels.view_agency_tax_id'), 'name' => 'view_agency_tax_id', 'route' => ''],
                    ['text' => __('labels.add_remove_agent_ranking_list'), 'name' =>
                        'add_remove_agent_ranking_list', 'route' => ''],
                    ['text' => __('labels.view_company_tax_id'), 'name' => 'view_company_tax_id', 'route' => ''],
                    ['text' => __('labels.edit_company_tax_id'), 'name' => 'edit_company_tax_id', 'route' => ''],
                    ['text' => __('labels.view_company_status'), 'name' => 'view_company_status', 'route' => ''],
                    ['text' => __('labels.edit_company_status'), 'name' => 'edit_company_status', 'route' => ''],
                    ['text' => __('labels.find_view_vendors'), 'name' => 'find_view_vendors', 'route' => ''],
                    ['text' => __('labels.edit_vendors'), 'name' => 'edit_vendors', 'route' => ''],
                    ['text' => __('labels.approve_agencies'), 'name' => 'approve_agencies', 'route' => ''],
                ],
            ],
            [
                "text" => __('labels.user'),
                "key" => 'user',
                "permissions" => [
                    ['text' => __('labels.find_edit_sales_execs'), 'name' => 'find_edit_sales_execs', 'route' => ''],
                    ['text' => __('labels.add_edit_users'), 'name' => 'add_edit_users', 'route' => ''],
                    ['text' => __('labels.edit_user_profile'), 'name' => 'edit_user_profile', 'route' => ''],
                    ['text' => __('labels.edit_user_passwords'), 'name' => 'edit_user_passwords', 'route' => ''],
                    ['text' => __('labels.edit_user_tax_id'), 'name' => 'edit_user_tax_id', 'route' => ''],
                    ['text' => __('labels.add_edit_insured_users'), 'name' => 'add_edit_insured_users', 'route' => ''],
                    ['text' => __('labels.add_edit_agent_users'), 'name' => 'add_edit_agent_users', 'route' => ''],
                    ['text' => __('labels.add_edit_general_agent_users'), 'name' =>
                        'add_edit_general_agent_users', 'route' => ''],
                    ['text' => __('labels.add_edit_sales_exec_users'), 'name' => 'add_edit_sales_exec_users', 'route' => ''],
                    ['text' => __('labels.add_edit_finance_company_users'), 'name' =>
                        'add_edit_finance_company_users', 'route' => ''],
                ],
            ],
            [
                "text" => __('labels.state'),
                "key" => 'state',
                "permissions" => [
                    ['text' => __('labels.view_state_settings'), 'name' => 'view_state_settings', 'route' => ''],
                    ['text' => __('labels.edit_state_settings'), 'name' => 'edit_state_settings', 'route' => ''],
                ]],
            [
                "text" => __('labels.general'),
                "key" => 'general',
                "permissions" => [
                    ['text' => __('labels.edit_navigation_settings'), 'name' => 'edit_navigation_settings', 'route' => ''],
                    ['text' => __('labels.access_support_center'), 'name' => 'access_support_center', 'route' => ''],
                    ['text' => __('labels.schedule_tasks'), 'name' => 'schedule_tasks', 'route' => ''],
                    ['text' => __('labels.view_edit_processing_fee_table_controls'), 'name' =>
                        'view_edit_processing_fee_table_controls', 'route' => ''],
                    ['text' => __('labels.edit_other_fee_custom_type_tables'), 'name' =>
                        'edit_other_fee_custom_type_tables', 'route' => ''],
                    ['text' => __('labels.edit_finance_agreement'), 'name' => 'edit_finance_agreement', 'route' => ''],
                    ['text' => __('labels.overwrite_state_field'), 'name' => 'overwrite_state_field', 'route' => ''],
                ]],
            [
                "text" => __('labels.processing'),
                "key" => 'processing',
                "permissions" => [
                    ['text' => __('labels.daily_notices'), 'name' => 'daily_notices', 'route' => ''],
                    ['text' => __('labels.daily_account_update'), 'name' => 'daily_account_update', 'route' => ''],
                    ['text' => __('labels.daily_closing'), 'name' => 'daily_closing', 'route' => ''],
                    ['text' => __('labels.process_remittance'), 'name' => 'process_remittance', 'route' => ''],
                    ['text' => __('labels.enter_and_verify_payments'), 'name' => 'enter_and_verify_payments', 'route' => ''],
                    ['text' => __('labels.process_entered_payments'), 'name' => 'process_entered_payments', 'route' => ''],
                    ['text' => __('labels.imports_exports'), 'name' => 'imports_exports', 'route' => ''],
                    ['text' => __('labels.process_faxes'), 'name' => 'process_faxes', 'route' => ''],
                    ['text' => __('labels.generate_unearned_premium_statements'), 'name' => 'generate_unearned_premium_statements', 'route' => ''],
                    ['text' => __('labels.generate_recurring_payments'), 'name' => 'generate_recurring_payments', 'route' => ''],
                    ['text' => __('labels.email_queue'), 'name' => 'email_queue', 'route' => ''],
                    ['text' => __('labels.enter_vendor_payables'), 'name' => 'enter_vendor_payables', 'route' => ''],
                    ['text' => __('labels.process_vendors_payables'), 'name' => 'process_vendors_payables', 'route' => ''],
                    ['text' => __('labels.void_vendor_payables'), 'name' => 'void_vendor_payables', 'route' => ''],
                    ['text' => __('labels.process_vendors_checks'), 'name' => 'process_vendors_checks', 'route' => ''],
                    ['text' => __('labels.payable_history'), 'name' => 'payable_history', 'route' => ''],
                ],
            ],

        ];
        return $arr;
    }

    public static function financeCompanyReports()
    {
        $arr = [
            [
                "text" => __('labels.accounting'),
                "key" => 'accounting',
                "permissions" => [
                    ['text' => __('labels.account_list_export'), 'name' => 'account_list_export', 'route' => ''],
                    ['text' => __('labels.account_pay_offs'), 'name' => 'account_pay_offs', 'route' => ''],
                    ['text' => __('labels.account_write_offs'), 'name' => 'account_write_offs', 'route' => ''],
                    ['text' => __('labels.accounts_overpaid'), 'name' => 'accounts_overpaid', 'route' => ''],
                    ['text' => __('labels.accounts_overview'), 'name' => 'accounts_overview', 'route' => ''],
                    ['text' => __('labels.accounts_with_earned_interest_but_no_receivables'), 'name' =>
                        'accounts_with_earned_interest_but_no_receivables', 'route' => ''],
                    ['text' => __('labels.activated_accounts'), 'name' => 'activated_accounts', 'route' => ''],
                    ['text' => __('labels.assessed_fees'), 'name' => 'assessed_fees', 'route' => ''],
                    ['text' => __('labels.balance_accounts'), 'name' => 'balance_accounts', 'route' => ''],
                    ['text' => __('labels.canceled_summary'), 'name' => 'canceled_summary', 'route' => ''],
                    ['text' => __('labels.cash_receipts'), 'name' => 'cash_receipts', 'route' => ''],
                    ['text' => __('labels.check_register'), 'name' => 'check_register', 'route' => ''],
                    ['text' => __('labels.company_statements_export'), 'name' =>
                        'company_statements_export', 'route' => ''],
                    ['text' => __('labels.company_statements_lookup_by_statement'), 'name' =>
                        'company_statements_lookup_by_statement', 'route' => ''],
                    ['text' => __('labels.company_statements_by_agent'), 'name' =>
                        'company_statements_by_agent', 'route' => ''],
                    ['text' => __('labels.daily_interest'), 'name' => 'daily_interest', 'route' => ''],
                    ['text' => __('labels.deposits'), 'name' => 'deposits', 'route' => ''],
                    ['text' => __('labels.down_payment_register'), 'name' => 'down_payment_register', 'route' => ''],
                    ['text' => __('labels.earned_interest'), 'name' => 'earned_interest', 'route' => ''],
                    ['text' => __('labels.earned_service_charges'), 'name' => 'earned_service_charges', 'route' => ''],
                    ['text' => __('labels.e_payment_processing_history'), 'name' =>
                        'e_payment_processing_history', 'route' => ''],
                    ['text' => __('labels.flat_cancellations'), 'name' => 'flat_cancellations', 'route' => ''],
                    ['text' => __('labels.florida_doc_stamp_fees'), 'name' => 'florida_doc_stamp_fees', 'route' => ''],
                    ['text' => __('labels.general_agent_earned_income'), 'name' =>
                        'general_agent_earned_income', 'route' => ''],
                    ['text' => __('labels.general_ledger'), 'name' => 'general_ledger', 'route' => ''],
                    ['text' => __('labels.management_summery'), 'name' => 'management_summery', 'route' => ''],
                    ['text' => __('labels.open_accounts_payable'), 'name' => 'open_accounts_payable', 'route' => ''],
                    ['text' => __('labels.open_accounts_payable_as_of_date'), 'name' =>
                        'open_accounts_payable_as_of_date', 'route' => ''],
                    ['text' => __('labels.open_accounts_receivable'), 'name' => 'open_accounts_receivable', 'route' => ''],
                    ['text' => __('labels.open_accounts_receivable_summary'), 'name' =>
                        'open_accounts_receivable_summary', 'route' => ''],
                    ['text' => __('labels.open_down_payment_receivables'), 'name' =>
                        'open_down_payment_receivables', 'route' => ''],
                    ['text' => __('labels.refunds_v_write_offs'), 'name' => 'refunds_v_write_offs', 'route' => ''],
                    ['text' => __('labels.trial_balance'), 'name' => 'trial_balance', 'route' => ''],
                    ['text' => __('labels.unearned_premium'), 'name' => 'unearned_premium', 'route' => ''],
                    ['text' => __('labels.find_view_chart_of_accounts'), 'name' =>
                        'find_view_chart_of_accounts', 'route' => ''],
                    ['text' => __('labels.edit_chart_of_accounts'), 'name' => 'edit_chart_of_accounts', 'route' => ''],
                    ['text' => __('labels.find_view_bank_accounts'), 'name' => 'find_view_bank_accounts', 'route' => ''],
                    ['text' => __('labels.edit_bank_accounts'), 'name' => 'edit_bank_accounts', 'route' => ''],
                ],
            ],
            [
                "text" => __('labels.collections'),
                "key" => 'collections',
                "permissions" => [
                    ['text' => __('labels.accounts_in_collection_status'), 'name' =>
                        'accounts_in_collection_status', 'route' => ''],
                    ['text' => __('labels.accounts_past_due_report'), 'name' => 'accounts_past_due_report', 'route' => ''],
                    ['text' => __('labels.aging_report'), 'name' => 'aging_report', 'route' => ''],
                    ['text' => __('labels.cancellation_aging'), 'name' => 'cancellation_aging', 'route' => ''],
                    ['text' => __('labels.cancellations'), 'name' => 'cancellations', 'route' => ''],
                    ['text' => __('labels.cancellations_without_future_suspense_note'), 'name' =>
                        'cancellations_without_future_suspense_note', 'route' => ''],
                    ['text' => __('labels.cancellations_by_installment_number'), 'name' =>
                        'cancellations_by_installment_number', 'route' => ''],
                    ['text' => __('labels.cancellations_without_confirmation'), 'name' =>
                        'cancellations_without_confirmation', 'route' => ''],
                    ['text' => __('labels.cancellations_without_remittance_to_company'), 'name' =>
                        'cancellations_without_remittance_to_company', 'route' => ''],
                    ['text' => __('labels.cancellations_reinstatements_by_insurance_company'), 'name' =>
                        'cancellations_reinstatements_by_insurance_company', 'route' => ''],
                    ['text' => __('labels.producer_unearned_commissions'), 'name' =>
                        'producer_unearned_commissions', 'route' => ''],
                ],
            ],
            [
                "text" => __('labels.company'),
                "key" => 'company',
                "permissions" => [
                  ['text' => __('labels.accounts_w_o_policy_numbers_by_general_agent'), 'name' =>
                  'accounts_w_o_policy_numbers_by_general_agent','route'=>''],
                  ['text' => __('labels.suspended_agents'), 'name' => 'suspended_agents','route'=>''],
                  ['text' => __('labels.suspended_general_agents'), 'name' => 'suspended_general_agents','route'=>''],
                  ['text' => __('labels.suspended_insurance_companies'), 'name' =>
                  'suspended_insurance_companies','route'=>''],
                ],
            ],
              [
              "text" => __('labels.daily'),
              "key" => 'daily',
              "permissions" => [
                    ['text' => __('labels.policies_waiting_for_carrier_acknowledgement'), 'name' =>
                    'policies_waiting_for_carrier_acknowledgement','route'=>''],
                    ['text' => __('labels.policies_waiting_for_premium_verification'), 'name' =>
                    'policies_waiting_for_premium_verification','route'=>''],
                    ['text' => __('labels.proof_of_mailing_cancel_notices'), 'name' => 'proof_of_mailing_cancel_notices','route'=>''],
                    ['text' => __('labels.proof_of_mailing_intent_notices'), 'name' => 'proof_of_mailing_intent_notices','route'=>''],
                    ['text' => __('labels.proof_of_mailing_new'), 'name' => 'proof_of_mailing_new','route'=>''],
              ],
            ],
             [
              "text" => __('labels.management'),
              "key" => 'management',
              "permissions" => [
                   ['text' => __('labels.account_status'), 'name' => 'account_status','route'=>''],
                   ['text' => __('labels.add_on_product_payments'), 'name' => 'add_on_product_payments','route'=>''],
                   ['text' => __('labels.add_on_product_status'), 'name' => 'add_on_product_status','route'=>''],
                   ['text' => __('labels.am_best_ratings'), 'name' => 'am_best_ratings','route'=>''],
                   ['text' => __('labels.assigned_risk_policies'), 'name' => 'assigned_risk_policies','route'=>''],
                   ['text' => __('labels.borrowing_base'), 'name' => 'borrowing_base','route'=>''],
                   ['text' => __('labels.companies_agencies_general_agents_report_with_export'), 'name' =>
                   'companies_agencies_general_agents_report_with_export','route'=>''],
                   ['text' => __('labels.compensation'), 'name' => 'compensation','route'=>''],
                   ['text' => __('labels.compensation_paid'), 'name' => 'compensation_paid','route'=>''],
                   ['text' => __('labels.down_payment_renewals'), 'name' => 'down_payment_renewals','route'=>''],
                   ['text' => __('labels.expected_revenue'), 'name' => 'expected_revenue','route'=>''],
                   ['text' => __('labels.ga_company_concentration'), 'name' =>
                   'ga_company_concentration','route'=>''],
                   ['text' => __('labels.imported_quotes_that_have_not_been_activated'), 'name' =>
                   'imported_quotes_that_have_not_been_activated','route'=>''],
                   ['text' => __('labels.management_exceptions'), 'name' => 'management_exceptions','route'=>''],
                   ['text' => __('labels.policy_list'), 'name' => 'policy_list','route'=>''],
                   ['text' => __('labels.portfolio_yield'), 'name' => 'portfolio_yield','route'=>''],
                   ['text' => __('labels.producer_list'), 'name' => 'producer_list','route'=>''],
                   ['text' => __('labels.production'), 'name' => 'production','route'=>''],
                   ['text' => __('labels.program_compensation_with_adjustments'), 'name' =>
                   'program_compensation_with_adjustments','route'=>''],
                   ['text' => __('labels.quote_listing'), 'name' => 'quote_listing','route'=>''],
                   ['text' => __('labels.quote_listing_2'), 'name' => 'quote_listing_2','route'=>''],
                   ['text' => __('labels.sales_executive_summary_report'), 'name' =>
                   'sales_executive_summary_report','route'=>''],
                   ['text' => __('labels.year_end'), 'name' => 'year_end','route'=>''],
                   ['text' => __('labels.year_end_summary'), 'name' => 'year_end_summary','route'=>''],
              ],
            ],
            [
             "text" => __('labels.producers'),
              "key" => 'producers',
              "permissions" => [
                   ['text' => __('labels.accounts_w_o_policy_numbers_by_agent'), 'name' =>
                   'accounts_w_o_policy_numbers_by_agent','route'=>''],
                   ['text' => __('labels.accounts_w_o_signed_agreements'), 'name' =>
                   'accounts_w_o_signed_agreements','route'=>''],
                   ['text' => __('labels.accounts_w_o_signed_agreements_by_agent'), 'name' =>
                   'accounts_w_o_signed_agreements_by_agent','route'=>''],
                   ['text' => __('labels.paid_late_charges'), 'name' => 'paid_late_charges','route'=>''],
                   ['text' => __('labels.pending_quotes_new'), 'name' => 'pending_quotes_new','route'=>''],
                   ['text' => __('labels.pending_quotes_by_agent_old'), 'name' =>
                   'pending_quotes_by_agent_old','route'=>''],
                   ['text' => __('labels.pending_quotes_with_an_attached_file_old'), 'name' =>
                   'pending_quotes_with_an_attached_file_old','route'=>''],
                   ['text' => __('labels.request_letters_for_agent_unearned_commissions'), 'name' =>
                   'request_letters_for_agent_unearned_commissions','route'=>''],
              ],
            ],
            [
             "text" => __('labels.risk_management'),
              "key" => 'risk_management',
              "permissions" => [
                 ['text' => __('labels.duplicate_insured_addresses'), 'name' =>
                 'duplicate_insured_addresses','route'=>''],
                 ['text' => __('labels.duplicate_insured_names'), 'name' => 'duplicate_insured_names','route'=>''],
                 ['text' => __('labels.insured_address'), 'name' => 'insured_address','route'=>''],
                 ['text' => __('labels.insured_payments'), 'name' => 'insured_payments','route'=>''],
                 ['text' => __('labels.processed_payments'), 'name' => 'processed_payments','route'=>''],
                 ['text' => __('labels.producer_aged_accounts_receivable_exception'), 'name' =>'producer_aged_accounts_receivable_exception','route'=>''],
              ],
            ],
             [
             "text" => __('labels.utility'),
              "key" => 'utility',
              "permissions" => [
                ['text' => __('labels.customer_usage_detail'), 'name' => 'customer_usage_detail','route'=>''],
                ['text' => __('labels.daily_login_logs'), 'name' => 'daily_login_logs','route'=>''],
                ['text' => __('labels.notes_audit_logs'), 'name' => 'notes_audit_logs','route'=>''],
                ['text' => __('labels.task_history'), 'name' => 'task_history','route'=>''],
                ['text' => __('labels.user_status'), 'name' => 'user_status','route'=>''],
              ],
            ],
        ];
        return $arr;
    }


    public static function  agentPermission(){

        $arr=[

                    [
                        "text" => __('labels.account_permissions'),
                        "key" => 'account_permissions',
                        "permissions"=>[
                            ['text' => __('labels.find_view_accounts'), 'name' => 'find_view_accounts', 'route' => ''],
                            ['text' => __('labels.find_view_attachments'), 'name' => 'find_view_attachments', 'route' => ''],
                            ['text' => __('labels.view_payment_schedule_history'), 'name' => 'view_payment_schedule_history', 'route' => ''],
                            ['text' => __('labels.view_notice_history'), 'name' => 'view_notice_history', 'route' => ''],
                            ['text' => __('labels.reprint_payment_letter'), 'name' => 'reprint_payment_letter', 'route' => ''],
                            ['text' => __('labels.reprint_payment_coupons'), 'name' => 'reprint_payment_coupons', 'route' => ''],
                            ['text' => __('labels.enter_payments'), 'name' => 'enter_payments', 'route' => ''],
                            ['text' => __('labels.enter_payment_when_certified_funds_required'), 'name' => 'enter_payment_when_certified_funds_required', 'route' => ''],
                            ['text' => __('labels.change_insured_payment_info'), 'name' => 'change_insured_payment_info', 'route' => ''],
                            ['text' => __('labels.view_policies'), 'name' => 'view_policies', 'route' => ''],
                            ['text' => __('labels.view_endorsement'), 'name' => 'view_endorsement', 'route' => ''],
                            ['text' => __('labels.view_quotes'), 'name' => 'view_quotes', 'route' => ''],
                            ['text' => __('labels.add_ap_quote'), 'name' => 'add_ap_quote', 'route' => ''],
                            ['text' => __('labels.edit_insured_ach'), 'name' => 'edit_insured_ach', 'route' => ''],
                            ['text' => __('labels.add_notes'), 'name' => 'add_notes', 'route' => ''],
                        ],
                    ],

                    [
                        "text" => __('labels.quote_permissions'),
                        "key" => 'quote_permissions',
                        "permissions"=>[
                            ['text' => __('labels.new_quote'), 'name' => 'new_quote', 'route' => ''],
                            ['text' => __('labels.find_quote'), 'name' => 'find_quote', 'route' => ''],
                            ['text' => __('labels.edit_quote'), 'name' => 'edit_quote', 'route' => ''],
                            ['text' => __('labels.copy_quote'), 'name' => 'copy_quote', 'route' => ''],
                            ['text' => __('labels.copy_version'), 'name' => 'copy_version', 'route' => ''],
                            ['text' => __('labels.delete_version_of_quote'), 'name' => 'delete_version_of_quote', 'route' => ''],
                            ['text' => __('labels.create_temporary_companies'), 'name' => 'create_temporary_companies', 'route' => ''],
                            ['text' => __('labels.view_add_notes'), 'name' => 'view_add_notes', 'route' => ''],
                            ['text' => __('labels.add_edit_additional_insureds'), 'name' => 'add_edit_additional_insureds', 'route' => ''],
                            ['text' => __('labels.add_edit_lienholders'), 'name' => 'add_edit_lienholders', 'route' => ''],
                            ['text' => __('labels.change_billing_schedule'), 'name' => 'change_billing_schedule', 'route' => ''],
                            ['text' => __('labels.quarterly_billing_schedule'), 'name' => 'quarterly_billing_schedule', 'route' => ''],
                            ['text' => __('labels.annual_billing_schedule'), 'name' => 'annual_billing_schedule', 'route' => ''],
                            ['text' => __('labels.edit_interest_rate'), 'name' => 'edit_interest_rate', 'route' => ''],
                            ['text' => __('labels.edit_number_of_payments'), 'name' => 'edit_number_of_payments', 'route' => ''],
                            ['text' => __('labels.view_quote_exposure'), 'name' => 'view_quote_exposure', 'route' => ''],
                            ['text' => __('labels.view_agency_compensation'), 'name' => 'view_agency_compensation', 'route' => ''],
                            ['text' => __('labels.allow_user_to_esignature'), 'name' => 'allow_user_to_esignature', 'route' => ''],
                            ['text' => __('labels.allow_print_agreement_if_past_due'), 'name' => 'allow_print_agreement_if_past_due', 'route' => ''],
                            ['text' => __('labels.request_e_signatures'), 'name' => 'request_e_signatures', 'route' => ''],
                            ['text' => __('labels.edit_first_payment_due_date'), 'name' => 'edit_first_payment_due_date', 'route' => ''],
                            ['text' => __('labels.lower_interest_rate'), 'name' => 'lower_interest_rate', 'route' => ''],
                        ]


                    ],
                    [
                        "text" => __('labels.entity_permissions'),
                        "key" => 'entity_permissions',
                        'permissions'=>[
                            ['text' => __('labels.edit_insured'), 'name' => 'edit_insured', 'route' => ''],
                            ['text' => __('labels.find_view_insured'), 'name' => 'find_view_insured', 'route' => ''],
                            ['text' => __('labels.edit_insured_ein'), 'name' => 'edit_insured_ein', 'route' => ''],
                        ]
                    ],

                    [
                        "text" => __('labels.group_user_permissions'),
                        "key" => 'group_user_permissions',
                        'permissions'=>[
                            ['text' => __('labels.find_view_users'), 'name' => 'find_view_users', 'route' => ''],
                            ['text' => __('labels.edit_user_profile'), 'name' => 'edit_user_profile', 'route' => ''],
                            ['text' => __('labels.enable_disable_inmail_access'), 'name' => 'enable_disable_inmail_access', 'route' => ''],
                            ['text' => __('labels.enable_disable_tasks_access'), 'name' => 'enable_disable_tasks_access', 'route' => ''],
                        ]
                    ],

            ];
        return $arr;

    }


    public static function agentReport(){
        $arr=[
            [
             "text" => __('labels.management'),
             "key" => 'management',
             "permissions"=>[
                ['text' => __('labels.add_on_product_payments'), 'name' => 'add_on_product_payments', 'route' => ''],
                ['text' => __('labels.add_on_product_status'), 'name' => 'add_on_product_status', 'route' => ''],
                ['text' => __('labels.agent_account_status'), 'name' => 'agent_account_status', 'route' => ''],
                ['text' => __('labels.agent_pending_cancellations'), 'name' => 'agent_pending_cancellations', 'route' => ''],
                ['text' => __('labels.agent_quote_listing'), 'name' => 'agent_quote_listing', 'route' => ''],
                ['text' => __('labels.policy_list'), 'name' => 'policy_list', 'route' => ''],
                ['text' => __('labels.production'), 'name' => 'production', 'route' => ''],
             ]

            ]

        ];
         return $arr;
    }


    public static function salesOrganizationsPermission(){
        $arr=[
            [
                "text" => __('labels.account'),
                "key" => 'account',
                "permissions"=>[
                    ['text' => __('labels.find_account'), 'name' => 'find_account', 'route' => ''],
                    ['text' => __('labels.account_quote_view_document_images'), 'name' => 'account_quote_view_document_images', 'route' => ''],
                    ['text' => __('labels.view_payment_schedule_history'), 'name' => 'view_payment_schedule_history', 'route' => ''],
                    ['text' => __('labels.view_notice_history'), 'name' => 'view_notice_history', 'route' => ''],
                    ['text' => __('labels.reprint_payment_letter'), 'name' => 'reprint_payment_letter', 'route' => ''],
                    ['text' => __('labels.reprint_payment_coupons'), 'name' => 'reprint_payment_coupons', 'route' => ''],
                    ['text' => __('labels.add_ap_endorsement_and_new_policy'), 'name' => 'add_ap_endorsement_and_new_policy', 'route' => ''],
                    ['text' => __('labels.view_notes'), 'name' => 'view_notes', 'route' => ''],
                    ['text' => __('labels.enter_return_premium_commission'), 'name' => 'enter_return_premium_commission', 'route' => ''],
                    ['text' => __('labels.process_entered_payments'), 'name' => 'process_entered_payments', 'route' => ''],
                    ['text' => __('labels.enter_payments'), 'name' => 'enter_payments', 'route' => ''],
                    ['text' => __('labels.flat_cancel'), 'name' => 'flat_cancel', 'route' => ''],
                    ['text' => __('labels.suspend_unsuspend'), 'name' => 'suspend_unsuspend', 'route' => ''],
                    ['text' => __('labels.edit_policy_related_payables'), 'name' => 'edit_policy_related_payables', 'route' => ''],
                    ['text' => __('labels.change_insured_payment_info'), 'name' => 'change_insured_payment_info', 'route' => ''],
                    ['text' => __('labels.view_policy'), 'name' => 'view_policy', 'route' => ''],
                    ['text' => __('labels.view_endorsement'), 'name' => 'view_endorsement', 'route' => ''],
                    ['text' => __('labels.update_department_code'), 'name' => 'update_department_code', 'route' => ''],
                    ['text' => __('labels.issue_drafts_prior_to_effective_date'), 'name' => 'issue_drafts_prior_to_effective_date', 'route' => ''],
                    ['text' => __('labels.account_quote_view_any_where_listed_on_policy'), 'name' => 'account_quote_view_any_where_listed_on_policy', 'route' => ''],
                    ['text' => __('labels.view_unearned_premium'), 'name' => 'view_unearned_premium', 'route' => ''],
                    ['text' => __('labels.view_finance_charge_detail'), 'name' => 'view_finance_charge_detail', 'route' => ''],
                    ['text' => __('labels.ap_quote_allow_when_account_is_not_current'), 'name' => 'ap_quote_allow_when_account_is_not_current', 'route' => ''],
                    ['text' => __('labels.edit_insured_ach'), 'name' => 'edit_insured_ach', 'route' => ''],
                    ['text' => __('labels.agency_lnsured_view_any_where_ga_is_listed_on_policy'), 'name' => 'agency_lnsured_view_any_where_ga_is_listed_on_policy', 'route' => ''],
                    ['text' => __('labels.opt_out_of_add_on_product'), 'name' => 'opt_out_of_add_on_product', 'route' => ''],
                    ['text' => __('labels.view_policy_related_payables'), 'name' => 'view_policy_related_payables', 'route' => ''],
                    ['text' => __('labels.enter_payment_when_certified_funds_required'), 'name' => 'enter_payment_when_certified_funds_required', 'route' => ''],
                    ['text' => __('labels.override_advance_due_date'), 'name' => 'override_advance_due_date', 'route' => ''],
                    ['text' => __('labels.override_request_reinstatement'), 'name' => 'override_request_reinstatement', 'route' => ''],
                    ['text' => __('labels.account_quote_policy_viewledit_details_of_policies_belonging_to_other_general_agents'), 'name' => 'account_quote_policy_viewledit_details_of_policies_belonging_to_other_general_agents', 'route' => ''],
                ]

                ],
                [
                    "text" => __('labels.quote'),
                    "key" => 'quote',
                    "permissions"=>[
                        ['text' => __('labels.quick_quote'), 'name' => 'quick_quote', 'route' => ''],
                        ['text' => __('labels.new_quote'), 'name' => 'new_quote', 'route' => ''],
                        ['text' => __('labels.find_quote'), 'name' => 'find_quote', 'route' => ''],
                        ['text' => __('labels.issue_drafts_from_quote'), 'name' => 'issue_drafts_from_quote', 'route' => ''],
                        ['text' => __('labels.issue_drafts_to_agent'), 'name' => 'issue_drafts_to_agent', 'route' => ''],
                        ['text' => __('labels.add_notes'), 'name' => 'add_notes', 'route' => ''],
                        ['text' => __('labels.view_user_notes'), 'name' => 'view_user_notes', 'route' => ''],
                        ['text' => __('labels.view_agency_compensation'), 'name' => 'view_agency_compensation', 'route' => ''],
                        ['text' => __('labels.show_interest_rate_from_rate_table_on_quote'), 'name' => 'show_interest_rate_from_rate_table_on_quote', 'route' => ''],
                        ['text' => __('labels.create_temporary_companies'), 'name' => 'create_temporary_companies', 'route' => ''],
                        ['text' => __('labels.choose_origination_state'), 'name' => 'choose_origination_state', 'route' => ''],
                        ['text' => __('labels.quote_account_add_edit_additional_insured'), 'name' => 'quote_account_add_edit_additional_insured', 'route' => ''],
                        ['text' => __('labels.edit_number_of_payments'), 'name' => 'edit_number_of_payments', 'route' => ''],
                        ['text' => __('labels.copy'), 'name' => 'copy', 'route' => ''],
                        ['text' => __('labels.lower_interest_rate'), 'name' => 'lower_interest_rate', 'route' => ''],
                        ['text' => __('labels.retain_payments_during_activation'), 'name' => 'retain_payments_during_activation', 'route' => ''],
                        ['text' => __('labels.allow_print_agreement_if_past_due'), 'name' => 'allow_print_agreement_if_past_due', 'route' => ''],
                        ['text' => __('labels.request_exception'), 'name' => 'request_exception', 'route' => ''],
                        ['text' => __('labels.show_rate_table'), 'name' => 'show_rate_table', 'route' => ''],
                        ['text' => __('labels.view_compensation_table_name'), 'name' => 'view_compensation_table_name', 'route' => ''],
                        ['text' => __('labels.allow_user_to_esignature'), 'name' => 'allow_user_to_esignature', 'route' => ''],
                        ['text' => __('labels.edit_first_payment_due_date'), 'name' => 'edit_first_payment_due_date', 'route' => ''],
                        ['text' => __('labels.create_permanent_companies'), 'name' => 'create_permanent_companies', 'route' => ''],
                        ['text' => __('labels.ap_quote_edit_payment_terms'), 'name' => 'ap_quote_edit_payment_terms', 'route' => ''],
                        ['text' => __('labels.move_to_in_progress_status'), 'name' => 'move_to_in_progress_status', 'route' => ''],
                        ['text' => __('labels.move_to_void_status'), 'name' => 'move_to_void_status', 'route' => ''],
                        ['text' => __('labels.ap_quote_edit_policy_expiration_date'), 'name' => 'ap_quote_edit_policy_expiration_date', 'route' => ''],
                        ['text' => __('labels.quote_edit_policy_cancel_terms'), 'name' => 'quote_edit_policy_cancel_terms', 'route' => ''],
                        ['text' => __('labels.view_general_system_notes'), 'name' => 'view_general_system_notes', 'route' => ''],
                        ['text' => __('labels.view_compensation_system_notes'), 'name' => 'view_compensation_system_notes', 'route' => ''],
                        ['text' => __('labels.view_processing_fee_on_the_quote_end_during_quote_activation'), 'name' => 'view_processing_fee_on_the_quote_end_during_quote_activation', 'route' => ''],
                        ['text' => __('labels.edit_insured_ach'), 'name' => 'edit_insured_ach', 'route' => ''],
                        ['text' => __('labels.issue_drafts_between_net_and_gross'), 'name' => 'issue_drafts_between_net_and_gross', 'route' => ''],
                        ['text' => __('labels.enable_shortrate_checkbox'), 'name' => 'enable_shortrate_checkbox', 'route' => ''],
                        ['text' => __('labels.delete_version_of_quote'), 'name' => 'delete_version_of_quote', 'route' => ''],
                        ['text' => __('labels.edit_recourse_amount'), 'name' => 'edit_recourse_amount', 'route' => ''],
                        ['text' => __('labels.billing_schedule'), 'name' => 'billing_schedule', 'route' => ''],
                        ['text' => __('labels.request_e_signatures'), 'name' => 'request_e_signatures', 'route' => ''],
                        ['text' => __('labels.enter_down_payments_before_activation_and_activation_review'), 'name' => 'enter_down_payments_before_activation_and_activation_review', 'route' => ''],
                    ]
                    ],
                [
                    "text" => __("labels.setting_quote"),
                    "key" => 'setting_quote',
                    "permissions"=>[
                        ['text' => __('labels.view_rate_tables'), 'name' => 'view_rate_tables', 'route' => ''],
                        ['text' => __('labels.edit_rate_tables'), 'name' => 'edit_rate_tables', 'route' => ''],
                        ['text' => __('labels.view_down_payment_rules'), 'name' => 'view_down_payment_rules', 'route' => ''],
                        ['text' => __('labels.edit_down_payment_rules'), 'name' => 'edit_down_payment_rules', 'route' => ''],
                    ]

                ],

                [
                    "text" => __('labels.setting').' '.__("labels.entity"),
                    "key" => 'entity',
                    "permissions"=>[
                        ['text' => __('labels.find_edit_agents'), 'name' => 'find_edit_agents', 'route' => ''],
                        ['text' => __('labels.find_view_agents'), 'name' => 'find_view_agents', 'route' => ''],
                        ['text' => __('labels.find_view_insurance_companies'), 'name' => 'find_view_insurance_companies', 'route' => ''],
                        ['text' => __('labels.findlview_general_agencies'), 'name' => 'findlview_general_agencies', 'route' => ''],
                        ['text' => __('labels.find_view_lienholder_companies'), 'name' => 'find_view_lienholder_companies', 'route' => ''],
                        ['text' => __('labels.view_company_notes'), 'name' => 'view_company_notes', 'route' => ''],
                        ['text' => __('labels.add_company_notes'), 'name' => 'add_company_notes', 'route' => ''],
                        ['text' => __('labels.edit_insured'), 'name' => 'edit_insured', 'route' => ''],
                        ['text' => __('labels.insured_edit_credit_report'), 'name' => 'insured_edit_credit_report', 'route' => ''],
                        ['text' => __('labels.view_alert_notes'), 'name' => 'view_alert_notes', 'route' => ''],
                        ['text' => __('labels.insured_view_edit_ofac_compliance'), 'name' => 'insured_view_edit_ofac_compliance', 'route' => ''],
                        ['text' => __('labels.edit_insured_ein'), 'name' => 'edit_insured_ein', 'route' => ''],
                        ['text' => __('labels.view_feiwssn_last_four_digits'), 'name' => 'view_feiwssn_last_four_digits', 'route' => ''],
                        ['text' => __('labels.edit_agency_tax_id'), 'name' => 'edit_agency_tax_id', 'route' => ''],
                        ['text' => __('labels.view_fein_ssn_all_digits'), 'name' => 'view_fein_ssn_all_digits', 'route' => ''],
                        ['text' => __('labels.view_unmasked_insured_ach_bank_account_number'), 'name' => 'view_unmasked_insured_ach_bank_account_number', 'route' => ''],
                        ['text' => __('labels.view_agency_tax_id'), 'name' => 'view_agency_tax_id', 'route' => ''],

                    ]

                ],
                [
                    "text" => __('labels.setting').' '.__('labels.users'),
                    "key" => 'users',
                    "permissions"=>[
                        ['text' => __('labels.edit_user_profile'), 'name' => 'edit_user_profile', 'route' => ''],
                    ]

                ],
                [
                    "text" => __('labels.setting').' '.__('labels.general'),
                    "key" => 'general',
                    "permissions"=>[
                        ['text' => __('labels.overwrite_state_field'), 'name' => 'overwrite_state_field', 'route' => ''],
                    ]

                ],
        ];
        return $arr;

    }

    public static function salesReport(){
        $arr=[
            [
                "text" => __('labels.management'),
                "key" => 'management',
                "permissions"=>[
                    ['text' => __('labels.add_on_product_payments'), 'name' => 'add_on_product_payments', 'route' => ''],
                    ['text' => __('labels.add_on_product_status'), 'name' => 'add_on_product_status', 'route' => ''],
                    ['text' => __('labels.policy_list'), 'name' => 'policy_list', 'route' => ''],
                    ['text' => __('labels.production'), 'name' => 'production', 'route' => ''],
                    ['text' => __('labels.program_compensation_with_adjustments'), 'name' => 'program_compensation_with_adjustments', 'route' => ''],
                    ['text' => __('labels.quote_listing'), 'name' => 'quote_listing', 'route' => ''],
                    ['text' => __('labels.sales_executive_summary_report'), 'name' => 'sales_executive_summary_report', 'route' => ''],
                ]
            ],
            [
                "text" => __('labels.utility'),
                "key" => 'utility',
                "permissions"=>[
                    ['text' => __('labels.daily_login_logs'), 'name' => 'daily_login_logs', 'route' => ''],
                ]

            ],
        ];
        return $arr;
    }


    public static function insurdsPermission(){
        $arr=[
            [
                "text" => __('labels.reprint_payment_letter'),
                "key" => 'account',
                "permissions"=>[
                    ['text' => __('labels.enable'), 'name' => 'reprint_payment_letter', 'route' => '','value' => 'enable','block'=>false, 'class'=>'checkboxradio'],
                    ['text' => __('labels.disable'), 'name' => 'reprint_payment_letter', 'route' => '','value' => 'disable','block'=>false,'class'=>'checkboxradio']
                
                ]

            ],
            [
                "text" => __('labels.reprint_payment_coupons'),
                "key" => 'account',
                "permissions"=>[
                    ['text' => __('labels.enable'), 'name' => 'reprint_payment_coupons', 'route' => '','value' => 'enable','block'=>false, 'class'=>'checkboxradio'],
                    ['text' => __('labels.disable'), 'name' => 'reprint_payment_coupons', 'route' => '','value' => 'disable','block'=>false, 'class'=>'checkboxradio'],

                ]

            ],

            [
                "text" => __('labels.change_insured_payment_info'),
                "key" => 'entity',
                "permissions"=>[
                    ['text' => __('labels.enable'), 'name' => 'change_insured_payment_info', 'route' => '','value' => 'enable','block'=>false, 'class'=>'checkboxradio'],
                    ['text' => __('labels.disable'), 'name' => 'change_insured_payment_info', 'route' => '','value' => 'disable','block'=>false, 'class'=>'checkboxradio',]
                ]
            ],

            [
                "text" => __('labels.view_partial_masked_insured_ach_bank_account_number'),
                "key" => 'users',
                "permissions"=>[
                    ['text' => __('labels.enable'), 'name' => 'view_partial_masked_insured_ach_bank_account_number', 'route' => '','value' => 'enable','block'=>false, 'class'=>'checkboxradio'],
                    ['text' => __('labels.disable'), 'name' => 'view_partial_masked_insured_ach_bank_account_number', 'route' => '','value' => 'disable','block'=>false, 'class'=>'checkboxradio'],
                ]
            ],

            [
                "text" => __('labels.edit_user_profile'),
                "key" => 'general',
                "permissions"=>[
                    ['text' => __('labels.enable'), 'name' => 'edit_user_profile', 'route' => '','value' => 'enable','block'=>false, 'class'=>'checkboxradio'],
                    ['text' => __('labels.disable'), 'name' => 'edit_user_profile', 'route' => '','value' => 'disable','block'=>false, 'class'=>'checkboxradio'],
                ]
            ],
        ];
        return $arr;
    }



}
