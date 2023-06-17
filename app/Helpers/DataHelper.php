<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Route;
use Config;
use App\Models\{
    User,Company,RateTable,CoverageType,StateSettings,QuoteSetting,MetaTag,UserPermission
};
use DB;
class DataHelper{


    /* get quote Setting */
    public static function QSetting($fieldName = ''){

        $data = QuoteSetting::getData()->first();
        if(!empty($fieldName)){
            $fieldValue =  $data->{$fieldName};
            return $fieldValue;
        }
        return $data;
    }


    /* get quote Setting */
    public static function userData(array $array,$fieldName=null){

       // $id = !empty($array['id']) ? $array['id'] : '' ;
        $data = User::getData($array)->first();
        if(!empty($fieldName)){
            $fieldValue =  $data->{$fieldName};
            return $fieldValue;
        }
        return $data;
    }

    /* get quote Setting */
    public static function metaValue($type=null,$key="css"){

        $value =  MetaTag::getData(['key'=>$key,'type'=>$type])->first()?->value;
     /*    dd( $value ); */
        return $value;
    }


    /* get quote Setting */
    public static function convenienceAllow($userData=null){

        if(empty($userData)){
            $userData = request()->user();
        }
        $userId = $userData?->id;
        $userType = $userData?->user_type;
        $role = $userData?->role;
        $convenienceShow = false;

        if($userType == User::ADMIN){
            $convenienceShow = true;
        }elseif($userType == User::COMPANYUSER && $role == 1){
            $convenienceShow = true;
        }else{
            $userPermission  = UserPermission::getData(['userType'=>$userData->user_type,'userId'=>$userId])->first();

            if(empty($userPermission)){
                $userPermission  = UserPermission::getData(['userType'=>$userData->user_type])->first();
            }

            $convenience_fee_override = $userPermission?->convenience_fee_override;
          
            if($convenience_fee_override == 'allow'){
                $convenienceShow = true;
            }
        }


        return $convenienceShow;
    }


}
