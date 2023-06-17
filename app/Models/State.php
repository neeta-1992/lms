<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;
use App\Traits\ModelAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StateSettings;
class State extends Model
{
    use HasFactory, EncryptedAttribute;
    use ModelAttribute;

    protected $fillable = ['state', 'short_name', 'region', 'relativity', 'tax', 'is_enabled',
        'filing_fee', 'filing_fee_type', 'service_fee', 'service_fee_type', 'stamping_fee', 'stamping_fee_type', 'transaction_fee',
        'transaction_fee_type', 'inspection_fee', 'multi_inspection_fee', 'surplusline_notices'];

    protected $encryptable = ['state', 'short_name', 'region', 'relativity', 'tax', 'is_enabled',
        'filing_fee', 'filing_fee_type', 'service_fee', 'service_fee_type', 'stamping_fee', 'stamping_fee_type', 'transaction_fee',
        'transaction_fee_type', 'inspection_fee', 'multi_inspection_fee', 'surplusline_notices'];



    public function state_setting()
    {
        return $this->hasOne(StateSettings::class, 'state', 'id');
    }


    public static function getData(array $array = null)
    {
        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        if (!empty($array['id'])) {
            $model = $model->decrypt($array['id']);
        }
        if (!empty($array['name'])) {
            $model = $model->whereEn('state',$array['name']);
        }
        return $model;
    }
}
