  <div class="row">
      <div class="col-lg-12">
          <div class="table-responsive">
              <table class="table table_left_padding_0">
                  <thead class="">
                      <tr>
                          <th>Notice Type</th>
                          <th>Frequency</th>
                          <th>Cancel Days</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td> Unearned Premium Statement</td>
                          <td>
                              <x-jet-checkbox for="changesetup_1" labelText='MON' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_1" value="true" />
                              <x-jet-checkbox for="changesetup_2" labelText='TUS' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_2" value="true" />

                              <x-jet-checkbox for="changesetup_3" labelText='WED' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_3" value="true" />

                              <x-jet-checkbox for="changesetup_4" labelText='THU' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_4" value="true" />

                              <x-jet-checkbox for="changesetup_5" labelText='FRI' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_5" value="true" />

                              <x-jet-checkbox for="changesetup_6" labelText='SAT' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_6" value="true" />
                              <x-jet-checkbox for="changesetup_7" labelText='SUN' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_7" value="true" />
                          </td>
                          <td>Days Until Cancel</td>

                      </tr>
                      <tr>
                          <td>Notice Of Cancelled Account</td>
                          <td>
                              <x-jet-checkbox for="changesetup_1" labelText='MON' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_1" value="true" />
                              <x-jet-checkbox for="changesetup_2" labelText='TUS' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_2" value="true" />

                              <x-jet-checkbox for="changesetup_3" labelText='WED' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_3" value="true" />

                              <x-jet-checkbox for="changesetup_4" labelText='THU' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_4" value="true" />

                              <x-jet-checkbox for="changesetup_5" labelText='FRI' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_5" value="true" />

                              <x-jet-checkbox for="changesetup_6" labelText='SAT' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_6" value="true" />
                              <x-jet-checkbox for="changesetup_7" labelText='SUN' class="changesetup setup_fees"
                                  name="rateTable[setup_fee][]" id="changesetup_7" value="true" />
                          </td>
                          <td>Days Until Cancel</td>

                      </tr>

                  </tbody>
              </table>
          </div>
      </div>
  </div>


  <div class="row">
      <div class="col-lg-12">
          <div class="table-responsive">
              <table class="table">
                  <thead>
                      <tr>
                          <th>Description</th>
                          <th>Mail</th>
                          <th>Fax</th>
                          <th>Email</th>
                          <th>Do Not Send</th>
                          <th>Send To(Leave Blank For Default)</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>ACH COVER Letter</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Agent Notice Of Cancelled Accounts</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>AP COVER Letter</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>AP Memorandum</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Cancel 1 Letter</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Cancellation Follow Up Letter</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Cancellation Notice</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Credit Card Payment Cover Letter</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Flat Cancellation</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Intent To Cancel </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Late Fees Dues</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Ledger Balance Statement</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Level 1 Without Cancellation Statement</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Manual Account Refund</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Notice Of Financed Premium</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Paid In Full</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Partial Payment(Advance Due Date)</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Partial Payment(Don't Advance Due Date)</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Payment Coupon Cover Letter</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Payment Received After Cancellation</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Payoff Balance</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Pending Cancellation Notice</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Refund For Overpaid Account</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Reinstatement Request</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Remittance To Comapany Ach</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Remittance To Comapany Ach Details</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Remittance To Comapany Check Per Account</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Remittance To Comapany Check Per Policy</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Remittance To Comapany Check Per Statement</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Remittance To Comapany Check Per Statement Details</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Remittance To Comapany Notification</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Returned Check</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Rp Cover Letter</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Short Down Payment</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Statement Billing Cover Letter</td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                      <tr>
                          <td>Unearned Premium Statement </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                               <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">
                        </div>
                          </td>
                          <td>
                              <input type="text" class="form-control input-sm" name="name" id="name"
                                  required placeholder="">
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
