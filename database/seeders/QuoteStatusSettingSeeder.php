<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuoteStatusSetting;
class QuoteStatusSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $inserArr = [
            [
                'name' => 'Activation requested',
                'description' => 'Activation requested',
                'status' => 1,
            ], [
                'name' => 'Approved',
                'description' => 'Approved',
                'status' => 1,
            ], [
                'name' => 'Authorization requested',
                'description' => 'Authorization requested',
                'status' => 1,
            ], [
                'name' => 'Cancelled',
                'description' => 'Cancelled',
                'status' => 1,
            ], [
                'name' => 'Declined by company',
                'description' => 'Declined by company',
                'status' => 1,
            ], [
                'name' => 'Declined by insured',
                'description' => 'Declined by insured',
                'status' => 1,
            ], [
                'name' => 'New',
                'description' => 'New',
                'status' => 1,
            ], [
                'name' => 'Request final approval',
                'description' => 'Request final approval',
                'status' => 1,
            ], [
                'name' => 'Underwriting Verification',
                'description' => 'Company underwriting review',
                'status' => 1,
            ],
        ];

        if(!empty($inserArr)){
             foreach ($inserArr as $key => $value) {
                QuoteStatusSetting::insertOrUpdate($value);
             }
        }

    }
}
