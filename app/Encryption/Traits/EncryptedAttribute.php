<?php
namespace App\Encryption\Traits;
use App\Encryption\Builders\EncryptionEloquentBuilder;
use App\Encryption\Encrypter;
trait EncryptedAttribute {

    //public static $enableEncryption = true;
   /*  public function __construct() {
      self::$enableEncryption = config('encryption.enable_encryption');
    } */

    // protected function for humans features
    public function getEncryptable() {
       return $this->encryptable ?? [];
    }

     /**
     * @param $key
     * @return bool
     */
    public function isEncryptable($key)
    {
        $enableEncryption = config('encryption.enable_encryption');
        if($enableEncryption){
            return in_array($key, $this->encryptable);
        }

        return false;
    }


    /**
     * @return mixed
     */
    public function getEncryptableAttributes()
    {
        return $this->encryptable;
    }


    public function getAttribute($key)
    {
      $value = parent::getAttribute($key);
      if ($this->isEncryptable($key) && $this->isEncrypt($value))
      {
        try {
          $value = Encrypter::decrypt($value);
        } catch (\Exception $th) {}
      }
      return $value;
    }

    public function setAttribute($key, $value)
    {

      if ($this->isEncryptable($key) && (!is_null($value) && $value != ''))
      {
        try {
          $value = Encrypter::encrypt($value);
        } catch (\Exception $th) {}
      }
      return parent::setAttribute($key, $value);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        if ($attributes) {
          foreach ($attributes as $key => $value)
          {

            if ($this->isEncryptable($key) &&  $this->isEncrypt($value))
            {
              try {
                $attributes[$key] = Encrypter::decrypt($value);
              } catch (\Exception $th) {}
            }else{
                $attributes[$key] = $this->isEncrypt($value) ? Encrypter::decrypt($value) : $value ;
            }
          }
        }
        return $attributes;
    }

    // Extend EncryptionEloquentBuilder
    public function newEloquentBuilder($query)
    {
        return new EncryptionEloquentBuilder($query);
    }

    /**
     * Decrypt Attribute
     *
     * @param string $value
     *
     * @return string
     */
    public function decryptAttribute($value)
    {
       return $this->isEncrypt($value) ? Encrypter::decrypt($value) : $value;
    }

    /**
     * Encrypt Attribute
     *
     * @param string $value
     *
     * @return string
     */
    public function encryptAttribute($value)
    {
        return (!is_null($value) && $value != '') ? Encrypter::encrypt($value) : $value;
    }

    public function isEncrypt($str)
    {

        return isEncryptValue($str);

    }
}
