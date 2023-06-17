<?php
namespace App\Helpers;


use App\Models\{
    User,NoticeTemplate,QuoteVersion,QuoteSignature,Quote,
    FinanceAgreement,Company,Entity,QuoteTerm,QuoteAccountExposure,Payment,TransactionHistory
};
use DOMDocument;
use Error;
use Str;


class UserReplaceShortCode{



    public mixed $template;
    public mixed $replaceValues;
    /*
     * Company Template Replace Shortcodes
     */

      /* Finance Company (FC) */
    public  function FCT(array $array=null)
    {

        $companyId      = !empty($array['companyId']) ? $array['companyId'] : 'null' ;
        $companyData    = !empty($array['companyData']) ? $array['companyData'] :null ;
        $template       = !empty($array['template']) ? $array['template'] : '' ;

        if(empty($companyData)){
            $companyData = request()->company_data;
        }

        /*if (empty($template)) {
            return $this;
        } */

        $imageUrl   = asset("assets/images/enetworks-cloud-computing-94.png");
        $logoUrl    = !empty($companyData?->comp_logo_url) ? $companyData?->comp_logo_url : '';
        $logoUrl    = (!empty($logoUrl) && urlExists($logoUrl)) ? $logoUrl : $imageUrl;
        $image      = "<img src='{$imageUrl}' alt='not image found'>";


        $arrKeyWithValue = [
            '{PF_Name}'             => $companyData?->comp_name,
            '{PF_P_Address}'        => $companyData?->primary_address,
            '{PF_P_City}'           => $companyData?->primary_address_city,
            '{PF_P_State}'          => $companyData?->primary_address_state,
            '{PF_P_Zip}'            => $companyData?->primary_address_zip,
            '{PF_M_Address}'        => "",
            '{PF_M_City}'           => "",
            '{PF_M_State}'          => "",
            '{PF_M_Zip}'            => "",
            '{PF_P_Telephone}'      => $companyData?->primary_telephone,
            '{PF_A_Telephone}'      => $companyData?->alternate_telephone,
            '{PF_Fax_1}'            => $companyData?->fax,
            '{PF_Fax_2}'            => $companyData?->fax,
            '{PF_Fax_1}'            => $companyData?->fax,
            '{PF_Fax_1}'            => $companyData?->fax,
            '{PF_Contact_Name}'     => $companyData?->company_contact_name,
            '{PF_P_Email}'          => $companyData?->comp_contact_email,
            '{PF_Office_Location}'  => $companyData?->office_location,
            '{PF_Licenses}'         => $companyData?->comp_licenses,
            '{PF_State_License}'    => $companyData?->comp_state_licensed,
            '{PF_Web}'              => $companyData?->company_web_address,
            '{PF_Logo_URL}'         => $logoUrl,
            '{Premium_Finance_Company_Logo}'  => $logoUrl,
            '{PF_Privacy_Page_URL}' => $companyData?->privacy_page_url,
            '{PF_PCIS_Address}'     => $companyData?->payment_coupons_address,
            '{PF_PCIS_City}'        => $companyData?->payment_coupons_city,
            '{PF_PCIS_State}'       => $companyData?->payment_coupons_state,
            '{PF_PCIS_Zip}'         => $companyData?->payment_coupons_zip,
            '{PFCF_P_Email}'        => $companyData?->companyFaxSettings?->fax_email,
            '{PFCSE_P_Domain}'      => $companyData?->companyFaxSettings?->server_email,
            '{PFCFS_P_Name}'        => $companyData?->companyFaxSettings?->server_email_domain,
            // '{Premium_Finance_Company_Signed_agreement_Fax_1}' => $companyData?->companyFaxSettings?->signed_agreement_fax_one,
            // '{Premium_Finance_Company_Signed_agreement_Fax_2}' => $companyData?->companyFaxSettings?->signed_agreement_fax_two,
            //  '{PFCEF_P_1}' => $companyData?->companyFaxSettings?->attachment_fax_one,
            // '{PFCEF_P_2}' => $companyData?->companyFaxSettings?->attachment_fax_two,
            // '{PF_CF_P_Faxes}' => $companyData?->companyFaxSettings?->forward_incoming_faxes,
            '{PF_CS_Notice}'         => $companyData?->companyFaxSettings?->can_spam_notice,
            '{PF_Copy_Right_Notice}' => $companyData?->companyFaxSettings?->copy_right_notice,
        ];

        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = [];
        return $this;
    }


