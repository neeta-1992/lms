<div>
    <table class="table">
        <tbody>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Last Modified Date</td>
                <td>
                    <x-jet-input type="text" name="" class='w-25' readonly value="{{ changeDateFormat($quoteData->updated_at ?? '') }}" />
                </td>
            </tr>
            @if(!empty($userData))
                <tr class="underwriting_information_html">
                    <td style="width:400px;">@lang('Reassign')</td>
                    <td>
                        <div class="form-group">
                      
                        <x-select :options="$userData" name="reassign" class="ui dropdown w-25" :selected="($data['reassign'] ?? '')" placeholder="Select" /></div>
                    </td>
                </tr>
            @endif


            <tr class="underwriting_information_html">
                <td style="width:400px;">Does the Insured Name and Address Match the Name and Address Listed at the Finance Agreement?</td>
                <td>
                    <div class="d-flex">
                        <x-input-radio inline name="insured_match" value="Yes" label="{{ __('labels.yes') }}"  :checked="((!empty($data['insured_match']) &&  $data['insured_match'] == 'Yes') ? true : false)" />
                        <x-input-radio inline name="insured_match" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['insured_match']) &&  $data['insured_match'] == 'No') ? true : false)" />
                        <x-jet-input type="text" name="insured_match_text" class="zinput-inline w-75"  value="{{ $data['insured_match_text'] ?? '' }}" />
                    </div>
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Total Premium Match the Quote(s)?</td>
                <td>

                    <x-input-radio inline name="total_premium_match" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['total_premium_match']) &&  $data['total_premium_match'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="total_premium_match" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['total_premium_match']) &&  $data['total_premium_match'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="total_premium_match_text" class="zinput-inline w-75" value="{{ $data['total_premium_match_text'] ?? '' }}" />

                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does the Agency Name Matches the Quote?</td>
                <td>
                    <x-input-radio inline name="agency_name" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['agency_name']) &&  $data['agency_name'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="agency_name" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['agency_name']) &&  $data['agency_name'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="agency_name_text" class="zinput-inline w-75" value="{{ $data['agency_name_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Any Prior Finance Agreement With the Insured?</td>
                <td>
                    <x-input-radio inline name="prior_finance_agreement" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['prior_finance_agreement']) &&  $data['prior_finance_agreement'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="prior_finance_agreement" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['prior_finance_agreement']) &&  $data['prior_finance_agreement'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="prior_finance_agreement_text" class="zinput-inline w-75" value="{{ $data['prior_finance_agreement_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Down Payment Received by the General Agent?</td>
                <td>
                    <x-input-radio inline name="payment_received_general_agent" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['payment_received_general_agent']) &&  $data['payment_received_general_agent'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="payment_received_general_agent" value="Pending" label="{{ __('labels.pending') }}" :checked="((!empty($data['payment_received_general_agent']) &&  $data['payment_received_general_agent'] == 'Pending') ? true : false)" />
                    <x-jet-input type="text" name="payment_received_general_agent_text" class="zinput-inline w-75" value="{{ $data['payment_received_general_agent_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Insured Telephone # Match the Quote?</td>
                <td>
                    <x-input-radio inline name="insured_telephone" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['insured_telephone']) &&  $data['insured_telephone'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="insured_telephone" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['insured_telephone']) &&  $data['insured_telephone'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="insured_telephone_text" class="zinput-inline w-75" value="{{ $data['insured_telephone_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Insured Email Address Match the Quote?</td>
                <td>
                    <x-input-radio inline name="insured_email" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['insured_email']) &&  $data['insured_email'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="insured_email" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['insured_email']) &&  $data['insured_email'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="insured_email_text" class="zinput-inline w-75" value="{{ $data['insured_email_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Insured Address Match the Quote?</td>
                <td>
                    <x-input-radio inline name="insured_address" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['insured_address']) &&  $data['insured_address'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="insured_address" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['insured_address']) &&  $data['insured_address'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="insured_address_text" class="zinput-inline w-75" value="{{ $data['insured_address_text'] ?? '' }}" />

                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">When Is Payment Due?</td>
                <td>
                    <x-jet-input type="text" name="payment_due" class="w-25 singleDatePicker" value="{{ $data['payment_due'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Balance Due</td>
                <td>
                    <x-jet-input type="text" name="balance_due" class="w-25 amount" value="{{ $data['balance_due'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Name of Person You Spoke With</td>
                <td>
                    <x-jet-input type="text" name="person_spoke" class="w-25" value="{{ $data['person_spoke'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Telephone Number</td>
                <td>
                    <x-jet-input type="text" name="telephone_number" class="w-25 telephone zinput-inline" value="{{ $data['telephone_number'] ?? '' }}" />
                    <x-jet-input type="text" name="telephone_number_extenstion" class="w-25  zinput-inline" placeholder="Extension" value="{{ $data['telephone_number_extenstion'] ?? '' }}" />

                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Email</td>
                <td>
                    <x-jet-input type="email" name="email" class="w-50 zinput-inline" value="{{ $data['email'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Insurance Company Name Match the Quote?</td>
                <td>
                    <x-input-radio inline name="insurance_company_name" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['insurance_company_name']) &&  $data['insurance_company_name'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="insurance_company_name" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['insurance_company_name']) &&  $data['insurance_company_name'] == 'No') ? true : false)" />
                    <x-input-radio inline name="insurance_company_name" value="N/A" label="N/A" :checked="((!empty($data['insurance_company_name']) &&  $data['insurance_company_name'] == 'N/A') ? true : false)" />
                    <x-jet-input type="text" name="insurance_company_name_text" class="zinput-inline w-75" value="{{ $data['insurance_company_name_text'] ?? '' }}" />

                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does General Agent Name Match the Quote?</td>
                <td>
                    <x-input-radio inline name="general_agent_name" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['general_agent_name']) &&  $data['general_agent_name'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="general_agent_name" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['general_agent_name']) &&  $data['general_agent_name'] == 'No') ? true : false)" />
                    <x-input-radio inline name="general_agent_name" value="N/A" label="N/A" :checked="((!empty($data['general_agent_name']) &&  $data['general_agent_name'] == 'N/A') ? true : false)" />
                    <x-jet-input type="text" name="general_agent_name_text" class="zinput-inline w-75 policyinput" value="{{ $data['general_agent_name_text'] ?? '' }}" />

                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Broker Name Match the Quote?</td>
                <td>
                    <x-input-radio inline name="broker_name" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['broker_name']) &&  $data['broker_name'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="broker_name" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['broker_name']) &&  $data['broker_name'] == 'No') ? true : false)" />
                    <x-input-radio inline name="broker_name" value="N/A" label="N/A" :checked="((!empty($data['broker_name']) &&  $data['broker_name'] == 'N/A') ? true : false)" />
                    <x-jet-input type="text" name="broker_name_text" class="zinput-inline w-75 policyinput" value="{{ $data['broker_name_text'] ?? '' }}" />


                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Policy Number Match the Quote?</td>
                <td>
                    <x-input-radio inline name="policy_number" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['policy_number']) &&  $data['policy_number'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="policy_number" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['policy_number']) &&  $data['policy_number'] == 'N  o') ? true : false)" />
                    <x-jet-input type="text" name="policy_number_text" class="zinput-inline w-75 policyinput" value="{{ $data['policy_number_text'] ?? '' }}" />

                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Coverage Type Match the Quote?</td>
                <td>
                    <x-input-radio inline name="coverage_type" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['coverage_type']) &&  $data['coverage_type'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="coverage_type" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['coverage_type']) &&  $data['coverage_type'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="coverage_type_text" class="zinput-inline w-75 policyinput" value="{{ $data['coverage_type_text'] ?? '' }}" />


                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Policy Inception Date Match the Quote?</td>
                <td>
                    <x-input-radio inline name="policy_inception_date" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['policy_inception_date']) &&  $data['policy_inception_date'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="policy_inception_date" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['policy_inception_date']) &&  $data['policy_inception_date'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="policy_inception_date_text" class="zinput-inline w-75 policyinput" value="{{ $data['policy_inception_date_text'] ?? '' }}" />


                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Policy Terms Match the Quote?</td>
                <td>
                    <x-input-radio inline name="policy_terms" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['policy_terms']) &&  $data['policy_terms'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="policy_terms" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['policy_terms']) &&  $data['policy_terms'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="policy_terms_text" class="zinput-inline w-75 policyinput" value="{{ $data['policy_terms_text'] ?? '' }}" />


                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Policy Pure Premium Match the Quote?</td>
                <td>
                    <x-input-radio inline name="policy_premium" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['policy_premium']) &&  $data['policy_premium'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="policy_premium" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['policy_premium']) &&  $data['policy_premium'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="policy_premium_text" class="zinput-inline w-75 policyinput" value="{{ $data['policy_premium_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Policy Tax and Stamp Fee Match the Quote?</td>
                <td>
                    <x-input-radio inline name="policy_tax_stamp_fee" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['policy_tax_stamp_fee']) &&  $data['policy_tax_stamp_fee'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="policy_tax_stamp_fee" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['policy_tax_stamp_fee']) &&  $data['policy_tax_stamp_fee'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="policy_tax_stamp_fee_text" class="zinput-inline w-75 policyinput" value="{{ $data['policy_tax_stamp_fee_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Policy Fee Match the Quote?</td>
                <td>
                    <x-input-radio inline name="policy_fee" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['policy_fee']) &&  $data['policy_fee'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="policy_fee" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['policy_fee']) &&  $data['policy_fee'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="policy_fee_text" class="zinput-inline w-75 policyinput" value="{{ $data['policy_fee_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Inspection Fee Match the Quote?</td>
                <td>
                    <x-input-radio inline name="inspection_fee" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['inspection_fee']) &&  $data['inspection_fee'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="inspection_fee" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['inspection_fee']) &&  $data['inspection_fee'] == 'No') ? true : false)" />
                    <x-input-radio inline name="inspection_fee" value="N/A" label="N/A" :checked="((!empty($data['inspection_fee']) &&  $data['inspection_fee'] == 'N/A') ? true : false)" />
                    <x-jet-input type="text" name="inspection_fee_text" class="zinput-inline w-75 policyinput" value="{{ $data['inspection_fee_text'] ?? '' }}" />

                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Does Cancel Terms Match the Quote?</td>
                <td>
                    <x-input-radio inline name="cancle_terms" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['cancle_terms']) &&  $data['cancle_terms'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="cancle_terms" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['cancle_terms']) &&  $data['cancle_terms'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="cancle_terms_text" class="zinput-inline w-75 policyinput" value="{{ $data['cancle_terms_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Is Policy Subject to Short Rate?</td>
                <td>
                    <x-input-radio inline name="short_rate" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['short_rate']) &&  $data['short_rate'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="short_rate" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['short_rate']) &&  $data['short_rate'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="short_rate_text" class="zinput-inline w-75 policyinput" value="{{ $data['short_rate_text'] ?? '' }}" />

                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Is Policy Subject to Minimum Earned?</td>
                <td>
                    <x-input-radio inline name="minimum_earned" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['minimum_earned']) &&  $data['minimum_earned'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="minimum_earned" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['minimum_earned']) &&  $data['minimum_earned'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="minimum_earned_text" class="zinput-inline w-75 policyinput" value="{{ $data['minimum_earned_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Is Policy Subject to Puc/Filings?</td>
                <td>
                    <x-input-radio inline name="puc_filings" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['puc_filings']) &&  $data['puc_filings'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="puc_filings" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['puc_filings']) &&  $data['puc_filings'] == 'No') ? true : false)" />
                    <x-input-radio inline name="puc_filings" value="N/A" label="N/A" :checked="((!empty($data['puc_filings']) &&  $data['puc_filings'] == 'N/A') ? true : false)" />
                    <x-jet-input type="text" name="puc_filings_text" class="zinput-inline w-75 policyinput" value="{{ $data['puc_filings_text'] ?? '' }}" />
                </td>
            </tr>
            <tr class="underwriting_information_html">
                <td style="width:400px;">Is Policy Cancellation Pro Rata?</td>
                <td>
                    <x-input-radio inline name="cancellation_prorata" value="Yes" label="{{ __('labels.yes') }}" :checked="((!empty($data['cancellation_prorata']) &&  $data['cancellation_prorata'] == 'Yes') ? true : false)" />
                    <x-input-radio inline name="cancellation_prorata" value="No" label="{{ __('labels.no') }}" :checked="((!empty($data['cancellation_prorata']) &&  $data['cancellation_prorata'] == 'No') ? true : false)" />
                    <x-jet-input type="text" name="cancellation_prorata_text" class="zinput-inline w-75 policyinput" value="{{ $data['cancellation_prorata_text'] ?? '' }}" />
                </td>
            </tr>
        </tbody>

    </table>
</div>
