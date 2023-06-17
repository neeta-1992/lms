<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,CompanyEmailSetting,CompanyFaxSetting
};
use App\Traits\ModelAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Company extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }


     protected $fillable = [
        "user_id",'comp_name','comp_domain_name','comp_web_address','comp_logo_url','privacy_page_url','comp_nav_back_color_hex','comp_nav_back_color_rbg',
        'comp_nav_text_color_hex','date_format_value','time_format_value','ccpa_privacy_notice','final_approval','final_approval_users',
        'comp_nav_text_color_rbg', 'comp_nav_hover_color_hex','comp_nav_hover_color_rbg','primary_address','primary_address_city','primary_address_state','primary_address_zip', 'primary_telephone', 'alternate_telephone','fax','tin_select','tin','payment_coupons_address','payment_coupons_city','payment_coupons_state','payment_coupons_zip','comp_contact_name','comp_contact_email','office_location','comp_licenses','comp_state_licensed','finace_comp_contact_agents','finace_comp_contact_insureds','date_format','time_format','us_time_zone','e_signature','type','agency_data'
    ];


    protected $encryptable = [
        'comp_name','comp_domain_name','comp_web_address','comp_logo_url','privacy_page_url','comp_nav_back_color_hex','comp_nav_back_color_rbg',
        'comp_nav_text_color_hex','date_format_value','time_format_value','ccpa_privacy_notice',
        'comp_nav_text_color_rbg', 'comp_nav_hover_color_hex','comp_nav_hover_color_rbg','primary_address','primary_address_city','primary_address_state','primary_address_zip', 'primary_telephone', 'alternate_telephone','fax','tin_select','tin','payment_coupons_address','payment_coupons_city','payment_coupons_state','payment_coupons_zip','comp_contact_name','comp_contact_email','office_location','comp_licenses','comp_state_licensed','finace_comp_contact_agents','finace_comp_contact_insureds','date_format','time_format','us_time_zone','e_signature',
    ];

    /**
     * Get the user that owns the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'company_id');
    }

    /**
     * Get the companyFaxSettings associated with the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function companyFaxSettings()
    {
        return $this->hasOne(CompanyFaxSetting::class, 'company_id', 'id');
    }

      /**
     * Get the companyEmailSettings associated with the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function companyEmailSettings()
    {
        return $this->hasMany(CompanyEmailSetting::class, 'company_id', 'id');
    }



    public static function saveCompany(array $array){

        $id         = !empty($array['editId']) ? $array['editId'] : '' ;
        $uuid = !empty($array['uuid']) ? $array['uuid'] : '' ;
        $user_id    = !empty($array['user_id']) ? $array['user_id'] : '' ;
        $logsArr    = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : '' ;
        $onDB       = !empty($array['onDB']) ? $array['onDB'] : '' ;


        $model = new self;
        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $user_id;
        if(isset($array['final_approval'])){
            $inserArr['final_approval'] = !empty($array['final_approval']) ? true : false;
        }
/* dd($inserArr ); */


        if(!empty($logsArr)){
            $logsmsg = dbLogFormat($logsArr);
        }


        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }


       DB::beginTransaction();
       try {
            if(!empty($id)){
                $inserArr    = arrFilter($inserArr);
              /*   dd( $inserArr); */
                $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
                if(!empty($logsmsg)){
                    $logMsg   = __('logs.finance_company.edit')." ".$logsmsg ;
                    Logs::saveLogs(['type'=>'finance-company','type_id'=>$getdata->id,'message'=>$logMsg]);
                }
            }elseif(!empty($uuid)){
                $inserArr    = arrFilter($inserArr);
                $getdata = $model->updateOrCreate(['uuid'=>$uuid],$inserArr);
                if(!empty($logsmsg)){
                    $logMsg   = __('logs.finance_company.edit')." ".$logsmsg ;
                    Logs::saveLogs(['type'=>'finance-company','type_id'=>$getdata->id,'message'=>$logMsg]);
                }
            }else{
                $getdata  =  $model->create($inserArr);

            }
        } catch (\Throwable $th) {
           DB::rollback();
           throw new Error($th->getMessage());
      }
      DB::commit();
      return $getdata;

    }


    public static function getData(array $array=null){
		$type    = isset($array['type']) ? $array['type'] : null;
        $model = new self;
        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }
		if(isset($type)){
            $model = $model->where('type',$type);
        }
        return $model;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];




}