    /* Insurance Company (IC) */
    public  function ICT(array $array=null)
    {

        $companyId      = !empty($array['id']) ? $array['id'] : 'null' ;
        $data           = !empty($array['data']) ? $array['data'] :null ;
        $template       = !empty($array['template']) ? $array['template'] : $this->template ;

        if(empty($data) && !empty($companyId)){
            $data = Entity::getData(['type'=>Entity::INSURANCECOMPANY,'id'=>$companyId])->first();
        }

        $companyData = $data;
        if((!empty($companyData) && !empty($template)) == false){
            return $this;
        }




        $arrKeyWithValue = [
            '{IC_Name}'                     => $companyData?->name,
            '{IC_Entity_Type}'              => $companyData?->entity_type,
            '{IC_FEIN}'                     => $companyData?->tax_id,
            '{IC_Agg_Limit}'                => $companyData?->aggregate_limit,
            '{IC_Agg_Limit_Outstandings}'   => $companyData?->current_aggregate_outstandings,
            '{IC_M_Adress}'                 => $companyData?->address,
            '{IC_M_City}'                   => $companyData?->city,
            '{IC_M_State}'                  => $companyData?->state,
            '{IC_M_Zip}'                    => $companyData?->zip,
            '{IC_Telephone}'                => $companyData?->telephone,
            '{IC_Fax}'                      => $companyData?->fax,
            '{IC_Domiciliary_State}'        => $companyData?->mailing_state,
            '{IC_Web}'                      => '',
            '{IC_Notes}'                    => $companyData?->notes,
        ];

        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }


    /* Agent Template */
    public  function AT(array $array=null){
        $id         = !empty($array['id']) ? $array['id'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data) && !empty($id)){
            $data =  User::getData(['type'=>User::AGENT,'id'=>$id])->first();
        }
        $agentData = $data;

        /*  if((!empty($agentData) && !empty($template)) == false){
            return $this;
        } */


        $arrKeyWithValue = [
            "{AG_Full_Name}"             =>  $agentData?->name ?? '',
            "{AG_First_Name}"            =>  $agentData?->first_name  ?? '',
            "{AG_Middle_Name}"           =>  $agentData?->middle_name ?? '',
            "{AG_Last_Name}"             =>  $agentData?->last_name ?? '',
            "{AG_Title}"                 =>  $agentData?->profile?->title ?? '',
            "{AG_DOB}"                   =>  (!empty($agentData?->profile?->month) ? $agentData?->profile?->month : '').'/'.(!empty($agentData?->profile?->day) ? $agentData?->profile?->day : ''),
            "{AG_Email}"                 =>  $agentData?->email ?? '',
            "{AG_Primary_Telephone}"     =>  $agentData?->mobile ?? '',
            "{AG_Alternate_Telephone}"   =>  $agentData?->alternate_telephone ?? '',
            "{AG_Agency_Name}"           =>  $agentData?->entity?->name ?? '',
            "{AG_Aggregate_Limit}"       =>  !empty($agentData?->entity?->aggregate_limit) ? dollerFA($agentData?->entity?->aggregate_limit) : '',
            "{AG_DBA}"                   =>  $agentData?->entity?->legal_name ?? '',
            "{AG_Entity_Type}"           =>  !empty($agentData?->entity?->entity_type) ? entityType($agentData?->entity?->entity_type) : '',
            "{AG_TIN}"                   =>  $agentData?->entity?->tin ?? '',
            "{AG_State_Resident}"        =>  $agentData?->profile?->state_resident?->state ?? '',
            "{AG_State_Resident_License}"=>  $agentData?->profile?->license_no ?? '',
            "{AG_License_Expiration_Date}" =>  !empty($agentData?->profile?->licence_expiration_date) ? changeDateFormat($agentData?->profile?->licence_expiration_date,true) : '',
            "{AG_Non_Resident_Insurance_License}" => '',
            "{AG_Year_Established}"      =>  "",
            "{AG_Telephone}"             =>  $agentData?->mobile ?? '',
            "{AG_Fax}"                   =>  $agentData?->email ?? '',
            "{Agency_Email}"             =>  $agentData?->entity?->email ?? '',
            "{AG_Website}"               =>  $agentData?->entity?->website ?? '',
            "{AG_Address}"               =>  $agentData?->entity?->address ?? '',
            "{AG_City}"                  =>  $agentData?->entity?->city ?? '',
            "{AG_State}"                 =>  $agentData?->entity?->state ?? '',
            "{AG_Zip}"                   =>  $agentData?->entity?->zip ?? '',
            "{AG_Mailing_Address}"       =>  $agentData?->entity?->mailing_address ?? '',
            "{AG_Mailing_City}"          =>  $agentData?->entity?->mailing_city ?? '',
            "{AG_Mailing_State}"         =>  $agentData?->entity?->mailing_state ?? '',
            "{AG_Mailing_Zip}"           =>  $agentData?->entity?->mailing_zip ?? '',
            "{AG_Comments}"              =>  '',
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }


