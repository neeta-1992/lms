<?php

namespace App\Helpers;

use App\Helpers\UserReplaceShortCode as URSC;
use App\Helpers\ReplaceShortcodes as RSC;
use App\Models\DailyNotice as DailyNoticeModel;
use App\Models\EntityContact;
use App\Models\Notice;
use App\Models\NoticeTemplate;
use App\Models\Quote;
use App\Models\QuoteVersion;
use App\Models\QuoteAccountExposure;

use App\Models\User;

class DailyNotice
{
    public static function sendToId($noticeSttingData =null,$noticeAction=null,$sendBy =null,$SendData=null){
        if(empty($noticeSttingData)){
            return null;
        }

        if (!empty($noticeSttingData)) {
            $default_email_notices  = $noticeSttingData?->default_email_notices ?? '';
            $default_fax_notices    = $noticeSttingData?->default_fax_notices ?? '';
            $default_mail_notices   = $noticeSttingData?->default_mail_notices ?? '';
            $noticeSttingData       = !empty($noticeSttingData->json) ? json_decode($noticeSttingData->json) : '';
            $noticeSttingData       = !empty($noticeSttingData->description) ? json_decode($noticeSttingData->description) : '';
        }
     
      
        $sendType   = !empty($noticeSttingData?->{$noticeAction}) ? $noticeSttingData?->{$noticeAction}?->send_type : "";
        $sendType   = strtolower($sendType)  == $sendBy ? $sendType : "Do not send";
        $sendToTemp = !empty($noticeSttingData?->{$noticeAction}) ? $noticeSttingData?->{$noticeAction}?->send_to : '';
       
        if (!empty($sendType) && $sendType == 'mail' ) {
            if (empty($sendToTemp) && !empty($SendData)) {
                $mailing_address = $SendData?->mailing_address ?? '';
                $mailing_address = !empty($mailing_address) ? "<br> {$mailing_address}" : '';
                $mailing_city = $SendData?->mailing_city ?? '';
                $mailing_state = $SendData?->mailing_state ?? '';
                $mailing_zip = $SendData?->mailing_zip ?? '';
                $mailing_zip = !empty($mailing_zip) ? ", {$mailing_zip}" : '';
                $sendToTemp = removeWhiteSpace("{$mailing_address} {$mailing_city} {$mailing_state} {$mailing_zip}");
            }
        } elseif (!empty($sendType) && $sendType == 'email') {
            if (empty($sendToTemp)) {
                if (!empty($default_email_notices)) {
                    $contactData    = EntityContact::getData(['eId' => $SendData->id, 'id' => $default_email_notices])->first();
                    $sendToTemp     = $contactData?->email ?? '';
                }
                if (empty($sendToTemp)) {
                    $sendToTemp     = $SendData?->email ?? '';
                }
            } else {
                $sendToTemp = !empty($sendToTemp) ? explode(',', $sendToTemp) : '';
            }
        } elseif (!empty($sendType) && $sendType == 'fax') {
            if (empty($sendToTemp)) {
                if (!empty($default_fax_notices)) {
                    $contactData = EntityContact::getData(['eId' => $SendData->id, 'id' => $default_fax_notices])->first();
                    $sendToTemp = $contactData?->fax ?? '';
                }
                if (empty($sendToTemp)) {
                    $sendToTemp     = $SendData?->email ?? '';
                }
            }
        }

        return (object)[ 'sentTo' => $sendToTemp, 'sendType' => $sendType];


    }

