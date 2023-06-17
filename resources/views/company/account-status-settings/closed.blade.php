<div class="row" x-data="{accountDay:'{{ $data['most_recent_date_days'] ?? '' }}'}">
			<div class="col-lg-8 col-md-8 col-xs-12 js-content Account_Status_Settings_first_table">
				<div class="docs-table nothover Account_Status_Settings">
					 <table id="colsed"
					   data-toggle="table" data-buttons-class="default borderless"
                      class="table table-bordered table-hover">
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
								<td class=" center">Each account that is not closed or flat cancelled will be processed as shown below during 'Close Accounts' processing.</td>
							</tr>
							<tr>
								<td class=""><div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">Have  <span x-text="accountDay" class="most_recent_date_days"></span> days elapsed?</td>
							</tr>
							<tr>
								<td class="">Have
                                    <x-jet-input name="most_recent_date_days" type="text" class="digitLimit d-inline fw-600"
                                 data-limit="2" @input.debounce.100ms="accountDay = $event.target.value" maxlength="2"
                                 style="width:50px;" value="{{ $data['most_recent_date_days'] ?? '' }}"/> days elapsed since the most recent date (all states)<ul style="list-style-type:none;" class="mb-0">
								<li>AND is the balance due (including fee receipts and fee receivables) at or under the maximum automatic write-off of $
                                     <x-jet-input name="maximum_automatic_amount" value="{{ $data['maximum_automatic_amount'] ?? '' }}" type="text" class="amount mt-1  fw-600 d-inline" style="width:100px;"   placeholder="$" />
                                     (all states) </li> <li>AND is the account active(not suspended)?</li></ul>
								</td>
							</tr>
							<tr>
								<td class=""><div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">Move to 'Closed' status</td>
							</tr>
							<tr>
								<td class="">Reverse the unearned interest if the balance due (including fee receipts and receivables) does not exceed the unearned interest.<br>Transfer credit balance to fees if there is a credit balance (excluding fee receipts and receivables).<br>Change off the credit balance if there is a credit balance at or under the maximum charge off amount of $
                                     <x-jet-input name="unearned_interest" value="{{ $data['unearned_interest'] ?? '' }}" type="text" class="amount mt-1  fw-600 d-inline" style="width:100px;"   placeholder="$" />  (in CA only) <br>
								Generate a refund check if there is a credit balance above the maximum charge off amount of $1.00.<br>
								Write off the balance if there is a positive balance due(including fee receipts and receivables) that dose not exceed the maximum write-off amount of $1.00. </td>
							</tr>
							<tr>
								<td class=""><div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">STOP</td>
							</tr>
							<tr>
								<td class="center">The account is now in 'Closed' status. </td>
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
					 <span class="righttable font-weight-bold" style="top: 177px;"><i class="fa-2x fa-solid fa-arrow-right arrowicons"></i><br>NO</span>
					 <table style="margin-top: 110px;" id="colsed2"
					   data-toggle="table" data-buttons-class="default borderless"
                      class="table table-bordered table-hover">
						<thead>
							<tr class="d-none">
								<th data-field="title"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">STOP</td>
							</tr>
							<tr>
								<td class="">The account remains unchanged in its existing status.</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
