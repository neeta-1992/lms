<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinanceCompanyRequest extends FormRequest
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
        $id = $this->route('finance_company');

        return [
            'comp_name' => "required|unique_encrypted:companies,comp_name,uuid,".$id,
            'comp_domain_name' => "required|unique_encrypted:companies,comp_domain_name,uuid,".$id,
        ];
    }

     /**
        * Get the validation attributes that apply to the request.
        *
        * @return array
    */
    public function attributes()
    {
        return [
            'comp_name'         => trans("labels.name"),
            'comp_domain_name'  => trans("labels.domain_name"),
        ];
    }

    /**
        * Get the validation messages that apply to the request.
        *
        * @return array
        */
    public function messages(){

        return [
            'comp_name.required' => __('validation.required',['attribute' => trans("labels.name")]),
            'comp_domain_name.required' => __('validation.required',['attribute' => trans("labels.domain_name")]),
            'comp_name.unique_encrypted' => __('validation.unique',['attribute' => trans("labels.name")]),
            'comp_domain_name.unique_encrypted' => __('validation.unique',['attribute' => trans("labels.company_name")]),
        ];
    }
}