    public static function quoteDailyNoticeSave($accountId, $policyData, $templateText, $temValue, $quoteData, $quoteVersion, $quoteTerm, $accountData, $agencyData)
    {
        $sendType = "Do not send";$SendData =null;
        $default_email_notices = $default_fax_notices = $default_mail_notices = $noticeSttingData =   $sentType = $sentId = $sendToTemp = "";
        $accountNumber  = ($quoteData?->qid ?? '') . '.' . ($quoteData?->version ?? '');
        $noticeId       = !empty($temValue->id) ? $temValue->id : null;
        $templateType   = !empty($temValue->template_type) ? $temValue->template_type : null;
        $sendTo         = !empty($temValue->send_to) ? $temValue->send_to : null;
        $sendBy         = !empty($temValue->send_by) ? $temValue->send_by : null;
        $noticeName     = !empty($temValue->name) ? $temValue->name : null;
        $noticeAction   = !empty($temValue->action) ? $temValue->action : null;

        //$templateType = 'Do not send';
        $generalAgentData = !empty($policyData->general_agent_data) ? $policyData->general_agent_data : '';
        $insuranceCompanyData = !empty($policyData->insurance_company_data) ? $policyData->insurance_company_data : '';
        $templateText = $templateText->ICT(['data' => $insuranceCompanyData])->GAT(['data' => $generalAgentData]);
        $isInsertData = false;
        if (!empty($generalAgentData) && $sendTo == 'General_agent') {
            $noticeSttingData = $generalAgentData?->notice_setting ?? null;
            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'general-agents-notice'])->first();
            }
            $isInsertData = true;
            $sentId = $generalAgentData?->id ?? '';
            $SendData = $generalAgentData ?? '';
            $sendTypeTempalet = "General Agent";
        } elseif (!empty($insuranceCompanyData) && $sendTo == 'Insurance_company') {
            $noticeSttingData = $insuranceCompanyData?->notice_setting ?? null;
            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'insurance-companies-notice'])->first();
            }
            $isInsertData = true;
            $sentId     = $insuranceCompanyData?->id ?? '';
            $SendData   = $insuranceCompanyData ?? '';
            $sendTypeTempalet = "Insurance company";
        } elseif (!empty($agencyData) && $sendTo == 'Agent') {
            $noticeSttingData = $agencyData?->notice_setting ?? null;
            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'agents-notice'])->first();
            }
            $isInsertData = true;
            $sentId     = $agencyData?->id ?? '';
            $SendData   = $agencyData ?? '';
            $sendTypeTempalet = "Agent";
        }

        $sendToIdData = self::sendToId($noticeSttingData,$noticeAction,$sendBy,$SendData);
        $sendToTemp   = $sendToIdData?->sentTo;
        $sendType     = !empty($sendToIdData?->sendType) ?  $sendToIdData?->sendType : $sendType; 

