<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Traits\ModelAttribute;
class CompanyFaxSetting extends Model
{
     use HasFactory;
      use ModelAttribute;
     use EncryptedAttribute;



    protected $fillable = ['company_id','use_security_code','security_code','use_subject', 'fax_email','forward_incoming_faxes','outgoing_fax_numbers','server_email',  'server_email_domain','signed_agreement_fax_one', 'signed_agreement_fax_two', 'attachment_fax_one', 'attachment_fax_two', 'can_spam_notice','copy_right_notice'];

    protected $encryptable =[ 'fax_email','use_security_code','security_code','use_subject','forward_incoming_faxes','outgoing_fax_numbers','server_email',  'server_email_domain','signed_agreement_fax_one', 'signed_agreement_fax_two', 'attachment_fax_one', 'attachment_fax_two', 'can_spam_notice','copy_right_notice'];


    public static function saveData(array $array){
        $editId                     = !empty($array['editId']) ? $array['editId'] : '' ;
        $company_id                 = !empty($array['company_id']) ? $array['company_id'] : '' ;
        $fax_email                  = !empty($array['fax_email']) ? $array['fax_email'] : '' ;
        $outgoing_fax_numbers       = !empty($array['outgoing_fax_numbers']) ? $array['outgoing_fax_numbers'] : '' ;
        $server_email               = !empty($array['server_email']) ? $array['server_email'] : '' ;
        $signed_agreement_fax_one   = !empty($array['signed_agreement_fax_one']) ? $array['signed_agreement_fax_one'] : '' ;
        $signed_agreement_fax_two   = !empty($array['signed_agreement_fax_two']) ? $array['signed_agreement_fax_two'] : '' ;
        $attachment_fax_one         = !empty($array['attachment_fax_one']) ? $array['attachment_fax_one'] : '' ;
        $attachment_fax_two         = !empty($array['attachment_fax_two']) ? $array['attachment_fax_two'] : '' ;
        $can_spam_notice            = !empty($array['can_spam_notice']) ? $array['can_spam_notice'] : '' ;
        $copy_right_notice          = !empty($array['copy_right_notice']) ? $array['copy_right_notice'] : '' ;
        $server_email_domain        = !empty($array['server_email_domain']) ? $array['server_email_domain'] : '' ;
        $onDB                       = !empty($array['onDB']) ? $array['onDB'] : '' ;


        $model = new self;
        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['company_id'] = $company_id;
/* dd($inserArr); */

        if(GateAllow('isAdminCompany') || !empty($onDB)){
        $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            if(!empty($editId)){
                $inserArr = array_filter($inserArr);
                $data     = $model->updateOrCreate(['company_id'=>$editId],$inserArr);

            }else{
                $data     =  $model->create($inserArr);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }
        DB::commit();
        return $data;
    }
     public static function getData(array $array = null)
    {

        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        return $model;
    }
}
