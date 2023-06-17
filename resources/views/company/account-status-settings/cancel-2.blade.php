  <div class="row"  x-data="{accountDay:'{{ $data['sending_cancel_days'] ?? '' }}'}">
			<div class="col-lg-8 col-md-8 col-xs-12 js-content Account_Status_Settings_first_table">
				<div class="docs-table nothover Account_Status_Settings">
					 <table id="Cancel2"
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
								<td class=" center">Each account in cancel 1 status will be processed as shown below during 'Update account status' processing.</td>
							</tr>
							<tr>
								<td class=""><div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">Is cancel 2 enabled and have more than <span class="sending_cancel_days" x-text="accountDay"></span> days of elapsed?</td>
							</tr>
							<tr>
								<td class="">Have more than <x-jet-input name="sending_cancel_days" type="text" class="digitLimit d-inline fw-600"
                                 data-limit="2" @input.debounce.100ms="accountDay = $event.target.value" maxlength="2"
                                 style="width:50px;" value="{{ $data['sending_cancel_days'] ?? '' }}"/> days elapsed since sending the cancel 1 notice (setting applies to all states; a value of 0 disables cancel 2)<ul style="list-style-type:none;" class="mb-0">
								<li>AND is there a positive balance due (including fee receipts and fee receivables) </li> <li>AND is the account active(not suspended)?</li></ul>
								</td>
							</tr>
							<tr>
								<td class=""><div class="w-100 clearfix">
								<div class="doublearrowiconstext" style=""><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div><div class="font-weight-bold"> YES</div></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">Move to 'Cancel 2' notice</td>
							</tr>
							<tr>
								<td class="">Generate 'Cancel level two' notice if the balance due (including fee receipts and fee receivables) exceeds $0.00</td>
							</tr>
							<tr>
								<td class=""><div class="arrowiconstext"><i class="fa-2x fa-solid fa-arrow-down arrowicons"></i></div></td>
							</tr>
							<tr>
								<td class="center text-dark bg-light font-weight-bold">STOP</td>
							</tr>
							<tr>
								<td class="center">The account is now in 'Cancel 2' status. </td>
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
					 <span class="righttable font-weight-bold" style="top: 150px;"><i class="fa-2x fa-solid fa-arrow-right arrowicons"></i><br>NO</span>
					 <table style="margin-top: 85px;" id="collection2"
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
								<td class="">The account remains in 'cancel 1' status.</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
