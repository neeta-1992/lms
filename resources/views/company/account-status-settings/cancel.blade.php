  <div class="row"  x-data="{ accountDay: '{{ $data['fewer_days_remaining'] ?? '' }}' }">
			<div class="col-lg-8 col-md-8 col-xs-12 js-content Account_Status_Settings_first_table">
				<div class="docs-table nothover Account_Status_Settings">
					 <table id="Cancel"
                      data-toggle="table" data-buttons-class="default borderless"
                      class="table table-bordered table-hover">
						<thead>
							<tr class="d-none">
								<th data-field="title"></th>
							</tr>
						</thead>
						<tbody>
						    <tr>
								<td class="">Affects accounts in Intent to Cancel or Intent to Cancel Follow-up Status </td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">START</td>
							</tr>
							<tr>
								<td class=" center">Each account in intent to cancel or intent to cancel followup status will be processed as shown below during 'Update account status' processing.</td>
							</tr>
							<tr>
								<td class=""><div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">Is followup enabled and within <span class="fewer_days_remaining" x-text='accountDay'></span> days of cancel?</td>
							</tr>
							<tr>
								<td class="">Are there
                                     <x-jet-input name="fewer_days_remaining" type="text" class="digitLimit d-inline fw-600"
                                 data-limit="2" @input.debounce.100ms="accountDay = $event.target.value" maxlength="2"
                                 style="width:50px;" value="{{ $data['fewer_days_remaining'] ?? '' }}" /> or fewer days remaining until the cancel notice is sent ? (Setting applies to all states; a value of 0 disables intent to cancel followup)  <ul style="list-style-type:none;" class="mb-0"><li> AND is account in intent to cancel status</li>
								<li>AND is there a positive balance due (excluding fee receipts and receivables) </li> <li>AND is the account active(not suspended)?</li></ul>
								</td>
							</tr>
							<tr>
								<td class=""><div class="w-100 clearfix">
								<div class="doublearrowiconstext" style=""><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div><div class="font-weight-bold"> NO</div></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">On or after the scheduled cancellation date?</td>
							</tr>
							<tr>
								<td class="">Is today on or after the scheduled cancellation date <ul style="list-style-type:none;" class="mb-0"><li>AND is there a positive balance due(excluding fee receipts and fee receivables) that exceeds the maximum automatic write-off amount of $1.00</li><li>AND is the account active (not suspended)? </li></ul></td>
							</tr>
							<tr>
								<td class=""><div class="w-100 clearfix">
								<div class="doublearrowiconstext" style=""><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div><div class="font-weight-bold"> YES</div></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">Move to 'Cancel' status</td>
							</tr>
							<tr>
								<td class="">Add a cancellation fee of $ <x-jet-input name="commercial_lines" value="{{ $data['commercial_lines'] ?? '' }}" type="text" class="amount  fw-600 d-inline" style="width:100px;"   placeholder="$" />for commercial lines and <br><x-jet-input name="personal_lines" value="{{ $data['personal_lines'] ?? '' }}" type="text" class="amount fw-600 d-inline mt-1"
                                 style="width:100px;margin-left:175px;"   placeholder="$" />for personal lines (in CA only).<br>Set effective cancel date to
                                <x-jet-input name="cancel_date_personal_lines" value="{{ $data['cancel_date_personal_lines'] ?? '' }}" type="text" class="digitLimit mt-1 d-inline fw-600"
                                 data-limit="2"  maxlength="2"
                                 style="width:100px;" /> days after the cancel date for personal lines and <br>
                                 <x-jet-input name="cancel_date_commercial_lines" value="{{ $data['cancel_date_commercial_lines'] ?? '' }}" type="text" class="digitLimit mt-1 d-inline fw-600"
                                 data-limit="2"  maxlength="2" style="width:100px;margin-left:175px;" />
                                  days after the cancel date for commercial lines (in CA only).<br>Generate cancellation notice   </td>
							</tr>
							<tr>
								<td class=""><div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">STOP</td>
							</tr>
							<tr>
								<td class=" center">The account is now in 'Cancel' status.</td>
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
				     <span class="righttable font-weight-bold" style="top: 237px;"><i class="fa-2x fa-solid fa-arrow-right arrowicons"></i><br>YES</span>
					 <span class="righttable font-weight-bold" style="top: 415px;"><i class="fa-2x fa-solid fa-arrow-right arrowicons"></i><br>NO</span>
					 <table style="margin-top: 125px;" id="Cancel22" data-toggle="table" data-buttons-class="default borderless" class="table table-bordered table-hover"

						>
						<thead>
							<tr class="d-none">
								<th data-field="title"></th>
							</tr>
						</thead>
						<tbody>
						    <tr>
								<td class="center text-dark bg-light font-weight-bold">Move to 'Intent to cancel followup' status</td>
							</tr>
							<tr>
								<td class="">Generate 'Intent to cancel followup' notice </td>
							</tr>
							<tr>
								<td class="center "><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">STOP</td>
							</tr>
							<tr>
								<td class="">The account is now in 'Intent to cancel followup' status. </td>
							</tr>
							<tr>
								<td class="p-4" style="border-left-color: white;border-right-color: white;"></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">STOP</td>
							</tr>
							<tr>
								<td class="">The account remains in intent to cancel or intent to cancel followup status. </td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

