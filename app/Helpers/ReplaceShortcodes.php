<?php

namespace App\Helpers;

use App\Models\Company;
use App\Models\FinanceAgreement;

use App\Models\Quote;
use App\Models\QuoteSignature;
use App\Models\QuoteVersion;
use App\Models\User;
use DBHelper;
use DOMDocument;
use Error;
use Str;

class ReplaceShortcodes
{

    /*
     * Company Template Replace Shortcodes
     */

    public static function companyTemplate($template, $companyData = null, $extData = null)
    {

        //   dd($companyData,$companyData->user);
        if (empty($template)) {
            throw new Error("template Data Empty");
        }

        if (empty($companyData)) {
            throw new Error("Company Data Empty");
        }

        $imageUrl = asset("assets/images/enetworks-cloud-computing-94.png");
        $logoUrl = !empty($companyData?->comp_logo_url) ? $companyData?->comp_logo_url : '';
        $logoUrl = (!empty($logoUrl) && urlExists($logoUrl)) ? $logoUrl : $imageUrl;
        $image = "<img src='{$imageUrl}' alt='not image found'>";
        $template = Str::of($template)
            ->replace('{Premium_Finance_Company_Name}', $companyData?->comp_name)
            ->replace('{Premium_Finance_Company_Address}', $companyData?->primary_address)
            ->replace('{Premium_Finance_Company_City}', $companyData?->primary_address_city)
            ->replace('{Premium_Finance_Company_State}', $companyData?->primary_address_state)
            ->replace('{Premium_Finance_Company_Zip}', $companyData?->primary_address_zip)
            ->replace('{Premium_Finance_Company_Telephone}', $companyData?->primary_telephone)
            ->replace('{Premium_Finance_Company_Alternate_Telephone}', $companyData?->alternate_telephone)
            ->replace('{Sales_Organization_Logo}', $image)
            ->replace('{Premium_Finance_Company_Logo}', $logoUrl)
            ->replace('{Premium_Finance_Company_Fax}', $companyData?->fax)
            ->replace('{Premium_Finance_Company_Email}', $companyData?->comp_contact_email)
            ->replace('{Payment_coupons_invoices_statement_address}', $companyData?->payment_coupons_address)
            ->replace('{Payment_coupons_invoices_statement_city}', $companyData?->payment_coupons_city)
            ->replace('{Payment_coupons_invoices_statement_state}', $companyData?->payment_coupons_state)
            ->replace('{Payment_coupons_invoices_statement_zip}', $companyData?->payment_coupons_zip)
            ->replace('{Premium_Finance_Company_Contact_Name}', $companyData?->company_contact_name)
            ->replace('{Premium_Finance_Company_Office_Location}', $companyData?->office_location)
            ->replace('{Premium_Finance_Company_Licenses}', $companyData?->comp_licenses)
            ->replace('{Premium_Finance_Company_State_Licensed}', $companyData?->comp_state_licensed)
            ->replace('{Premium_Finance_Company_From_Fax_Email}', $companyData?->companyFaxSettings?->fax_email)
            ->replace('{Premium_Finance_Company_Server_Email_Address_Domain}', $companyData?->companyFaxSettings?->server_email)
            ->replace('{Premium_Finance_Company_Fax_Server_Domain_Name}', $companyData?->companyFaxSettings?->server_email_domain)
            ->replace('{Premium_Finance_Company_Signed_agreement_Fax_1}', $companyData?->companyFaxSettings?->signed_agreement_fax_one)
            ->replace('{Premium_Finance_Company_Signed_agreement_Fax_2}', $companyData?->companyFaxSettings?->signed_agreement_fax_two)
            ->replace('{Premium_Finance_Company_Entity_Fax_Numbers_1}', $companyData?->companyFaxSettings?->attachment_fax_one)
            ->replace('{Premium_Finance_Company_Entity_Fax_Numbers_2}', $companyData?->companyFaxSettings?->attachment_fax_two)
            ->replace('{Premium_Finance_Company_Forward_Incoming_Faxes}', $companyData?->companyFaxSettings?->forward_incoming_faxes)
            ->replace('{Premium_Finance_Company_CAN_SPAM_Notice}', $companyData?->companyFaxSettings?->can_spam_notice)
            ->replace('{Premium_Finance_Company_Copyright_Notice}', $companyData?->companyFaxSettings?->copy_right_notice)
            ->replace('{Premium_Finance_Company_Privacy_Page_URL}', $companyData?->privacy_page_url)
            ->replace('{Premium_Finance_Company_Web_Address}', $companyData?->company_web_address)
            ->replace('{Finance_Company_Fullname}', $companyData?->user?->name)
            ->replace('{Finance_Company_Firstname}', $companyData?->user?->first_name)
            ->replace('{Finance_Company_Middlename}', $companyData?->user?->middle_name)
            ->replace('{Finance_Company_Lastname}', $companyData?->user?->last_name)
            ->replace('{Finance_Company_Email}', $companyData?->user?->email)
            ->replace('{Finance_Company_Primary_Telephone}', $companyData?->primary_telephone)
            ->replace('{Last_Updated}', (!empty($extData?->updated_at) ? changeDateFormat($extData?->updated_at) : '{Last_Updated}'))
            ->replace('{Notice_Id}', (!empty($extData?->notice_id) ? $extData?->notice_id : '{Notice_Id}'))
            ->replace('{Notice_Date}', changeDateFormat());
        return $template;
    }

