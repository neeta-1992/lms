<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $typeArr   =  rateTableTypeDropDown();
        $typeKey   =  !empty($typeArr) ? implode(",",array_keys($typeArr)) : '';

        $actyArr   =  rateTableAccountType();
        $atypeKey   =  !empty($actyArr) ? implode(",",array_keys($actyArr)) : '';
        return [
            "name"          => "required|string",
            "type"          => "required|in:".$typeKey,
            "account_type"  => "required|in:".$atypeKey,
            "state"         => "required",
            "coverage_type"  => "required",
            "description"  => "nullable",
        ];
    }
}
