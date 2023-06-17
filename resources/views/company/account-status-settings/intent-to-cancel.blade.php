 <div class="row" x-data="{ accountDay: '{{ $data['account_days_overdue'] ?? '' }}' }">
     <div class="col-lg-8 col-md-8 col-xs-12 js-content Account_Status_Settings_first_table">
         <div class="docs-table nothover Account_Status_Settings">

             <table data-toggle="table" data-buttons-class="default borderless" class="table table-bordered table-hover"
                 id="intenttocancel">
                 <thead>
                     <tr class="d-none">
                         <th data-field="title" ></th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="">Affects accounts in Open status</td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">START</td>
                     </tr>
                     <tr>
                         <td class="center">Each account in open status will be processed as show below during
                             'Update Account Status' processing</td>
                     </tr>
                     <tr>
                         <td class="">
                             <div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i>
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">Is the account <span
                                 class="account_days_overdue" x-text="accountDay"></span> days overdue?</td>
                     </tr>
                     <tr>
                         <td class="">Have
                             <x-jet-input name="account_days_overdue" type="text" class="digitLimit d-inline fw-600"
                                 data-limit="2" @input.debounce.100ms="accountDay = $event.target.value" maxlength="2"
                                 style="width:50px;" value="{{ $data['account_days_overdue'] ?? '' }}" />
                             days elapsed since the payment
                             was due (all states)<br>
                             <ul style="list-style-type:none;" class="mb-0">
                                 <li>AND is there a positive balance due(excluding fee receivables) that exceeds
                                     the maximum automatic write-off amount of $1.00</li>
                                 <li>AND is the account active (not suspended)?</li>
                             </ul>
                         </td>
                     </tr>
                     <tr>
                         <td class="">
                             <div class="w-100 clearfix">
                                 <div class="doublearrowiconstext" style=""><i
                                         class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div>
                                 <div class="font-weight-bold"> YES</div>
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">Move to "Intent to cancel" status
                         </td>
                     </tr>
                     <tr>
                         <td class="">Set cancellation to
                             <x-jet-input name="personal_lines_days" type="text" class="digitLimit d-inline fw-600"
                                 data-limit="2" style="width:50px;" value="{{ $data['personal_lines_days'] ?? '' }}" />
                             days after today's date for personal lines and <br>
                             <x-jet-input name="commercial_lines_days" type="text"
                                 class="digitLimit d-inline fw-600 mt-1" data-limit="2"
                                 style="width:50px;margin-left:121px;" value="{{ $data['commercial_lines_days'] ?? '' }}" />
                             days after
                             today's date for commercial lines (in CA only)<br>Generate intent to cancel notice
                         </td>
                     </tr>
                     <tr>
                         <td class="">
                             <div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i>
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">STOP</td>
                     </tr>
                     <tr>
                         <td class=" center">The account is now in 'Intent to cancel' status.
                         </td>
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
             <span class="righttable font-weight-bold" style="top: 217px;"><i
                     class="fa-2x fa-solid fa-arrow-right arrowicons"></i><br>NO</span>
             <table data-toggle="table" ddata-buttons-class="default borderless"
                 class="table table-bordered table-hover" id="intenttocancel2">
                 <thead>
                     <tr class="d-none">
                         <th data-field="title" ></th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="center text-dark bg-light font-weight-bold">STOP</td>
                     </tr>
                     <tr>
                         <td class=" center">The account remains in open status.</td>
                     </tr>
                 </tbody>
             </table>
         </div>
     </div>
 </div>