    /* General Agent (GA) */
    public  function GAT(array $array=null){

        $id             = !empty($array['id']) ? $array['id'] : 'null' ;
        $data           = !empty($array['data']) ? $array['data'] :null ;
        $template       = !empty($array['template']) ? $array['template'] : $this->template ;

        if(empty($data) && !empty($id)){
            $companyData = Entity::getData(['type'=>Entity::GENERALAGENT,'id'=>$id])->first();
        }


       /*  if((!empty($data) && !empty($template)) == false){
            return $this;
        }
         */

        $arrKeyWithValue = [
            '{GA_Name}'                     => $data?->name ?? '',
            '{GA_Entity_Type}'              => $data?->entity_type ?? '',
            '{GA_TIN}'                      => $data?->tin ?? '',
            '{GA_Aggregate_Limit}'          => $data?->aggregate_limit ?? '',
            '{GA_State_Resident}'           => $data?->license_state ?? '',
            '{GA_License}'                  => $data?->address ?? '',
            '{GA_License_Epeiration_Date}'  => !empty($data?->licence_expiration_date) ? changeDateFormat($data?->licence_expiration_date,true) : '',
            '{GA_Email}'                    => $data?->email ?? '',
            '{GA_Telephone}'                => $data?->telephone ?? '',
            '{GA_Fax}'                      => $data?->fax ?? '',
            '{GA_Web}'                      => $data?->website ?? '',
            '{GA_P_Address}'                => $data?->address ?? '',
            '{GA_P_City}'                   => $data?->city ?? '',
            '{GA_P_State}'                  => $data?->state ?? '',
            '{GA_P_Zip}'                    => $data?->zip ?? '',
            '{GA_M_Aadress}'                => $data?->mailing_address ?? '',
            '{GA_M_City}'                   => $data?->mailing_city ?? '',
            '{GA_M_State}'                  => $data?->mailing_state ?? '',
            '{GA_M_Zip}'                    => $data?->mailing_zip ?? '',
            '{GA_O_Aadress}'                => $data?->address ?? '',
            '{GA_O_City}'                   => $data?->city ?? '',
            '{GA_O_State}'                  => $data?->state ?? '',
            '{GA_O_Zip}'                    => $data?->zip ?? '',
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }


    /* Insured (IN)*/
    public  function IT(array $array=null){

        $id         = !empty($array['id']) ? $array['id'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data) && !empty($id)){
            $data =  User::getData(['type'=>User::INSURED,'id'=>$id])->first();
        }


        $jsonData = !empty($data?->entity?->json) ? json_decode($data?->entity?->json) : null ;

        $arrKeyWithValue = [
            "{IN_Full_Name}"             =>  $data?->name ?? '',
            "{IN_Name}"                  =>  $data?->name ?? '',
            "{IN_First_Name}"            =>  $data?->first_name  ?? '',
            "{IN_M_Name}"                =>  $data?->middle_name ?? '',
            "{IN_Last_Name}"             =>  $data?->last_name ?? '',
            "{IN_Title}"                 =>  $data?->profile?->title ?? '',
            "{IN_DOB}"                   =>  (!empty($data?->profile?->month) ? $data?->profile?->month : '').'/'.(!empty($data?->profile?->day) ? $data?->profile?->day : ''),
            "{IN_Email}"                 =>  $data?->email ?? '',
            "{IN_P_Telephone}"           =>  $data?->mobile ?? '',
            "{IN_A_Telephone}"           =>  $data?->alternate_telephone ?? '',
            "{IN_Telephone}"             =>  $data?->mobile ?? '',
            "{IN_Fax}"                   =>  $data?->fax ?? '',
            "{IN_Entity_Name}"           =>  $data?->entity?->name ?? '',
            "{IN_DBA}"                   =>  $data?->entity?->legal_name ?? '',
            "{IN_Entity_Type}"           =>  !empty($data?->entity?->entity_type) ? entityType($data?->entity?->entity_type) : '',
            "{IN_TIN}"                   =>  $data?->entity?->tin ?? '',
            "{IN_P_Address}"             =>  $data?->entity?->address ?? '',
            "{IN_P_City}"                =>  $data?->entity?->city ?? '',
            "{IN_P_State}"               =>  $data?->entity?->state ?? '',
            "{IN_Address}"               =>  $data?->entity?->address ?? '',
            "{IN_P_Zip}"                 =>  $data?->entity?->zip ?? '',
            "{IN_M_Address}"             =>  $data?->entity?->mailing_address ?? '',
            "{IN_M_City}"                =>  $data?->entity?->mailing_city ?? '',
            "{IN_M_State}"               =>  $data?->entity?->mailing_state ?? '',
            "{IN_M_Zip}"                 =>  $data?->entity?->mailing_zip ?? '',
            "{IN_Decline_Reinstatement_Payment_Cancellation}" =>  !empty($jsonData->decline_reinstatement) ? ucfirst($jsonData->decline_reinstatement) : '',
            "{IN_Years_Business}"       =>  !empty($jsonData->years_business) ? ($jsonData->years_business) : '',
            "{IN_NAICS_Code}"           =>  !empty($jsonData->naics_code) ? ($jsonData->naics_code) : '',
            "{IN_DUNS}"                 =>  !empty($jsonData->duns) ? ($jsonData->duns) : '',
            "{IN_DB_Confidence_Code}"   =>  !empty($jsonData->dbconfidence_code) ? ($jsonData->dbconfidence_code) : '',
            "{IN_Notes}"                =>  !empty( $data?->entity?->notes ) ? $data?->entity?->notes  : '',
            "{IN_Open_Balance}"         => "",
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }



    /* Sales Organization (SO)*/
    public  function SO(array $array=null){
        $agentId = !empty($array['userId']) ? $array['userId'] : 'null' ;
        $data = !empty($array['data']) ? $array['data'] :null ;
        $template = !empty($array['template']) ? $array['template'] : '' ;
        if(empty($data)){
            $data =  Entity::getData(['type'=>Entity::SALESORG])->first();
        }

        $jsonData = !emptty($data?->json) ? json_decode($data?->json) : null ;


        $arrKeyWithValue = [
            "{SO_Name}"                  =>  $data?->name ?? '',
            "{SO_DBA}"                   =>  $data?->legal_name ?? '',
            "{SO_Type}"                  =>  !empty($data?->entity_type) ? entityType($data?->entity_type) : '',
            "{SO_TIN}"                   =>  $data?->tin ?? '',
            "{SO_Telephone}"             =>  $data?->telephone ?? '',
            "{SO_Fax}"                   =>  $data?->fax ?? '',
            "{SO_Email}"                 =>  $data?->email ?? '',
            "{SO_P_Address}"             =>  $data?->address ?? '',
            "{SO_P_City}"                =>  $data?->city ?? '',
            "{SO_P_State}"               =>  $data?->state ?? '',
            "{SO_Address}"               =>  $data?->address ?? '',
            "{SO_P_Zip}"                 =>  $data?->zip ?? '',
            "{SO_M_Address}"             =>  $data?->mailing_address ?? '',
            "{SO_M_City}"                =>  $data?->mailing_city ?? '',
            "{SO_M_State}"               =>  $data?->mailing_state ?? '',
            "{SO_M_Zip}"                 =>  $data?->mailing_zip ?? '',
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }



    /* Sales Excutive (SE)*/
    public  function SE(array $array=null){
        $agentId    = !empty($array['userId']) ? $array['userId'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  User::getData(['type'=>User::SALESORG])->first();
        }

        $jsonData = !emptty($data?->json) ? json_decode($data?->json) : null ;

        $arrKeyWithValue = [
            "{SE_Full_Name}"             =>  $data?->name ?? '',
            "{SE_Name}"                  =>  $data?->name ?? '',
            "{SE_First_Name}"            =>  $data?->first_name  ?? '',
            "{SE_M_Name}"                =>  $data?->middle_name ?? '',
            "{SE_Middle_Name}"           =>  $data?->middle_name ?? '',
            "{SE_Last_Name}"             =>  $data?->last_name ?? '',
            "{SE_Title}"                 =>  $data?->profile?->title ?? '',
            "{SE_DOB}"                   =>  (!empty($data?->profile?->month) ? $data?->profile?->month : '').'/'.(!empty($data?->profile?->day) ? $data?->profile?->day : ''),
            "{SE_Email}"                 =>  $data?->email ?? '',
            "{SE_P_Telephone}"           =>  $data?->mobile ?? '',
            "{SE_A_Telephone}"           =>  $data?->alternate_telephone ?? '',
            "{SE_Telephone}"             =>  $data?->mobile ?? '',
            "{SE_Fax}"                   =>  $data?->fax ?? '',

        ];

        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }


    /* Broker (BR) */
    public  function BR(array $array=null){
        $agentId = !empty($array['userId']) ? $array['userId'] : 'null' ;
        $data = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  Entity::getData(['type'=>Entity::BROKER])->first();
        }

        $jsonData = !emptty($data?->json) ? json_decode($data?->json) : null ;


        $arrKeyWithValue = [
            "{BR_Name}"                  =>  $data?->name ?? '',
            "{BR_DBA}"                   =>  $data?->legal_name ?? '',
            "{BR_Telephone}"             =>  $data?->telephone ?? '',
            "{BR_Fax}"                   =>  $data?->fax ?? '',
            "{BR_Email}"                 =>  $data?->email ?? '',
            "{BR_P_Address}"             =>  $data?->address ?? '',
            "{BR_P_City}"                =>  $data?->city ?? '',
            "{BR_P_State}"               =>  $data?->state ?? '',
            "{BR_Address}"               =>  $data?->address ?? '',
            "{BR_P_Zip}"                 =>  $data?->zip ?? '',
            "{BR_M_Address}"             =>  $data?->mailing_address ?? '',
            "{BR_M_City}"                =>  $data?->mailing_city ?? '',
            "{BR_M_State}"               =>  $data?->mailing_state ?? '',
            "{BR_M_Zip}"                 =>  $data?->mailing_zip ?? '',
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }


        /* Lienholder (LH) */
    public  function LH(array $array=null){
        $agentId = !empty($array['userId']) ? $array['userId'] : 'null' ;
        $data = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  Entity::getData(['type'=>Entity::LINEHOLDER])->first();
        }

        $jsonData = !emptty($data?->json) ? json_decode($data?->json) : null ;


        $arrKeyWithValue = [
            "{LH_Name}"                  =>  $data?->name ?? '',
            "{LH_DBA}"                   =>  $data?->legal_name ?? '',
            "{LH_Telephone}"             =>  $data?->telephone ?? '',
            "{LH_Fax}"                   =>  $data?->fax ?? '',
            "{LH_Email}"                 =>  $data?->email ?? '',
            "{LH_P_Address}"             =>  $data?->address ?? '',
            "{LH_P_City}"                =>  $data?->city ?? '',
            "{LH_P_State}"               =>  $data?->state ?? '',
            "{LH_Address}"               =>  $data?->address ?? '',
            "{LH_P_Zip}"                 =>  $data?->zip ?? '',
            "{LH_M_Address}"             =>  $data?->mailing_address ?? '',
            "{LH_M_City}"                =>  $data?->mailing_city ?? '',
            "{LH_M_State}"               =>  $data?->mailing_state ?? '',
            "{LH_M_Zip}"                 =>  $data?->mailing_zip ?? '',
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }


    /* Quote  Data  */
    public  function QT(array $array=null){
            $id         = !empty($array['id']) ? $array['id'] : 'null' ;
            $data       = !empty($array['data']) ? $array['data'] :null ;
            $template   = !empty($array['template']) ? $array['template'] : $this->template;
            if(empty($data)){
                $data =  Quote::getData(['id'=>$id ])->first();
            }



            $arrKeyWithValue = [
                "{Q_Number}"                 =>  $data?->qid ?? '',
                "{Q_Org_Stae}"               =>  $data?->quoteoriginationstate ?? '',
                "{Q_Type}"                   =>  $data?->quote_type ?? '',
                "{Q_Payment_Method}"         =>  $data?->payment_method ?? '',
                "{Q_LOB}"                    =>  $data?->account_type ?? '',
                "{Q_Email_Notification}"     =>  $data?->email_notification ?? '',
                "{Q_Ver_Num}"                =>  $data?->version ?? '',
                "{Insured_Name}"             =>  $data?->insured_user?->name ?? '',
                "{Agent_Name}"               =>  $data?->agent_user?->name ?? '',
                "{Insured_Existing_Balance}" =>  "",
            ];


            $keyArr         = array_keys($arrKeyWithValue);
            $valuesArr      = array_values($arrKeyWithValue);
            $template       = str_replace($keyArr,$valuesArr, $template);
            $this->template = $template;
            $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
            return $this;
    }


     /* Quote Term  Data  */
    public  function QTermT(array $array=null){
        $qId        = !empty($array['qId']) ? $array['qId'] : 'null' ;
        $vId        = !empty($array['vId']) ? $array['vId'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  QuoteTerm::getData(['qId'=>$qId,'vId'=>$vId])->first();
        }



        $arrKeyWithValue = [
        
            "{Q_No_Of_Payments}"                    =>  $data?->number_of_payment ?? '',
            "{Q_Down_Payment}"                      =>  $data?->down_payment ?? '',
            "{Setup_Fee_Down_Payment}"              =>  dollerFA($data?->setupfee_downpayment ?? ''),
            "{Q_Inception_Date}"                    =>  changeDateFormat($data?->inception_date ?? ''),
            "{First_Payment_Due_Date}"              =>  changeDateFormat($data?->first_payment_due_date ?? ''),
            "{Interest_Rate}"                       =>  pFormat($data?->number_of_payment ?? ''),
            "{Total_Setup_Fee}"                     =>  dollerFA($data?->number_of_payment ?? ''),
            "{Monthly_Due_Date}"                    =>  changeDateFormat($data?->number_of_payment ?? ''),
            "{Payment_Amount}"                      =>  dollerFA($data?->payment_amount ?? ''),
            "{Effective_APR}"                       =>  dollerFA($data?->effective_apr ?? ''),
            "{Amount_Financed}"                     =>  dollerFA($data?->amount_financed ?? ''),
            "{Premium_Financed}"                    =>  dollerFA($data?->pure_premium ?? ''),
            "{Doc_Stamp_Fees}"                      =>  dollerFA($data?->doc_stamp_fees ?? ''),
            "{Finance_Charge}"                      =>  dollerFA($data?->main_finance_charge ?? ''),
            "{Setup_Fee_Unpaid}"                    =>  "",
            "{Total_Payments}"                      =>  dollerFA($data?->total_payment ?? ''),
            "{Agent_Compensation}"                  =>  $data?->agent_compensation_data ?? '',
            "{Total_Pure_Premium}"                  =>  dollerFA($data?->total_premium ?? ''),
            "{Total_Premium}"                       =>  dollerFA($data?->total_premium ?? ''),
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }



    /* Quote Policy  Data  */
    public  function QPolicyT(array $array=null){
        $qId        = !empty($array['qId']) ? $array['qId'] : 'null' ;
        $vId        = !empty($array['vId']) ? $array['vId'] : 'null' ;
        $id         = !empty($array['id']) ? $array['id'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  QuotePolicy::getData(['id'=>$id])->first();
        }

        $insurance_company_data = $data->insurance_company_data;
        $general_agent_data     = $data->general_agent_data;



        $arrKeyWithValue = [
            "{Insurance_Company}"       =>  $insurance_company_data?->name ?? '',
            "{General_Agent}"           =>  $general_agent_data?->name ?? '',
            "{Broker}"                  =>  '',
            "{Policy_Number}"           =>  $data?->policy_number ?? 'TBD',
            "{Coverage_Type}"           =>  $data?->coverage_type_data?->name ?? '',
            "{Pure_Premium}"            =>  dollerFA($data?->pure_premium ?? "0.00"),
            "{Minimum_Earned_Premium}"  =>  dollerFA($data?->minimum_earned ?? "0.00"),
            "{Cancel_Term}"             =>  $data?->cancel_terms ?? '',
            "{Short_Rate}"              =>  $data?->short_rate ?? '',
            "{Auditable}"               =>  $data?->auditable ?? '',
            "{Inception_Date}"          =>  changeDateFormat($data?->inception_date ?? '',true),
            "{Policy_Term}"             =>  $data?->policy_term ?? '',
            "{Expiration_Date}"         =>  changeDateFormat($data?->expiration_date ?? '',true),
            "{First_Installment_Date}"  =>  changeDateFormat($data?->first_payment_due_date ?? '',true),
            "{Policy_Fee}"              =>  dollerFA($data?->policy_fee ?? "0.00"),
            "{Taxes_Stamp_Fees}"        =>  dollerFA($data?->taxes_and_stamp_fees ?? "0.00"),
            "{Broker_Fee}"              =>  dollerFA($data?->broker_fee ?? "0.00"),
            "{Inspection_Fee}"          =>  dollerFA($data?->inspection_fee ?? "0.00"),
            "{PUC_Filings}"             =>  $data?->puc_filings ?? '',
            "{Notes}"                   =>  $data?->notes ?? '',

        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }



    /* Notice (NO) Data  */
    public  function NoticeT(array $array=null){
        $id         = !empty($array['id']) ? $array['id'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  NoticeTemplate::getData(['id'=>$id])->first();
        }

        $arrKeyWithValue = [
            "{NO_ID}"                       =>  $data?->notice_id ?? '',
            "{NO_Created_Date}"             =>  changeDateFormat($data?->created_at ?? '',true),
            "{NO_Created_Date_Time}"        =>  changeDateFormat($data?->created_at ?? ''),
            "{NO_Last_Updated_Date_Time}"   =>  changeDateFormat($data?->updated_at ?? ''),
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }

     /* Account (A) Data  */
    public  function ACCT(array $array=null){
        $id         = !empty($array['id']) ? $array['id'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  QuoteAccount::getData(['id'=>$id])->first();
        }

        $arrKeyWithValue = [
            "{A_Number}"                    =>  $data?->account_number ?? '',
            "{Account_Number}"              =>  $data?->account_number ?? '',
            "{A_Intent_To_Cancel_Date}"     =>  "",
            "{A_Cancel_Date}"               =>  changeDateFormat($data?->cancel_date ?? ''),
            "{A_Current_Balance}"           =>  dollerFA($data?->insured_existing_balance ?? ''),
            "{Late_Charge}"                 =>  $data?->latecharge,
          
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }

    /* QuoteAccountExposure (QAE) Data  */
    public  function QAE(array $array=null){
        $id         = !empty($array['id']) ? $array['id'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $accountData   = !empty($array['accountData']) ? $array['accountData'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  QuoteAccountExposure::getData(['id'=>$id])->first();
        }
        $lateCharge = !empty($accountData?->late_fee) ? $accountData?->late_fee : '' ;
        

        $arrKeyWithValue = [
            "{Payment_Late_Charge}"                 =>  dollerFA($lateCharge + ($data?->amount_financed ?? 0)),
            "{Payment_Installment_Number}"          =>  $data?->payment_number,
            "{Payment_Installment_Due_Date}"        =>   changeDateFormat($data?->payment_due_date,true),
            "{Payment_Late_Charge_Installment_Due_Date}" =>  '',
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }


    /* Payment Table Data   */
    public  function PAYMENT(array $array=null){
        $id         = !empty($array['id']) ? $array['id'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  Payment::getData(['id'=>$id])->first();
        }
        

        $arrKeyWithValue = [
            "{Installment_Amount}"                  =>  dollerFA($data?->installment_pay ?? 0),
            "{Installment_Number}"                  =>  $data?->payment_number,
            "{Payment_Number}"                      =>  $data?->payment_number,
            "{Payment_Method}"                      =>  $data?->payment_method,
            "{Payment_Amount_Made}"                 =>  dollerFA($data?->amount ?? 0),
            "{Convenience_Fee}"                     =>  dollerFA($data?->convient_fee ?? 0),
            "{Late_Fee}"                            =>  dollerFA($data?->late_fee ?? 0),
            "{Cancellation_Fee}"                    =>  dollerFA($data?->cancel_fee ?? 0),
            "{NSF_Fee}"                             =>  dollerFA($data?->nsf_fee ?? 0),
            "{Amount}"                              =>  dollerFA($data?->amount ?? 0),
            "{Reference}"                           =>  $data?->reference,
            "{Received_From}"                       =>  $data?->received_from,
            "{Bank_Account}"                        =>  $data?->bank_data?->bank_name,
            "{Payment_Date}"                        =>   changeDateFormat($data?->created_at,true),
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }


    /* Transaction History   */
    public  function THT(array $array=null){
        $id         = !empty($array['id']) ? $array['id'] : 'null' ;
        $data       = !empty($array['data']) ? $array['data'] :null ;
        $template   = !empty($array['template']) ? $array['template'] : $this->template;
        if(empty($data)){
            $data =  TransactionHistory::getData(['id'=>$id])->first();
        }
        $prymentData = $data?->payment_data;

        $arrKeyWithValue = [
            "{Payment_Method}"                  =>  $data?->payment_method,
          
            "{Amount}"                          =>  dollerFA($data?->amount ?? 0),
            "{Received_From}"                   =>  dollerFA($data?->convient_fee ?? 0),
            "{Late_Fee}"                            =>  dollerFA($data?->late_fee ?? 0),
            "{Cancellation_Fee}"                    =>  dollerFA($data?->cancel_fee ?? 0),
            "{NSF_Fee}"                             =>  dollerFA($data?->nsf_fee ?? 0),
        ];


        $keyArr         = array_keys($arrKeyWithValue);
        $valuesArr      = array_values($arrKeyWithValue);
        $template       = str_replace($keyArr,$valuesArr, $template);
        $this->template = $template;
        $this->replaceValues = !empty($this->replaceValues) ? array_merge($this->replaceValues, $arrKeyWithValue) : $arrKeyWithValue;
        return $this;
    }



    public function __toString(){

        $response  = ['replaceValues'=>$this->replaceValues,'template'=>$this->template];
        return $response;
    }

}
