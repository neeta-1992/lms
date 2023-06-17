<?php
namespace App\Traits;
use Config;
trait ModelAttribute {

    public $changesArr = [];

    

    public static function bootModelAttribute()
    {
        static::updating(function($model)
        {

            $changes = [];

            foreach($model->getDirty() as $key => $value){
                $getOriginal = $model->getOriginal($key);

                $value = property_exists($model, 'encryptable') ? decryptData($value) : $value;
                $original = property_exists($model, 'encryptable') ? decryptData($getOriginal) : $getOriginal;

                $changes[$key] = [
                    'old' => $original,
                    'new' => $value,
                ];
            }
            $model->changesArr = $changes;


        });
    }
    /*
      MD5 Encrypted Id Check
    */
    public function scopeDecrypt($query,$arg,$fied=null){
        $id = decryptUrl($arg);
        $fied = !empty($fied) ? $fied : "id";
        return $query->whereRaw("{$fied} = '{$id}'");
    }




}
