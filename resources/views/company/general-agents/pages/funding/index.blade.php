 <form class="validationForm editForm" novalidate action="{{ routeCheck($route . 'funding.save') }}" method="post"
     x-data="{ FundingAddress : '{{ $data['funding_address_checkbox'] ?? true }}' }">
  <input type="hidden" name="entity_id" value="{{ $id ?? '' }}">
  <input type="hidden" name="logsArr">
     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.general_agency_name') </label>
         <div class="col-sm-9">
             <x-jet-input type="text" class="fw-600" name="name"  readonly :value="($data['entity']['name'] ?? '')" />

         </div>
     </div>

     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label">@lang('labels.d_b_a')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="legal_name" readonly :value="($data['entity']['legal_name'] ?? '')" />

         </div>
     </div>
     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.remittance_paid')</label>
         <div class="col-sm-3">

             {!! form_dropdown(
                 'remittance_paid',
                 ['ACH per policy', 'ACH per statement', 'Check per policy', 'Check per statement'],
                 ($data['remittance_paid'] ?? ''),
                 ['class' => 'w-50','required' => true,],
                 true,
             ) !!}

         </div>
     </div>

     <div class="d-none remittance_paid_select_box">
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name_of_financial_institution')</label>
              
             <div class="col-sm-9">
                 <x-jet-input type="text" name="financial_institution_name" :value="($data['financial_institution_name'] ?? '')"/>
             </div>
         </div>
         <div class="form-group row">
             <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.bank_routing_number')</label>
             <div class="col-sm-9">
                 <x-jet-input type="text" name="routing_number" class="onlyNumber" :value="($data['routing_number'] ?? '')"/>
             </div>
         </div>
         <div class="form-group row">
             <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.bank_account_number') </label>
             <div class="col-sm-9">
                 <x-jet-input type="text" name="account_number" class="onlyNumber" :value="($data['account_number'] ?? '')"/>
             </div>
         </div>
     </div>
     <div class="form-group row ">
         <label for="" class="col-sm-3 col-form-label requiredAsterisk"> @lang('labels.remittance_schedule')
         </label>
         <div class="col-sm-9">
             <div class="zinput zradio zradio-sm pb-0">
                 <input id="Remittance_schedule_option_Days_After" name="remittance_schedule" type="radio" required
                     class="form-check-input" @checked(($data['remittance_schedule'] ?? '')  == 'Days After Policy Inception')  value="Days After Policy Inception">
                 <label for="Remittance_schedule_option_Days_After"
                     class="ingnorTitleCase form-check-label d-flex align-items-center">
                     <x-jet-input type="text" name="days_after_policy_inception_text"
                         style="width: 10% !important;" :value="($data['days_after_policy_inception_text'] ?? '')"/>
                     <span class="pl-3">@lang('labels.days_after_policy_inception')    </span>
                 </label>
             </div>
             <div class="zinput zradio  zradio-sm pb-0">
                 <input id="Remittance_schedule_option_Month" name="remittance_schedule" type="radio" required
                     class="form-check-input" @checked(($data['remittance_schedule'] ?? '') == '15 Days After the End of The Month of Policy Inception') value="15 Days After the End of The Month of Policy Inception">
                 <label for="Remittance_schedule_option_Month"
                     class="ingnorTitleCase form-check-label d-flex align-items-center">
                  @lang('labels.15_days_after_the_end_of_the_month_of_policy_inception')  
                 </label>
             </div>
             <div class="zinput zradio zradio-sm pb-0">
                 <input id="Remittance_schedule_option_Policy" name="remittance_schedule" type="radio" required
                     class="form-check-input" @checked(($data['remittance_schedule'] ?? '') == 'Days After 1st Payment Due Date') value="Days After 1st Payment Due Date">
                 <label for="Remittance_schedule_option_Policy"
                     class="ingnorTitleCase form-check-label d-flex align-items-center">
                     <x-jet-input type="text" name="days_after_1st_payment_due_date_text"
                         style="width: 10% !important;" :value="($data['days_after_1st_payment_due_date_text'] ?? '')"/>
                     <span class="pl-3">@lang('labels.days_after_1st_payment_due_date')</span>
                 </label>
             </div>

         </div>
     </div>


     <div class="form-group row">
         <label for="license_state" class="col-sm-3 col-form-label ">@lang('labels.funding_address')  </label>
         <div class="col-sm-9">
             <x-jet-checkbox for="funding_address_checkbox"
                 @change="FundingAddress = $event.target.checked ? true : '';" :checked="(($data['funding_address_checkbox'] ?? 1) == 1 ? true : false)"
                 labelText='Same as Mailing Address' class="changesetup setup_fees" name="funding_address_checkbox"
                 id="funding_address_checkbox" value="true" />
         </div>
     </div>
     <div class="row" x-show="FundingAddress == false">
         <label for="primary_address" class="col-sm-3 col-form-label "></label>
         <div class="col-sm-9">
             <div class="form-group row">
                 <div class="col-md-12 mb-1">
                     <div class="form-group">
                         <x-jet-input type="text" name="funding_address" :value="($data['funding_address'] ?? '')"  />

                     </div>
                 </div>
                 <div class="col-md-12 mb-1">
                     <div class="form-group">
                         <x-jet-input type="text" name="funding_address_second" :value="($data['funding_address_second'] ?? '')"/>

                     </div>
                 </div>
                 <div class="col-md-6">
                     <x-jet-input type="text" name="funding_city" placeholder="City" :value="($data['funding_city'] ?? '')"/>
                 </div>
                 <div class="col-md-4">
                     {!! form_dropdown('funding_state', stateDropDown(), ($data['funding_state'] ?? ''), [
                         'class' => "ui dropdown input-sm   w-100",

                         'id' => 'primary_address_state',
                     ]) !!}
                 </div>
                 <div class="col-md-2">
                     <x-jet-input type="text" name="funding_zip" placeholder="Zip" class="zip_mask" :value="($data['funding_zip'] ?? '')"/>

                 </div>
             </div>
         </div>
     </div>
     <div class="form-group row">
         <label for="license_state" class="col-sm-3 col-form-label ">@lang('labels.hold_all_payables')  </label>
         <div class="col-sm-9">
             <x-jet-checkbox for="hold_all_payables"  class="changesetup setup_fees" name="hold_all_payables"
                 id="hold_all_payables" value="true" :checked="(($data['hold_all_payables'] ?? '') == true ? 'checked' : '')"/>
         </div>
     </div>

     <div class="row">
         <div class="col-sm-12 p-0">
             <div class="table-responsive">
                 <table class="table">
                     <thead>
                         <tr>
                             <th>@lang('labels.gl_account') </th>
                             <th>@lang('labels.default_bank_account')   </th>
                             <th>@lang('labels.details') </th>

                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td class="align-top" style="width: 255px; ">General - Default</td>
                             <td class="align-top" style="width: 300px; ">
                                 <div class="form-group "> {!! form_dropdown('general_default', $bankData, $data['general_default'] ?? "", [
                                     'class' => 'w-100',
                                 ]) !!}</div>
                             </td>
                             <td class="align-top">
                                 <div>The Bank Account Specified here is used as The Default for The Following:</div>
                                 <ul>
                                     <li>General Ledger Export to track any transaction where a bank account was not
                                         specified,</li>
                                     <li>Down payment check entered during account activation when funding gross,</li>
                                     <li>Refund at Account Close,</li>
                                     <li>Refund at Flat Cancel, and</li>
                                     <li>Manual Refund.</li>
                                 </ul>
                             </td>

                         </tr>


                         <tr>
                             <td class="align-top" style="width: 255px; ">Deposit - Default:</td>
                             <td class="align-top" style="width: 300px; ">
                                 <div class="form-group ">
                                     {!! form_dropdown('deposit_default', $bankData,  ($data['deposit_default']  ?? "") , [
                                         'class' => 'w-100',
                                     ]) !!}</div>
                             </td>
                             <td class="align-top" rowspan="3">
                                 <div>The bank accounts specified here are used as the defaults on the following
                                     screens:</div>
                                 <ul>
                                     <li>Enter Payment,</li>
                                     <li>Enter Instant Payment,</li>
                                     <li>Enter Down Payment, and</li>
                                     <li>Enter Return Premium.</li>
                                 </ul>
                             </td>

                         </tr>
                         <tr class="border-0">
                             <td class="align-top" style="width: 255px; ">Deposit - Credit Card:</td>
                             <td class="align-top" style="width: 300px; ">
                                 <div class="form-group ">
                                     {!! form_dropdown('deposit_credit_card', $bankData, ($data['deposit_credit_card']  ?? "") , [
                                         'class' => 'w-100',
                                     ]) !!}</div>
                             </td>


                         </tr>

                         <tr class="border-0">
                             <td class="align-top" style="width: 255px; ">Deposit - eCheck:</td>
                             <td class="align-top" style="width: 300px; ">
                                 <div class="form-group ">
                                     {!! form_dropdown('deposit_eCheck', $bankData, ($data['deposit_eCheck']  ?? "") , [
                                         'class' => 'w-100',
                                     ]) !!}</div>
                             </td>


                         </tr>
                         <tr>
                             <td class="align-top" style="width: 255px; ">Remittance - Default:</td>
                             <td class="align-top" style="width: 300px; ">
                                 <div class="form-group ">
                                     {!! form_dropdown('remittance_default', $bankData,( $data['remittance_default']  ?? "" ), ['class' => 'w-100']) !!}</div>
                             </td>
                             <td class="align-top" rowspan="3">
                                 <div>The bank accounts specified here are used as the defaults for the following:</div>
                                 <ul>
                                     <li>Processing checks and</li>
                                     <li>Printing drafts.</li>
                                 </ul>
                             </td>

                         </tr>
                         <tr class="border-0">
                             <td class="align-top" style="width: 255px; ">Deposit - Credit Card:</td>

                             <td class="align-top" style="width: 300px; ">
                                 <div class="form-group ">
                                     {!! form_dropdown('remittance_check', $bankData, ($data['remittance_check']  ?? "") , [
                                         'class' => 'w-100',
                                     ]) !!}</div>
                             </td>


                         </tr>
                         <tr class="border-0">
                             <td class="align-top" style="width: 255px; ">Deposit - eCheck:</td>
                             <td class="align-top" style="width: 300px; ">
                                 <div class="form-group ">
                                     {!! form_dropdown('remittance_draft', $bankData, ($data['remittance_draft']  ?? "") , [
                                         'class' => 'w-100',
                                     ]) !!}</div>
                             </td>


                         </tr>



                     </tbody>
                 </table>
             </div>
         </div>
     </div>



     <x-button-group class="saveData" />
 </form>
