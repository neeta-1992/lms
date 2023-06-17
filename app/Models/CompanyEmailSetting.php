<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Traits\ModelAttribute;
class CompanyEmailSetting extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = ['company_id','type','email','username','outgoing_server','passward','authentication','imap','port','smpt_secure'];


    protected $encryptable = ['type','email','username','outgoing_server','passward','authentication','imap','port','smpt_secure'];




    public static function saveData(array $array){

        $editId             = !empty($array['editId']) ? $array['editId'] : '' ;
        $company_id         = !empty($array['company_id']) ? $array['company_id'] : '' ;
        $type               = !empty($array['type']) ? $array['type'] : '' ;
        $email              = !empty($array['email']) ? $array['email'] : '' ;
        $username           = !empty($array['username']) ? $array['username'] : '' ;
        $outgoing_server    = !empty($array['outgoing_server']) ? $array['outgoing_server'] : '' ;
        $passward           = !empty($array['passward']) ? $array['passward'] : '' ;
        $authentication     = !empty($array['authentication']) ? $array['authentication'] : '' ;
        $imap               = !empty($array['imap']) ? $array['imap'] : '' ;
        $port               = !empty($array['port']) ? $array['port'] : '' ;
        $smpt_secure        = !empty($array['smpt_secure']) ? $array['smpt_secure'] : '' ;
        $onDB               = !empty($array['onDB']) ? $array['onDB'] : '' ;

       $inserArr = [
            'company_id'  =>$company_id,
            'type'  =>$type,
            'email'=>$email,
            'username'=>$username,
            'outgoing_server'=>$outgoing_server,
            'passward'=>$passward,
            'authentication'=>$authentication,
            'imap'=>$imap,
            'port'=>$port,
            'smpt_secure'=>$smpt_secure,
       ];

        $model  = new self;
       if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            if(!empty($editId)){
                $inserArr = array_filter($inserArr);
                $data     = $model->whereEncrypted('type',$type)->updateOrCreate(['company_id'=>$editId],$inserArr);
            }else{
                $data        =  $model->create($inserArr);
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
