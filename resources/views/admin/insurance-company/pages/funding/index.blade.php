 <form class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}" method="post"
     x-data={FundingAddress:false}>

     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">General Agency Name</label>
         <div class="col-sm-9">
             <x-jet-input type="text" class="fw-600" name="name" required readonly  :value="$data['name']"/>

         </div>
     </div>

     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label">d/b/a (Legal Name if Different
             than General Agency Name)</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="legal_name" readonly :value="$data['legal_name']"/>

         </div>
     </div>
     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Remittance Paid</label>
         <div class="col-sm-3">
             {!! form_dropdown(
                 'entity_type',
                 ['ACH per policy', 'ACH per statement', 'Check per policy', 'Check per statement'],
                 '',
                 ['class' => 'w-50'],
             ) !!}

         </div>
     </div>

     <div class="d-none">
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Name of Financial
                 Institution</label>
             <div class="col-sm-9">
                 <x-jet-input type="text" name="financial_institution_name" required />
             </div>
         </div>
         <div class="form-group row">
             <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Bank Routing Number</label>
             <div class="col-sm-9">
                 <x-jet-input type="text" name="routing_number" required />
             </div>
         </div>
         <div class="form-group row">
             <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Bank Account Number</label>
             <div class="col-sm-9">
                 <x-jet-input type="text" name="account_number" required />
             </div>
         </div>
     </div>
     <div class="form-group row ">
         <label for="" class="col-sm-3 col-form-label requiredAsterisk">Remittance Schedule
         </label>
         <div class="col-sm-9">
             <div class="zinput zradio zradio-sm pb-0">
                 <input id="Remittance_schedule_option_Days_After" name="Remittance_schedule_option" type="radio"
                     required class="form-check-input" value="yes">
                 <label for="Remittance_schedule_option_Days_After"
                     class="ingnorTitleCase form-check-label d-flex align-items-center">
                     <x-jet-input type="text" name="Days_after_policy_inception_text"
                         style="width: 10% !important;" />
                     <span class="pl-3">Days After Policy Inception</span>
                 </label>
             </div>
             <div class="zinput zradio  zradio-sm pb-0">
                 <input id="Remittance_schedule_option_Month" name="Remittance_schedule_option" type="radio" required
                     class="form-check-input" value="no">
                 <label for="Remittance_schedule_option_Month"
                     class="ingnorTitleCase form-check-label d-flex align-items-center">
                     15 Days After the End of The Month of Policy Inception
                 </label>
             </div>
             <div class="zinput zradio zradio-sm pb-0">
                 <input id="Remittance_schedule_option_Policy" name="Remittance_schedule_option" type="radio" required
                     class="form-check-input" value="yes">
                 <label for="Remittance_schedule_option_Policy "
                     class="ingnorTitleCase form-check-label d-flex align-items-center">
                     <x-jet-input type="text" name="Days_after_1st_payment_due_date_text"
                         style="width: 10% !important;" />
                     <span class="pl-3">Days After Policy Inception</span>
                 </label>
             </div>
         </div>
     </div>


     <div class="form-group row">
         <label for="license_state" class="col-sm-3 col-form-label ">Funding Address</label>
         <div class="col-sm-9">
             <x-jet-checkbox for="Funding_address_checkbox"
                 @change="FundingAddress = $event.target.checked ? true : '';" labelText='Same as Mailing Address'
                 class="changesetup setup_fees" name="Funding_address_checkbox" id="Funding_address_checkbox"
                 value="true" />
         </div>
     </div>
     <div class="row" x-show="FundingAddress">
         <label for="primary_address" class="col-sm-3 col-form-label "></label>
         <div class="col-sm-9">
             <div class="form-group row">
                 <div class="col-md-12 mb-1">
                     <div class="form-group">
                         <input type="text" class="form-control input-sm" id="primary_address" placeholder=""
                             name="primary_address" required>
                     </div>
                 </div>
                 <div class="col-md-12 mb-1">
                     <div class="form-group">
                         <input type="text" class="form-control input-sm" id="primary_address" placeholder=""
                             name="primary_address" required>
                     </div>
                 </div>
                 <div class="col-md-6">
                     <input type="text" class="form-control input-sm" id="primary_address_city" placeholder=""
                         name="primary_address_city" required>
                 </div>
                 <div class="col-md-4">
                     {!! form_dropdown('primary_address_state', stateDropDown(), '', [
                         'class' => "ui dropdown input-sm
                                                                                                            w-100",
                         'required' => true,
                         'id' => 'primary_address_state',
                     ]) !!}
                 </div>
                 <div class="col-md-2">
                     <input type="text" class="form-control input-sm zip_mask" id="primary_address_zip"
                         name="primary_address_zip" placeholder="" required>
                 </div>
             </div>
         </div>
     </div>
     <div class="form-group row">
         <label for="license_state" class="col-sm-3 col-form-label ">Hold All Payables</label>
         <div class="col-sm-9">
             <x-jet-checkbox for="Remittance_schedule_checkbox" class="changesetup setup_fees"
                 name="Remittance_schedule_checkbox" id="Remittance_schedule_checkbox" value="true" />
         </div>
     </div>

     <div class="row">
         <div class="col-sm-12 p-0">
             <div class="table-responsive">
                 <table class="table">
                     <thead>
                         <tr>
                             <th>GL Accounts</th>
                             <th>Default Bank Account</th>
                             <th>Details</th>

                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td class="align-top" style="width: 255px; ">General - Default</td>
                             <td class="align-top" style="width: 300px; ">{!! form_dropdown('primary_address_state', ['test' => 'Test'], '', [
                                 'class' => 'w-100',
                                 'required' => true,
                                 'id' => 'primary_address_state',
                             ]) !!}</td>
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
                             <td class="align-top" style="width: 300px; ">{!! form_dropdown('primary_address_state', ['test' => 'Test'], '', [
                                 'class' => 'w-100',
                                 'required' => true,
                                 'id' => 'primary_address_state',
                             ]) !!}</td>
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
                             <td class="align-top" style="width: 300px; ">{!! form_dropdown('primary_address_state', ['test' => 'Test'], '', [
                                 'class' => 'w-100',
                                 'required' => true,
                                 'id' => 'primary_address_state',
                             ]) !!}</td>


                         </tr>

                         <tr class="border-0">
                             <td class="align-top" style="width: 255px; ">Deposit - eCheck:</td>
                             <td class="align-top" style="width: 300px; ">{!! form_dropdown('primary_address_state', ['test' => 'Test'], '', [
                                 'class' => 'w-100',
                                 'required' => true,
                                 'id' => 'primary_address_state',
                             ]) !!}</td>


                         </tr>
                         <tr>
                             <td class="align-top" style="width: 255px; ">Remittance - Default:</td>
                             <td class="align-top" style="width: 300px; ">{!! form_dropdown('primary_address_state', ['test' => 'Test'], '', [
                                 'class' => 'w-100',
                                 'required' => true,
                                 'id' => 'primary_address_state',
                             ]) !!}</td>
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
                             <td class="align-top" style="width: 300px; ">{!! form_dropdown('primary_address_state', ['test' => 'Test'], '', [
                                 'class' => 'w-100',
                                 'required' => true,
                                 'id' => 'primary_address_state',
                             ]) !!}</td>


                         </tr>
                         <tr class="border-0">
                             <td class="align-top" style="width: 255px; ">Deposit - eCheck:</td>
                             <td class="align-top" style="width: 300px; ">{!! form_dropdown('primary_address_state', ['test' => 'Test'], '', [
                                 'class' => 'w-100',
                                 'required' => true,
                                 'id' => 'primary_address_state',
                             ]) !!}</td>


                         </tr>



                     </tbody>
                 </table>
             </div>
         </div>
     </div>



     <x-button-group class="saveContacts" />
 </form>