/* dd($sendToTemp); */
        $template   = !empty($templateText?->template) ? RSC::noticeTemplated($templateText?->template) : null;
        if ($isInsertData) {
            if (!empty($sendToTemp) && is_array($sendToTemp)) {
                foreach ($sendToTemp as $key => $value) {
                    $inserArray = [
                        'user_id' => auth()->user()->id,
                        'notice_id' => $noticeId,
                        'send_id' => $sentId,
                        'send_type' => $sendTypeTempalet,
                        'quote_id' => $policyData->quote,
                        'version_id' => $policyData->version,
                        'policy_id' => $policyData->id,
                        'subject' => $noticeName,
                        'notice_name' => $noticeName,
                        'notice_action' => $noticeAction,
                        'notice_type' => $templateType,
                        'template' => $template,
                        'send_by' => $sendType,
                        'send_to' => $value,
                        'account_number' => $accountNumber,
                        'account_id' => $accountId,
                        'shortcodes' => !empty($templateText?->replaceValues) ? json_encode($templateText?->replaceValues) : null,
                    ];
                    DailyNoticeModel::insertOrUpdate($inserArray);
                }
            } else {
                $inserArray = [
                    'user_id' => auth()->user()->id,
                    'notice_id' => $noticeId,
                    'send_id' => $sentId,
                    'send_type' => $sendTypeTempalet,
                    'quote_id' => $policyData->quote,
                    'version_id' => $policyData->version,
                    'policy_id' => $policyData->id,
                    'subject' => $noticeName,
                    'notice_name' => $noticeName,
                    'notice_action' => $noticeAction,
                    'notice_type' => $templateType,
                    'template' => $template,
                    'send_by' => $sendType,
                    'send_to' => $sendToTemp,
                    'account_number' => $accountNumber,
                    'account_id' => $accountId,
                    'shortcodes' => !empty($templateText?->replaceValues) ? json_encode($templateText?->replaceValues) : null,
                    "status" => 1,
                ];
             /*    dd( $inserArray );  */
                DailyNoticeModel::insertOrUpdate($inserArray);
            }

        }

    }

    public static function quoteDailyNotice(array $arr)
    {

        
        $qId = !empty($arr['qId']) ? $arr['qId'] : '';
        $vId = !empty($arr['vId']) ? $arr['vId'] : '';
        $accountId = !empty($arr['accountId']) ? $arr['accountId'] : '';

        list($quoteData, $quoteVersion, $quotePolicy, $quoteTerm, $accountData) = self::dataEmptyCheck($arr);

        $temPlateData = NoticeTemplate::getData(['action' => 'notice_of_financed_premium', 'status' => 1])->eGroupBy('send_to')->get();

        $agencyData = $quoteData?->agency_data ?? '';
        $agentData = $quoteData?->agent_user ?? '';
        $insuredUser = $quoteData?->insured_user;
        $accountNumber = ($quoteData?->qid ?? '') . '.' . ($quoteData?->version ?? '');

        if (!empty($temPlateData)) {
            foreach ($temPlateData as $key => $temValue) {
                $noticeId = !empty($temValue->id) ? $temValue->id : null;
                $templateType = !empty($temValue->template_type) ? $temValue->template_type : null;
                $sendTo = !empty($temValue->send_to) ? $temValue->send_to : null;
                $sendBy = !empty($temValue->send_by) ? $temValue->send_by : null;
                $noticeName = !empty($temValue->name) ? $temValue->name : null;
                $noticeAction = !empty($temValue->action) ? $temValue->action : null;
                $templateText = !empty($temValue->template_text) ? $temValue->template_text : null;
                $templateText = (new URSC)
                    ->FCT(['template' => $templateText])
                    ->AT(['data' => $agentData])
                    ->IT(['data' => $insuredUser])
                    ->QT(['date' => $quoteData])
                    ->QTermT(['data' => $quoteTerm])
                    ->NoticeT(['data' => $temValue])
                    ->ACCT(['data' => $accountData]);

                if ($templateType == 'policy') {
                    foreach ($quotePolicy as $key => $value) {
                        $templateText = $templateText->QPolicyT(['data'=>$value]);
                        self::quoteDailyNoticeSave($accountId, $value, $templateText, $temValue, $quoteData, $quoteVersion, $quoteTerm, $accountData, $agencyData);
                    }
                } elseif ($templateType == 'account') {
                    $value = QuotePolicy::getData(['qId' => $qId, 'version' => $vId])->orderBy('created_at', 'as')->first();
                    $templateText = $templateText->QPolicyT(['data'=>$value]);
                    self::quoteDailyNoticeSave($accountId, $value, $templateText, $temValue, $quoteData, $quoteVersion, $quoteTerm, $accountData, $agencyData);
                } else {
                    break;
                }
            }
        }
    }

    public static function dataEmptyCheck(array $arr)
    {

        $qId = !empty($arr['qId']) ? $arr['qId'] : '';
        $vId = !empty($arr['vId']) ? $arr['vId'] : '';
        $accountId = !empty($arr['accountId']) ? $arr['accountId'] : '';
        $quoteData = !empty($arr['quoteData']) ? $arr['quoteData'] : null;
        $quotePolicy = !empty($arr['quotePolicy']) ? $arr['quotePolicy'] : null;
        $quoteTerm = !empty($arr['quoteTerm']) ? $arr['quoteTerm'] : null;
        $accountData = !empty($arr['quoteAccount']) ? $arr['quoteAccount'] : null;

        if (empty($quoteData)) {
            $quoteData = Quote::getData(['id' => $qId])->firstOrFail();
        }

        if (empty($quotePolicy)) {
            $quotePolicy = QuotePolicy::getData(['qId' => $qId, 'version' => $vId])->get();
        }

        if (empty($quoteVersion)) {
            $quoteVersion = QuoteVersion::getData(['qId' => $qId, 'id' => $vId])->first();
        }

        if (empty($quoteTerm)) {
            $quoteTerm = QuoteTerm::getData(['qId' => $qId, 'vId' => $vId])->first();
        }

        if (empty($accountData)) {
            $accountData = QuoteAccount::getData(['qId' => $qId, 'id' => $vId])->first();
        }

        return [$quoteData, $quoteVersion, $quotePolicy, $quoteTerm, $accountData];

    }



    /* 	Payment Coupons Notice Templeted */
    public static function quotePaymentCoupons(array $arr){
       
        
        $qId            = !empty($arr['qId']) ? $arr['qId'] : '';
        $vId            = !empty($arr['vId']) ? $arr['vId'] : '';
        $accountId      = !empty($arr['accountId']) ? $arr['accountId'] : '';
        $quoteData      = !empty($arr['quoteData']) ? $arr['quoteData'] : null;
        $quotePolicy    = !empty($arr['quotePolicy']) ? $arr['quotePolicy'] : null;
        $quoteTerm      = !empty($arr['quoteTerm']) ? $arr['quoteTerm'] : null;
        $accountData    = !empty($arr['quoteAccount']) ? $arr['quoteAccount'] : null;
        $templateText   = !empty($arr['templateText']) ? $arr['templateText'] : null;
        $shortCode      = !empty($arr['shortCode']) ? $arr['shortCode'] : null;
        $paymentMethode = !empty($arr['paymentMethode']) ? $arr['paymentMethode'] : null;

        $agencyData     = $quoteData?->agency_data ?? '';
        $agentData      = $quoteData?->agent_user ?? '';
        $insuredUser    = $quoteData?->insured_user;
        $insurData      = $quoteData?->insur_data;
        $action         = "null";
        if($paymentMethode == 'coupons'){
            $action  = 'payment_coupons';
        }elseif($paymentMethode == 'ach'){
            $action  = 'ach_cover_letter';
        }elseif($paymentMethode == 'credit_card'){
            $action  = 'credit_card_cover_letter';
        }
      
        $temPlateData = NoticeTemplate::getData(['action' =>$action,'status' =>1])->eGroupBy('send_to')->get();
        if (!empty($temPlateData)) {
            

            foreach ($temPlateData as $key => $temValue) {
                $arr['temValue'] = $temValue;
                $arr['agencyData'] = $agencyData;
                $arr['agentData'] = $agentData;
                $arr['insuredUser'] = $insuredUser;
                $arr['insurData'] = $insurData;
               // $arr['accountNumber'] = $accountNumber;
               self::quotePaymentCouponsSave($arr);
            }
        }
    }


    public static function quotePaymentCouponsSave(array $arr){

        $noticeSttingData =   $sentType = $sentId = $sendToTemp = "";
        $sendType = "Do not send";
        $isInsertData   = false;
        $SendData       = null;
        $qId            = !empty($arr['qId']) ? $arr['qId'] : '';
        $vId            = !empty($arr['vId']) ? $arr['vId'] : '';
        $accountId      = !empty($arr['accountId']) ? $arr['accountId'] : '';
        $quoteData      = !empty($arr['quoteData']) ? $arr['quoteData'] : null;
        $quotePolicy    = !empty($arr['quotePolicy']) ? $arr['quotePolicy'] : null;
        $quoteTerm      = !empty($arr['quoteTerm']) ? $arr['quoteTerm'] : null;
        $accountData    = !empty($arr['quoteAccount']) ? $arr['quoteAccount'] : null;
        $templateText   = !empty($arr['templateText']) ? $arr['templateText'] : null;
        $shortCode      = !empty($arr['shortCode']) ? $arr['shortCode'] : null;
        $temValue       = !empty($arr['temValue']) ? $arr['temValue'] : null;

        $agencyData     = !empty($arr['agencyData']) ? $arr['agencyData'] : $quoteData?->agency_data ?? '';
        $agentData      = !empty($arr['agentData']) ? $arr['agentData'] : $quoteData?->agent_user ?? '';
        $insuredUser    = !empty($arr['insuredUser']) ? $arr['insuredUser'] : $quoteData?->insured_user;
        $insurData      = !empty($arr['insurData']) ? $arr['insurData'] : $quoteData?->insur_data;
        $paymentMethode = !empty($arr['paymentMethode']) ? $arr['paymentMethode'] : null;

        $accountNumber  = ($quoteData?->qid ?? '') . '.' . ($quoteData?->version ?? '');


        $noticeId       = !empty($temValue->id) ? $temValue->id : null;
        $templateType   = !empty($temValue->template_type) ? $temValue->template_type : null;
        $sendTo         = !empty($temValue->send_to) ? $temValue->send_to : null;
        $sendBy         = !empty($temValue->send_by) ? $temValue->send_by : null;
        $noticeName     = !empty($temValue->name) ? $temValue->name : null;
        $noticeAction   = !empty($temValue->action) ? $temValue->action : null;
        $templateText   = !empty($temValue->template_text) ? $temValue->template_text : null;
      /*   dd($temValue->toArray()); */
        $templateText   = (new URSC)
                ->FCT(['template' => $templateText])
                ->AT(['data' => $agentData])
                ->IT(['data' => $insuredUser])
                ->QT(['date' => $quoteData])
                ->QTermT(['data' => $quoteTerm])
                ->NoticeT(['data' => $temValue]);
        
        $paymentCouponTemplate = $payemntCuponCoverLettertemplateText ="";
        if(!empty($shortCode) && !empty($templateText?->template)){
            foreach ($shortCode as $key => $qAE) {
                $keyArr                      = array_keys($qAE);
                $valuesArr                   = array_values($qAE);
                $paymentCouponTem            = str_replace($keyArr,$valuesArr, $templateText?->template);
                $paymentCouponTemplate       .= "<div style='margin-top:100px !important;'>{$paymentCouponTem}</div>";
            
            }
        }elseif($templateText?->template){
           $QuoteAccountExposure = QuoteAccountExposure::getData(['accountId'=>$accountId])->get();
           if(!empty($QuoteAccountExposure)){
               foreach ($QuoteAccountExposure as $key => $value) {
                    $paymentCouponTem  =  $templateText->QAE(['data'=>$value,'accountData'=>$accountData]);
                    $paymentCouponTemplate       .= "<div style='margin-top:100px !important;'>{$paymentCouponTem}</div>";
               }
           }
        }

        if($paymentMethode == 'coupons'){  
            $payemntCuponCoverLetter = NoticeTemplate::getData(['action' =>'payemnt_coupon_cover_letter','status' =>1,'type'=>$sendTo])->first();
            if(!empty($payemntCuponCoverLetter) && !empty($payemntCuponCoverLetter?->template_text)){
                $payemntCuponCoverLettertemplateText   = !empty($payemntCuponCoverLetter->template_text) ? $payemntCuponCoverLetter->template_text : null;
                $payemntCuponCoverLetter   = (new URSC)
                                            ->FCT(['template' => $payemntCuponCoverLettertemplateText])  
                                            ->IT(['data' => $insuredUser])
                                            ->QT(['date' => $quoteData])
                                            ->QTermT(['data' => $quoteTerm])
                                            ->NoticeT(['data' => $temValue]);
                $payemntCuponCoverLettertemplateText = !empty($payemntCuponCoverLetter) ? $payemntCuponCoverLetter?->template : $payemntCuponCoverLettertemplateText ;
            }
        }

/*       dd($temValue);  */
        $templateText = !empty($paymentCouponTemplate) ? $paymentCouponTemplate : $templateText?->template;
        $templateText = !empty($payemntCuponCoverLettertemplateText) ? $payemntCuponCoverLettertemplateText.$templateText : $templateText;

        if (!empty($agencyData) && $sendTo == 'Agent') {
            $noticeSttingData = $agencyData?->notice_setting ?? null;

            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'agents-notice'])->first();
            }

          
            $isInsertData = true;
            $sentId = $agencyData?->id ?? '';
            $SendData = $agencyData ?? '';
            $sendTypeTempalet = "Agent";
        }elseif (!empty($insurData) && $sendTo == 'Insured') {
            $noticeSttingData = $insurData?->notice_setting ?? null;
            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'insureds-notice"'])->first();
            }
           
            $isInsertData = true;
            $sentId = $insurData?->id ?? '';
            $SendData = $insurData ?? '';
            $sendTypeTempalet = "Insured";
        }

         
       
        $sendToIdData = self::sendToId($noticeSttingData,$noticeAction,$sendBy,$SendData);
        $sendToTemp   = $sendToIdData?->sentTo;
        $sendType     =  !empty($sendToIdData?->sendType) ?  $sendToIdData?->sendType : $sendType; 

       
        $templateText   = !empty($templateText) ? RSC::noticeTemplated($templateText) : null;
        if ($isInsertData) {
            if (!empty($sendToTemp) && is_array($sendToTemp)) {
                foreach ($sendToTemp as $key => $value) {
                    $inserArray = [
                        'user_id' => auth()->user()->id,
                        'notice_id' => $noticeId,
                        'send_id' => $sentId,
                        'send_type' => $sendTypeTempalet,
                        'quote_id' => $qId ,
                        'version_id' => $vId,
                        'subject'    => $noticeName,
                        'notice_name' => $noticeName,
                        'notice_action' => $noticeAction,
                        'notice_type' => $templateType,
                        'template' => $templateText,
                        'send_by' => $sendType,
                        'send_to' => $value,
                        'account_number' => $accountNumber,
                        'account_id' => $accountId,
                      //  'shortcodes' => !empty($templateText?->replaceValues) ? json_encode($templateText?->replaceValues) : null,
                    ];
                    DailyNoticeModel::insertOrUpdate($inserArray);
                }
            } else {
                $inserArray = [
                    'user_id' => auth()->user()->id,
                    'notice_id' => $noticeId,
                    'send_id' => $sentId,
                    'send_type' => $sendTypeTempalet,
                    'quote_id' => $qId ,
                    'version_id' => $vId,
                    'subject' => $noticeName,
                    'notice_name' => $noticeName,
                    'notice_action' => $noticeAction,
                    'notice_type' => $templateType,
                    'template' => $templateText,
                    'send_by' => $sendType,
                    'send_to' => $sendToTemp,
                    'account_number' => $accountNumber,
                    'account_id' => $accountId,
                  //  'shortcodes' => !empty($templateText?->replaceValues) ? json_encode($templateText?->replaceValues) : null,
                    "status" => 1,
                ];
                DailyNoticeModel::insertOrUpdate($inserArray);
            }
        }
    }




    /* 	Payment Coupons Notice Templeted */
    public static function accountStatusNoticesSend(array $arr){
       
        
        $qId            = !empty($arr['qId']) ? $arr['qId'] : '';
        $vId            = !empty($arr['vId']) ? $arr['vId'] : '';
        $accountData    = !empty($arr['accountData']) ? $arr['accountData'] : '';
        $quoteData      = !empty($arr['quoteData']) ? $arr['quoteData'] : null;
        $quotePolicy    = !empty($arr['quotePolicy']) ? $arr['quotePolicy'] : null;
        $quoteTerm      = !empty($arr['quoteTerm']) ? $arr['quoteTerm'] : null;
        $accountData    = !empty($arr['quoteAccount']) ? $arr['quoteAccount'] : null;
        $templateText   = !empty($arr['templateText']) ? $arr['templateText'] : null;
        $shortCode      = !empty($arr['shortCode']) ? $arr['shortCode'] : null;
        $paymentMethode = !empty($arr['paymentMethode']) ? $arr['paymentMethode'] : null;
        $action         = !empty($arr['action']) ? $arr['action'] : null;


        $quoteData      = $accountData?->q_data ?? '';
        $agencyData     = $accountData?->agency_data ?? '';
        $agentData      = $accountData?->agent_user ?? '';
        $insuredUser    = $accountData?->insured_user;
        $insurData      = $accountData?->insur_data;
        $quoteTerm      = !empty($quoteTerm) ?  $quoteTerm : $accountData?->quote_term;
       
      
        $temPlateData = NoticeTemplate::getData(['action' =>$action,'status' =>1])->eGroupBy('send_to')->get();
       
        if (!empty($temPlateData)) {
            foreach ($temPlateData as $key => $temValue) {
                $arr['temValue']    = $temValue;
                $arr['agencyData']  = $agencyData;
                $arr['agentData']   = $agentData;
                $arr['insuredUser'] = $insuredUser;
                $arr['insurData']   = $insurData;
                $arr['quoteData']   = $quoteData;
                $arr['quoteAccount']   = $accountData;
               
               self::accountStatusNoticesSave($arr);
            }
        }
    }



    public static function accountStatusNoticesSave(array $arr){

        $noticeSttingData =   $sentType = $sentId = $sendToTemp = "";
        $sendType = "Do not send";
        $isInsertData   = false;
        $SendData       = null;
        $qId            = !empty($arr['qId']) ? $arr['qId'] : '';
        $vId            = !empty($arr['vId']) ? $arr['vId'] : '';
        $accountId      = !empty($arr['accountId']) ? $arr['accountId'] : '';
        $quoteData      = !empty($arr['quoteData']) ? $arr['quoteData'] : null;
        $quotePolicy    = !empty($arr['quotePolicy']) ? $arr['quotePolicy'] : null;
        $quoteTerm      = !empty($arr['quoteTerm']) ? $arr['quoteTerm'] : null;
        $accountData    = !empty($arr['quoteAccount']) ? $arr['quoteAccount'] : null;
        $templateText   = !empty($arr['templateText']) ? $arr['templateText'] : null;
        $shortCode      = !empty($arr['shortCode']) ? $arr['shortCode'] : null;
        $temValue       = !empty($arr['temValue']) ? $arr['temValue'] : null;

        $agencyData     = !empty($arr['agencyData']) ? $arr['agencyData'] : $quoteData?->agency_data ?? '';
        $agentData      = !empty($arr['agentData']) ? $arr['agentData'] : $quoteData?->agent_user ?? '';
        $insuredUser    = !empty($arr['insuredUser']) ? $arr['insuredUser'] : $quoteData?->insured_user;
        $insurData      = !empty($arr['insurData']) ? $arr['insurData'] : $quoteData?->insur_data;
        $paymentMethode = !empty($arr['paymentMethode']) ? $arr['paymentMethode'] : null;

        $accountNumber  = ($quoteData?->qid ?? '') . '.' . ($quoteData?->version ?? '');


        $noticeId       = !empty($temValue->id) ? $temValue->id : null;
        $templateType   = !empty($temValue->template_type) ? $temValue->template_type : null;
        $sendTo         = !empty($temValue->send_to) ? $temValue->send_to : null;
        $sendBy         = !empty($temValue->send_by) ? $temValue->send_by : null;
        $noticeName     = !empty($temValue->name) ? $temValue->name : null;
        $noticeAction   = !empty($temValue->action) ? $temValue->action : null;
        $templateText   = !empty($temValue->template_text) ? $temValue->template_text : null;
      /*   dd($temValue->toArray()); */
        $templateText   = (new URSC)
                ->FCT(['template' => $templateText])
                ->AT(['data'      => $agentData])
                ->IT(['data'      => $insuredUser])
                ->QT(['date'      => $quoteData])
                ->QTermT(['data'  => $quoteTerm])
                ->NoticeT(['data' => $temValue]);
        
     
        


        $templateText = $templateText?->template;
       

        if (!empty($agencyData) && $sendTo == 'Agent') {
            $noticeSttingData = $agencyData?->notice_setting ?? null;

            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'agents-notice'])->first();
            }

           
            $isInsertData = true;
            $sentId = $agencyData?->id ?? '';
            $SendData = $agencyData ?? '';
            $sendTypeTempalet = "Agent";
        }elseif (!empty($insurData) && $sendTo == 'Insured') {
            $noticeSttingData = $insurData?->notice_setting ?? null;
            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'insureds-notice"'])->first();
            }
            
            $isInsertData = true;
            $sentId = $insurData?->id ?? '';
            $SendData = $insurData ?? '';
            $sendTypeTempalet = "Insured";
        }

         
       
        $sendToIdData = self::sendToId($noticeSttingData,$noticeAction,$sendBy,$SendData);
        $sendToTemp   = $sendToIdData?->sentTo;
        $sendType     =  !empty($sendToIdData?->sendType) ?  $sendToIdData?->sendType : $sendType; 

       
        $templateText   = !empty($templateText) ? RSC::noticeTemplated($templateText) : null;
        if ($isInsertData) {
            if (!empty($sendToTemp) && is_array($sendToTemp)) {
                foreach ($sendToTemp as $key => $value) {
                    $inserArray = [
                        'user_id' => auth()->user()->id,
                        'notice_id' => $noticeId,
                        'send_id' => $sentId,
                        'send_type' => $sendTypeTempalet,
                        'quote_id' => $qId ,
                        'version_id' => $vId,
                        'subject'    => $noticeName,
                        'notice_name' => $noticeName,
                        'notice_action' => $noticeAction,
                        'notice_type' => $templateType,
                        'template' => $templateText,
                        'send_by' => $sendType,
                        'send_to' => $value,
                        'account_number' => $accountNumber,
                        'account_id' => $accountId,
                      //  'shortcodes' => !empty($templateText?->replaceValues) ? json_encode($templateText?->replaceValues) : null,
                    ];
                    DailyNoticeModel::insertOrUpdate($inserArray);
                }
            } else {
                $inserArray = [
                    'user_id' => auth()->user()->id,
                    'notice_id' => $noticeId,
                    'send_id' => $sentId,
                    'send_type' => $sendTypeTempalet,
                    'quote_id' => $qId ,
                    'version_id' => $vId,
                    'subject' => $noticeName,
                    'notice_name' => $noticeName,
                    'notice_action' => $noticeAction,
                    'notice_type' => $templateType,
                    'template' => $templateText,
                    'send_by' => $sendType,
                    'send_to' => $sendToTemp,
                    'account_number' => $accountNumber,
                    'account_id' => $accountId,
                  //  'shortcodes' => !empty($templateText?->replaceValues) ? json_encode($templateText?->replaceValues) : null,
                    "status" => 1,
                ];
                DailyNoticeModel::insertOrUpdate($inserArray);
            }
        }
    }



    
    /* 	Payment Coupons Notice Templeted */
    public static function paymentNoticesSend(array $arr){
      
        $accountData    = !empty($arr['accountData']) ? $arr['accountData'] : '';
        $paymentData    = !empty($arr['paymentData']) ? $arr['paymentData'] : null;
        $action         = !empty($arr['action']) ? $arr['action'] : 'payment_confirmation';


        $quoteData      = $accountData?->q_data ?? '';
        $agencyData     = $accountData?->agency_data ?? '';
        $agentData      = $accountData?->agent_user ?? '';
        $insuredUser    = $accountData?->insured_user;
        $insurData      = $accountData?->insur_data;
      

       
      
        $temPlateData = NoticeTemplate::getData(['action' =>$action,'status' =>1])->eGroupBy('send_to')->get();
       
        if (!empty($temPlateData)) {
            foreach ($temPlateData as $key => $temValue) {
                $arr['temValue']    = $temValue;
                $arr['agencyData']  = $agencyData;
                $arr['agentData']   = $agentData;
                $arr['paymentData']   = $paymentData;
                $arr['quoteAccount']   = $accountData;
                $arr['quoteData']   = $quoteData;
               
               self::paymentNoticesSave($arr);
            }
        }
    }


    
    public static function paymentNoticesSave(array $arr){

        $noticeSttingData =   $sentType = $sentId = $sendToTemp = "";
        $sendType = "Do not send";
        $isInsertData   = false;
        $SendData       = null;
        $accountId      = !empty($arr['accountId']) ? $arr['accountId'] : '';
        $quoteData      = !empty($arr['quoteData']) ? $arr['quoteData'] : $accountData?->q_data ?? '';
        $accountData    = !empty($arr['quoteAccount']) ? $arr['quoteAccount'] : null;
        $templateText   = !empty($arr['templateText']) ? $arr['templateText'] : null;
        $shortCode      = !empty($arr['shortCode']) ? $arr['shortCode'] : null;
        $temValue       = !empty($arr['temValue']) ? $arr['temValue'] : null;
        $agencyData     = !empty($arr['agencyData']) ? $arr['agencyData'] : $accountData?->agency_data ?? '';
        $agentData      = !empty($arr['agentData']) ? $arr['agentData'] : $accountData?->agent_user ?? '';
        $insuredUser    = !empty($arr['insuredUser']) ? $arr['insuredUser'] : $accountData?->insured_user;
        $insurData      = !empty($arr['insurData']) ? $arr['insurData'] : $accountData?->insur_data;
        $paymentData    = !empty($arr['paymentData']) ? $arr['paymentData'] : null;
        $qId            = $accountData?->quote;
        $vId            = $accountData?->version;
        $accountId      = $accountData?->id;
        $accountNumber  = ($quoteData?->qid ?? '') . '.' . ($quoteData?->version ?? '');


        $noticeId       = !empty($temValue->id) ? $temValue->id : null;
        $templateType   = !empty($temValue->template_type) ? $temValue->template_type : null;
        $sendTo         = !empty($temValue->send_to) ? $temValue->send_to : null;
        $sendBy         = !empty($temValue->send_by) ? $temValue->send_by : null;
        $noticeName     = !empty($temValue->name) ? $temValue->name : null;
        $noticeAction   = !empty($temValue->action) ? $temValue->action : null;
        $templateText   = !empty($temValue->template_text) ? $temValue->template_text : null;
     
        $templateText   = (new URSC)
                ->FCT(['template' => $templateText])
                ->AT(['data'      => $agentData])
                ->ACCT(['data'      => $accountData])
                ->PAYMENT(['data'   => $paymentData]);
            
        
   
    

        $templateText = $templateText?->template;
       
       
        if (!empty($agencyData) && $sendTo == 'Agent') {
            $noticeSttingData = $agencyData?->notice_setting ?? null;
          
            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'agents-notice'])->first();
            }
           
            
            $isInsertData = true;
            $sentId = $agencyData?->id ?? '';
            $SendData = $agencyData ?? '';
            $sendTypeTempalet = "Agent";
        }elseif (!empty($insurData) && $sendTo == 'Insured') {
            $noticeSttingData = $insurData?->notice_setting ?? null;
            if (empty($noticeSttingData)) {
                $noticeSttingData = Notice::getData(['type' => 'insureds-notice"'])->first();
            }
            
            $isInsertData = true;
            $sentId = $insurData?->id ?? '';
            $SendData = $insurData ?? '';
            $sendTypeTempalet = "Insured";
        }

         
        
        $sendToIdData = self::sendToId($noticeSttingData,$noticeAction,$sendBy,$SendData);
        $sendToTemp   = $sendToIdData?->sentTo;
        $sendType     =  !empty($sendToIdData?->sendType) ?  $sendToIdData?->sendType : $sendType; 

       
        $templateText   = !empty($templateText) ? RSC::noticeTemplated($templateText) : null;
        if ($isInsertData) {
            if (!empty($sendToTemp) && is_array($sendToTemp)) {
                foreach ($sendToTemp as $key => $value) {
                    $inserArray = [
                        'user_id' => auth()->user()->id,
                        'notice_id' => $noticeId,
                        'send_id' => $sentId,
                        'send_type' => $sendTypeTempalet,
                        'quote_id' => $qId ,
                        'version_id' => $vId,
                        'subject'    => $noticeName,
                        'notice_name' => $noticeName,
                        'notice_action' => $noticeAction,
                        'notice_type' => $templateType,
                        'template' => $templateText,
                        'send_by' => $sendType,
                        'send_to' => $value,
                        'account_number' => $accountNumber,
                        'account_id' => $accountId,
                      //  'shortcodes' => !empty($templateText?->replaceValues) ? json_encode($templateText?->replaceValues) : null,
                    ];
                    DailyNoticeModel::insertOrUpdate($inserArray);
                }
            } else {
                $inserArray = [
                    'user_id' => auth()->user()->id,
                    'notice_id' => $noticeId,
                    'send_id' => $sentId,
                    'send_type' => $sendTypeTempalet,
                    'quote_id' => $qId ,
                    'version_id' => $vId,
                    'subject' => $noticeName,
                    'notice_name' => $noticeName,
                    'notice_action' => $noticeAction,
                    'notice_type' => $templateType,
                    'template' => $templateText,
                    'send_by' => $sendType,
                    'send_to' => $sendToTemp,
                    'account_number' => $accountNumber,
                    'account_id' => $accountId,
                  //  'shortcodes' => !empty($templateText?->replaceValues) ? json_encode($templateText?->replaceValues) : null,
                    "status" => 1,
                ];
                DailyNoticeModel::insertOrUpdate($inserArray);
            }
        }
    }


}
