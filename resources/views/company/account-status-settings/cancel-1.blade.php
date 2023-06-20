 <div class="row" x-data="{accountDay:'{{ $data['cancellation_notice_days'] ?? '' }}'}">
     <div class="col-lg-8 col-md-18 col-xs-12 js-content Account_Status_Settings_first_table">
         <div class="docs-table nothover Account_Status_Settings">
             <table id="Cancel1" data-toggle="table" data-buttons-class="default borderless" class="table table-bordered table-hover">
                 <thead>
                     <tr class="d-none">
                         <th data-field="title"></th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">START</td>
                     </tr>
                     <tr>
                         <td class=" center">Each account in cancel or cancel followup status will be processed as shown below during 'Update account status' processing.</td>
                     </tr>
                     <tr>
                         <td class="">
                             <div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div>
                         </td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">Is followup enabled and have more than <span class="cancellation_notice_days" x-text="accountDay"></span> days of elapsed?</td>
                     </tr>
                     <tr>
                         <td class="">Have more than
                             <x-jet-input name="cancellation_notice_days" type="text" class="digitLimit d-inline fw-600" data-limit="2" @input.debounce.100ms="accountDay = $event.target.value" maxlength="2" style="width:50px;" value="{{ $data['cancellation_notice_days'] ?? '' }}" />days elapsed since sending the cancellation notice (setting applies to all states; a value of 0 disables cancellation followup)<ul style="list-style-type:none;" class="mb-0">
                                 <li> AND is account in cancel(i.e. not cancel followup) status</li>
                                 <li>AND is there a positive balance due (excluding fee receipts and receivables) </li>
                                 <li>AND is the account active(not suspended)?</li>
                             </ul>
                         </td>
                     </tr>
                     <tr>
                         <td class="">
                             <div class="w-100 clearfix">
                                 <div class="doublearrowiconstext" style=""><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div>
                                 <div class="font-weight-bold"> NO</div>
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">Have all RPs been received?</td>
                     </tr>
                     <tr>
                         <td class="">Do all policies have a cancellation return premium applied <ul style="list-style-type:none;" class="mb-0">
                                 <li>AND is automatic update to cancel 1 status enabled</li>
                                 <li>AND is there a positive balance due (including fee receipts and fee receivables) </li>
                                 <li>AND is the account active (not suspended)?</li>
                             </ul>
                         </td>
                     </tr>
                     <tr>
                         <td class="">
                             <div class="w-100 clearfix">
                                 <div class="doublearrowiconstext" style=""><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div>
                                 <div class="font-weight-bold"> YES</div>
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">Move to 'Cancel 1' status</td>
                     </tr>
                     <tr>
                         <td class="">Generate 'cancel level one' notice if the balance due(including fee receipts and fee receivables)exceeds $
                             <x-jet-input name="cancel_level_one" value="{{ $data['cancel_level_one'] ?? '' }}" type="text" class="amount mt-1  fw-600 d-inline" style="width:100px;" placeholder="$" />
                             <br>(Note: this setting affects all level 1 and level 2 notices and applies to all states.)</td>
                     </tr>
                     <tr>
                         <td class="">
                             <div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div>
                         </td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">STOP</td>
                     </tr>
                     <tr>
                         <td class=" center">The account is now in 'Cancel 1' status.</td>
                     </tr>
                     <tr>
                         <td>
                             <x-button-group :cancel="routeCheck($route . 'show',[$id])" isClass=" btn btn-sm" :notlabel='true' />
                         </td>
                     </tr>
                 </tbody>
             </table>
         </div>
     </div>
     <div class="col-lg-4 col-md-4 col-xs-12 js-content Account_Status_Settings_second_table">
         <div class="docs-table nothover Account_Status_Settings">
             <span class="righttable font-weight-bold" style="margin-top: 170px;"><i class="fa-2x fa-solid fa-arrow-right arrowicons"></i><br>YES</span>
             <span class="righttable font-weight-bold" style="margin-top: 350px;"><i class="fa-2x fa-solid fa-arrow-right arrowicons"></i><br>NO</span>
             <table style="margin-top: 60px;" id="Cancel12" data-toggle="table" data-buttons-class="default borderless" class="table table-bordered table-hover">
                 <thead>
                     <tr class="d-none">
                         <th data-field="title"></th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">Move to 'Cancel followup' notice</td>
                     </tr>
                     <tr>
                         <td class="">Generate 'Cancel followup' notice</td>
                     </tr>
                     <tr>
                         <td class="center "><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">STOP</td>
                     </tr>
                     <tr>
                         <td class="">The account is now in 'Cancel followup' status. </td>
                     </tr>
                     <tr>
                         <td class="" style="border-left-color: white;border-right-color: white;padding:31px;"></td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">STOP</td>
                     </tr>
                     <tr>
                         <td class="">The account remains in 'Cancel or Cancel followup' status. </td>
                     </tr>
                 </tbody>
             </table>
         </div>
     </div>
 </div>
