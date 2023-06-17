<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Str,Error,Mail,Carbon\Carbon;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Traits\UUID;
use App\Mail\ForgotPassword;
class PasswordReset extends Model
{
    use HasFactory;
    use ModelAttribute;
    use UUID;

    public $timestamps = false;
    protected $fillable = ['id','username','token','user_type'];


    public static function resetPassword(array $array){

        $username = isset($array['username']) ? $array['username'] : '' ;
        $email    = isset($array['email']) ? $array['email'] : '' ;
        $name     = isset($array['name']) ? $array['name'] : '' ;
        $userType = isset($array['userType']) ? $array['userType'] : '' ;
        $token = Str::uuid().time().Str::random(20);


        $verify = self::getData(['username'=>$username]);
        if ($verify->exists()) {
            $verify->delete();
        }
        $model = new self;
        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        $data = $model->create([
            'username'      => $username,
            'token'         => $token,
            'user_type'     => $userType,
            'created_at'    => Carbon::now()
        ]);

        $url = routeCheck('reset.password.get',['token'=>$token]);
        Mail::to($email)->send(new ForgotPassword(['name'=>$name,'url'=>$url]));

        return true;

    }


    public static function getData(array $array){

        $model =  new self;
          if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        if(isset($array['username'])){
            $model = $model->where('username',$array['username']);
        }
        if(isset($array['token'])){
            $model = $model->where('token',$array['token']);
        }


        return $model;
    }




}