    public static function financeAgreementTempalte($qId = null, $vId = null, $data = [])
    {
        try {

            if (empty($qId)) {
                throw new Error("Data Empty");
            }

            $companyData = Company::first();
            $financeAgreement = FinanceAgreement::getData()->whereStatus(1)->latest()->firstOrFail();
            $template = !empty($financeAgreement->template) ? $financeAgreement->template : '';
            if (empty($template)) {
                throw new Error('No Template');
            }

            $quoteData = Quote::getData(['id' => $qId])->firstOrFail();
            $vData = QuoteVersion::getData(['id' => $vId])->firstOrFail();
            $insuredUser = $quoteData?->insured_user ?? null;
            $agentUser = $quoteData?->agent_user ?? null;
            $termsData = $quoteData?->terms_data ?? null;
            $policy_data = $quoteData->policy_data ?? null;
            $policyCount = !empty($policy_data) ? count($policy_data->toArray()) : 0;

            $imageUrl = asset("assets/images/enetworks-cloud-computing-94.png");
            $logoUrl = !empty($companyData?->comp_logo_url) ? $companyData?->comp_logo_url : '';
            $logoUrl = (!empty($logoUrl) && urlExists($logoUrl)) ? $logoUrl : $imageUrl;
            $image = "<img src='{$imageUrl}' alt='not image found'>";
            $DueDate = !empty($termsData?->first_payment_due_date) ? date('j', strtotime($termsData?->first_payment_due_date)) : 0;
            $DueDate = !empty($DueDate) ? ordinalNum($DueDate) : '';
            $template = Str::of($template)
                ->replace('##CompanyName##', $companyData?->comp_name)
                ->replace('##CompanyAddress##', $companyData?->primary_address)
                ->replace('##CompanyCity##', $companyData?->primary_address_city)
                ->replace('##CompanyState##', $companyData?->primary_address_state)
                ->replace('##CompanyZip##', $companyData?->primary_address_zip)
                ->replace('##CompanyTelephone##', $companyData?->primary_telephone)
                ->replace('##PremiumFinanceCompanyLogo##', $logoUrl)
                ->replace('##ComapnyFax##', $companyData?->fax)
                ->replace('##InsuredName##', $insuredUser?->name)
                ->replace('##PolicyType##', $quoteData?->account_type)
                ->replace('##InsuredAddress##', $insuredUser?->entity?->address)
                ->replace('##InsuredCity##', $insuredUser?->entity?->city)
                ->replace('##InsuredState##', $insuredUser?->entity?->state)
                ->replace('##InsuredZip##', $insuredUser?->entity?->zip)
                ->replace('##InsuredTelephone##', $insuredUser?->mobile)
                ->replace('##FEIN/SSN##', '')
                ->replace('##InsuredTIN##', $insuredUser?->entity?->tin)
                ->replace('##AgentName##', $agentUser?->name)
                ->replace('##AgentAddress##', $agentUser?->entity?->address)
                ->replace('##AgentCity##', $agentUser?->entity?->city)
                ->replace('##AgentZip##', $agentUser?->entity?->state)
                ->replace('##AgentState##', $agentUser?->entity?->zip)
                ->replace('##AgentTelephone##', $agentUser?->mobile)
                ->replace('##LoanNumber##', "{$quoteData?->qid}.{$quoteData?->version}")
            // ->replace('##TotalPremium##', "$ " . formatAmount($termsData?->total_payment ?? '0'))
                ->replace('##DownPayment##', "$ " . formatAmount($termsData?->down_payment ?? '0'))
                ->replace('##UnpaidBalance##', "$ " . formatAmount($termsData?->amount_financed))
                ->replace('##DocStampFee##', "$ " . formatAmount($termsData?->doc_stamp_fees))
                ->replace('##AmopuntFinanced##', "$ " . formatAmount($termsData?->amount_financed))
                ->replace('##FinanceCharge##', "$ " . formatAmount(($termsData?->total_interest ?? 0) + ($termsData?->setup_fee ?? 0)))
                ->replace('##TotalOfPayments##', "$ " . formatAmount($termsData?->total_payment))
                ->replace('##AnnualPercentageRate##', ($termsData?->effective_apr ?? 0) . " %")
                ->replace('##AmountofPayments##', "$ " . formatAmount($termsData?->payment_amount))
                ->replace('##FirstDueDate##', changeDateFormat($termsData?->first_payment_due_date, true))
                ->replace('#DueDate##', $DueDate)
                ->replace('##TotalPremiums##', "$ " . formatAmount($termsData?->total_premium))
                ->replace('##NumberofPayments##', $termsData?->number_of_payment)
                ->replace('##AgentCompensation##', $termsData?->compensation ?? '');
            if (!empty($policy_data)) {
                $p = 1;
                $purePremium = $policyFee = $brokerFee = $taxes_and_stamp_fees = $inspectionFee = 0;
                foreach ($policy_data as $key => $policy) {
                    $template = Str::of($template);

                    if ($p == 1) {
                        $template = $template->replace('##PolicyPrefixAndNumber##', ($policy?->policy_number ?? 'TBD'))
                            ->replace('##PolicyEffectiveDate##', changeDateFormat($policy?->inception_date))
                            ->replace('##InsuranceCompany##', $policy?->insurance_company_data->name)
                            ->replace('##GeneralAgent##', $policy?->general_agent_data?->name)
                            ->replace('##OfficeName##', $policy?->comp_name)
                            ->replace('##GeneralAgentAddress##', $policy?->general_agent_data?->address)
                            ->replace('##GeneralAgentCity##', $policy?->general_agent_data?->city)
                            ->replace('##GeneralAgentState##', $policy?->general_agent_data?->state)
                            ->replace('##GeneralAgentZip##', $policy?->general_agent_data?->zip)
                            ->replace('##CoverageType##', $policy?->coverage_type_data?->name)
                            ->replace('##PolicyTerms##', $policy?->policy_term);
                    } else {
                        /*    echo '##Policy'.$p.'PrefixAndNumber##'; */
                        $template = $template->replace('##Policy' . $p . 'PrefixAndNumber##', ($policy?->policy_number ?? 'TBD'))
                            ->replace('##Policy' . $p . 'EffectiveDate##', changeDateFormat($policy?->comp_name))
                            ->replace('##InsuranceCompany' . $p . '##', $policy?->insurance_company_data->name)
                            ->replace('##GeneralAgent' . $p . '##', $policy?->general_agent_data?->name)
                            ->replace('##OfficeName' . $p . '##', $policy?->comp_name)
                            ->replace('##GeneralAgentAddress' . $p . '##', $policy?->general_agent_data?->address)
                            ->replace('##GeneralAgentCity' . $p . '##', $policy?->general_agent_data?->city)
                            ->replace('##GeneralAgentState' . $p . '##', $policy?->general_agent_data?->state)
                            ->replace('##GeneralAgentZip' . $p . '##', $policy?->general_agent_data?->zip)
                            ->replace('##Policy' . $p . 'CoverageType##', $policy?->coverage_type_data?->name)
                            ->replace('##Policy' . $p . 'Terms##', $policy?->policy_term);
                    }
                    $purePremium += $policy?->pure_premium ?? 0;
                    $policyFee += $policy?->policy_fee ?? 0;
                    $brokerFee += $policy?->broker_fee ?? 0;
                    $taxes_and_stamp_fees += $policy?->taxes_and_stamp_fees ?? 0;
                    $inspectionFee += $policy?->inspection_fee ?? 0;
                    $template = $template->replace('##Policy' . $p . 'Premium##', formatAmount($policy?->pure_premium ?? '0.00', false))
                        ->replace('##Policy' . $p . 'Fee##', formatAmount($policy?->policy_fee ?? '0.00', false))
                        ->replace('##Policy' . $p . 'BrokerFee##', formatAmount($policy?->broker_fee ?? '0.00', false))
                        ->replace('##Policy' . $p . 'TaxStamps##', formatAmount($policy?->taxes_and_stamp_fees ?? '0.00', false))
                        ->replace('##Policy' . $p . 'Inspection##', formatAmount($policy?->inspection_fee ?? '0.00', false));
                    $p++;
                }
                $totalPremium = $purePremium + $policyFee + $brokerFee + $taxes_and_stamp_fees + $inspectionFee;
                $totalPremium = "$ " . formatAmount($totalPremium);
                $template = $template->replace('##TotalPremium##', $totalPremium);
            }

            if (!empty($policyCount)) {
                for ($i = $policyCount + 1; $i <= 10; $i++) {

                    if ($i == 1) {
                        $k = '';
                    } else {
                        $k = $i;
                    }
                    $template = Str::of($template);
                    $template = $template->replace('##Policy' . $k . 'PrefixAndNumber##', '')
                        ->replace('##Policy' . $k . 'EffectiveDate##', '')
                        ->replace('##InsuranceCompany' . $k . '##', '')
                        ->replace('##GeneralAgent' . $k . '##', '')
                        ->replace('##OfficeName' . $k . '##', '')
                        ->replace('##GeneralAgentAddress' . $k . '##', '')
                        ->replace('##GeneralAgentCity' . $k . '##,', '')
                        ->replace('##GeneralAgentState' . $k . '##', '')
                        ->replace('##GeneralAgentZip' . $k . '##', '')
                        ->replace('##Policy' . $k . 'CoverageType##', '')
                        ->replace('##Policy' . $k . 'Terms##', '')
                        ->replace('##Policy' . $i . 'Premium##', '0.00')
                        ->replace('##Policy' . $i . 'Fee##', '0.00')
                        ->replace('##Policy' . $i . 'BrokerFee##', '0.00')
                        ->replace('##Policy' . $i . 'TaxStamps##', '0.00')
                        ->replace('##Policy' . $i . 'Inspection##', '0.00');
                }
            }

            if (empty($template)) {
                throw new Error('No Template');
            }

            $type = !empty($data['type']) ? $data['type'] : '';

            $signArry = QuoteSignature::getData(['qId' => $qId, 'vId' => $vId])->orderBy('index', 'asc')->get()?->makeHidden(['user_id', 'region', 'city', 'lat', 'longs', 'country', 'status', 'created_at', 'updated_at', 'qid', 'vid', 'ip'])?->keyBy('key_index')?->toArray();
            // dd($signArry );
            $doc = new DOMDocument();
            $doc->loadHTML(mb_convert_encoding($template, 'HTML-ENTITIES', 'UTF-8'));
            $class = "signature_box";
            $count = 0;
            foreach (self::DOM_getElementByClassName($doc, $class) as $node) {
                $count++;
                if (!empty($type) && $type == 'view') {
                    $content = '<table class="section" style="border-collapse:collapse;width:100%;margin-top:45px"><tr><td style="width:24.25%;border-bottom:1px solid#000;vertical-align:top;line-height:1.1"></td><td style="width:24.25%;border-bottom:1px solid #000;vertical-align:top;line-height:1.1"></td><td style="width:.5%;line-height:1.1"></td><td style="width:24.25%;border-bottom:1px solid#000;vertical-align:top;line-height:1.1"></td><td style="width:24.25%;border-bottom:1px solid #000;vertical-align:top;line-height:1.1"></td></tr><tr><td style="width:24.25%;line-height:1.1"><span><b>(Signature of Agent)</b></span></td><td style="width:24.25%;line-height:1.1"><span><b>(Title)</b></span></td><td style="width:.5%;line-height:1.1"></td><td style="width:24.25%;vertical-align:top;"><span><b>(Signature of Insured)</b></span></td><td style="width:24.25%;line-height:1.1"><span><b>(Title)</b></span></td></tr></table>';
                } else {
                    if (!empty($signArry['agent_' . $count])) {
                        //      print_r($signArry['agent_'.$count]);
                        $agentSignatureHtml = '<div class="signatureboxcss signaturecss"><div style="border-bottom:1px solid black" class="drawignature agent "  ><a style="color: #000;font-size: 12px;margin-top: 63px;" href="javascript:void(0);" class="remove_signature" data-id="' . $signArry['agent_' . $count]['id'] . '"></a><img src="' . $signArry['agent_' . $count]['signature'] . '"> </div><div class="usertitle-signon"><h6 style="font-size: 14px;margin: 0 0px 5px;margin-top:10px;">' . $signArry['agent_' . $count]['name'] . ',&nbsp; ' . $signArry['agent_' . $count]['title'] . ' &nbsp;&nbsp;&nbsp' . $signArry['agent_' . $count]['current_datetime'] . '</h6></div></div>';
                    } else {
                        $agentSignatureHtml = '<div class="signatureboxcss"><div style="display: inline-block; background-color: #FFEA00; border: 1px solid #FFEA00; border-radius: 4px; margin: 5px;padding: 10px;" class="drawignature addsignature agent" data-type="agent" data-id="AddSignatureModel"><i class="fas fa-times fa-sm" style="vertical-align: bottom; padding-bottom: 2px;"></i> <i class="fa-solid fa-signature fa-3x" style="vertical-align: bottom; padding-left: 1px; padding-right: 3px;color: #000; "></i><span style="font-size:20px; color: #000; vertical-align: bottom; padding-bottom: 4px;"> Agent signature </span></div><div class="usertitle-signon"></div></div>';
                    }
                    if (!empty($signArry['isnured_' . $count])) {
                        //dd($signArry['isnured_'.$count]);
                        $isnuredsignatureHtml = '<div class="signatureboxcss signaturecss"><div style="border-bottom:1px solid black" class="drawignature isnured" ><a style="color: #000;font-size: 12px;margin-top: 63px;" href="javascript:void(0);" class="remove_signature" data-id="' . $signArry['isnured_' . $count]['id'] . '"></a><img src="' . $signArry['isnured_' . $count]['signature'] . '"> </div><div class="usertitle-signon"><h6 style="font-size: 14px;margin: 0 0px 5px;margin-top:10px;">' . $signArry['isnured_' . $count]['name'] . ',&nbsp; ' . $signArry['isnured_' . $count]['title'] . ' &nbsp;&nbsp;&nbsp; ' . $signArry['isnured_' . $count]['current_datetime'] . ' </h6></div></div>';
                    } else {
                        $isnuredsignatureHtml = '<div class="signatureboxcss"><div style="display: inline-block; background-color: #FFEA00; border: 1px solid #FFEA00; border-radius: 4px; margin: 5px;padding: 10px;" class="drawignature addsignature isnured" data-type="isnured" data-id="AddSignatureModel"><i class="fas fa-times fa-sm" style="vertical-align: bottom; padding-bottom: 2px;"></i> <i class="fa-solid fa-signature fa-3x" style="vertical-align: bottom; padding-left: 1px; padding-right: 3px;color: #000; "></i><span style="font-size:20px; color: #000; vertical-align: bottom; padding-bottom: 4px;"> Insured signature </span></div><div class="usertitle-signon"></div></div>';
                    }
                    $content = '<table class="section" style="border-collapse: collapse; width: 100%;margin-top:1px;">
                    <tbody>
                    <tr style="height: 30px;">
                    <td class="agent_signature" data-pageid="' . $count . '" style="width: 47.2636%; vertical-align: top; height: 30px; line-height: 1.1;">' . $agentSignatureHtml . '</td>
                    <td style="width: 1.73638%; height: 30px; line-height: 1.1;">&nbsp;</td>
                    <td class="isnured_signature" data-pageid="' . $count . '" style="width: 48%;vertical-align: top; height: 30px; line-height: 1.1;">' . $isnuredsignatureHtml . '</td></tr></tbody></table>';
                }
                $node->nodeValue = $content;
            }
            $template = $doc->saveHTML();
            $template = html_entity_decode($template);
            return (object) ['template' => $template, 'quoteData' => $quoteData, 'vData' => $vData];
        } catch (\Throwable $th) {
            /*  dd( $th); */
            return $th->getMessage();
        }
    }

    private static function DOM_getElementByClassName($referenceNode, $className, $index = false)
    {
        $className = strtolower($className);
        $response = array();
        foreach ($referenceNode->getElementsByTagName("*") as $node) {
            $nodeClass = strtolower($node->getAttribute("class"));

            if (
                $nodeClass == $className ||
                preg_match("/\b" . $className . "\b/", $nodeClass)
            ) {
                $response[] = $node;
            }
        }

        if ($index !== false) {
            return isset($response[$index]) ? $response[$index] : false;
        }

        return $response;
    }

    /* Add Css And Header Footer In Notice */
    public static function noticeTemplated($template =null)
    {
        $header = DBHelper::metaValue('notice-templates-notice-header-footer', 'header');
        $footer = DBHelper::metaValue('notice-templates-notice-header-footer', 'footer');
        $css = DBHelper::metaValue('notice-templates', 'css');

        $template = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>' . $css . '</style>
        </head>
        <body>
          ' . $header . '
          ' . $template . '
          ' . $footer . '
        </body>
        </html>';
        return $template;
    }



}
