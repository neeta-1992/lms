<?php
/**
 * src/Builders/EncryptionEloquentBuilder.php.
 *
 */
namespace App\Encryption\Builders;
use Illuminate\Database\Eloquent\Builder;

class EncryptionEloquentBuilder extends Builder
{
    public function whereEncrypted($param1, $param2, $param3 = null)
    {
        $filter            = new \stdClass();
        $filter->field     = $param1;
        $filter->operation = isset($param3) ? $param2 : '=';
        $filter->value     = isset($param3) ? $param3 : $param2;
        $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);
        return self::whereRaw("CONVERT(AES_DECRYPT(FROM_BASE64({$filter->field}), '{$salt}') USING utf8mb4) {$filter->operation} ? ", [$filter->value]);
    }

    public function whereEn($param1, $param2, $param3 = null)
    {
        $filter            = new \stdClass();
        $filter->field     = $param1;
        $filter->operation = isset($param3) ? $param2 : '=';
        $filter->value     = isset($param3) ? $param3 : $param2;
        $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);
        return self::whereRaw("CONVERT(AES_DECRYPT(FROM_BASE64({$filter->field}), '{$salt}') USING utf8mb4) {$filter->operation} ? ", [$filter->value]);
    }

    public function orWhereEncrypted($param1, $param2, $param3 = null)
    {
        $filter            = new \stdClass();
        $filter->field     = $param1;
        $filter->operation = isset($param3) ? $param2 : '=';
        $filter->value     = isset($param3) ? $param3 : $param2;
        $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);
        return self::orWhereRaw("CONVERT(AES_DECRYPT(FROM_BASE64({$filter->field}), '{$salt}') USING utf8mb4) {$filter->operation} ? ", [$filter->value]);
    }

    public function whereLike($param1, $param2, $param3 = null)
    {

      $filter            = new \stdClass();
      $filter->field     = $param1;
     // $filter->operation = isset($param3) ? $param2 : '=';
      $filter->value     = isset($param3) ? $param3 : $param2;
      $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);
      return self::whereRaw("CONVERT(AES_DECRYPT(FROM_BASE64({$filter->field}), '{$salt}') USING utf8mb4) LIKE '%{$filter->value}%'");
    }

    public function whereConcatLike($param1, $param2, $param3 = null,$param4 = null){
        $filter            = new \stdClass();
        $filter->field     = $param1;
        $filter->field2    = $param2;
        $filter->operation = isset($param4) ? $param3 : '=';
        $filter->value = isset($param4) ? $param4 : $param3;
        $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);
        return self::whereRaw("CONCAT(CONVERT(AES_DECRYPT(FROM_BASE64(`{$filter->field}`), '{$salt}') USING utf8mb4),'
        ',CONVERT(AES_DECRYPT(FROM_BASE64({$filter->field2}), '{$salt}') USING utf8mb4)) {$filter->operation} '%{$filter->value}%'");
    }

    public function orwhereLike($param1, $param2, $param3 = null)
    {

      $filter            = new \stdClass();
      $filter->field     = $param1;
     // $filter->operation = isset($param3) ? $param2 : '=';
      $filter->value     = isset($param3) ? $param3 : $param2;
      $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);
      return self::orWhereRaw("CONVERT(AES_DECRYPT(FROM_BASE64({$filter->field}), '{$salt}') USING utf8mb4) LIKE '%{$filter->value}%'");
    }


    public function orderByEncrypted($param1, $param2, $param3 = null)
    {

      $filter            = new \stdClass();
      $filter->field     = $param1;
     // $filter->operation = isset($param3) ? $param2 : '=';
      $filter->value     = isset($param3) ? $param3 : $param2;
      $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);

      return self::orderByRaw("CONVERT(AES_DECRYPT(FROM_BASE64({$filter->field}), '{$salt}') USING utf8mb4)  {$filter->value}");
    }

    public function orderByEn($param1, $param2, $param3 = null)
    {
        $getEncryptable =  $this?->getModel()?->getEncryptable() ?? [];
        $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);    
        if(in_array($param1,$getEncryptable)){
            return self::orderByRaw("CONVERT(AES_DECRYPT(FROM_BASE64({$param1}), '{$salt}') USING utf8mb4)  {$param2}");
        }else{
            return self::orderBy($param1,$param2);
        }

    }

    public function eGroupBy($column) {
      $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);
      return self::groupByRaw("CONVERT(AES_DECRYPT(FROM_BASE64(`{$column}`), '{$salt}') USING utf8mb4)");
    }
}
