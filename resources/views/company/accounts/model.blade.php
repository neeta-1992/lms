  <div class="remodal" data-remodal-id="overrideDueDate" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
      <button class="remodal-close" data-remodal-action="close"></button>
      <h4 class="modelTitle">Override Due Date</h4>
      <br>

      <x-form class="validation text-left" action="" method="post">
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="requiredAsterisk form-label labelText">@lang('labels.payment_due_date')</label>
                      <x-jet-input class="singleDatePicker" readonly required data-current-date="true" name="payment_due_date" />
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="requiredAsterisk form-label labelText">Note</label>
                      <textarea class="form-control" required rows="3" name="note"></textarea>
                  </div>
              </div>

          </div>
          <div class="buttons text-center">
              <button class="btn btn-primary btn-sm saveData">@lang('Save & Continue')</button>
              <button data-remodal-action="confirm" class="btn btn-sm btn-secondary">@lang('Cancel')</button>
          </div>
      </x-form>
  </div>




  <div class="paymentReModel text-left" data-remodal-id="modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">


      <form action=""></form>



      <div class="">
          <div class="text-center">
              <h4 class="modelTitle mb-4">Edit Payment Information</h4>
          </div>

          <div class="row form-group">
              <label for="payment_method" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.payment_type')</label>
              <div class="col-sm-9">
                  <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                      <input id="payment_method_coupons" name="type" checked type="radio" required class="form-check-input" value="coupons">
                      <label for="payment_method_coupons" class="form-check-label">@lang('labels.coupons')</label>
                  </div>


                  <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                      <input id="payment_method_ach" name="type" type="radio" required class="form-check-input" value="ach">
                      <label for="payment_method_ach" class="form-check-label">@lang('labels.ach')</label>
                  </div>

                  <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                      <input id="payment_method_credit_card" name="type" type="radio" required class="form-check-input" value="credit_card">
                      <label for="payment_method_credit_card" class="form-check-label">@lang('labels.credit_card')</label>
                  </div>

              </div>
          </div>
          <div class="paymenttab d-none" data-tab="coupons">
              <x-form methode="put">
                  @method('put')
                  <div class="form-group d-none">
                      <label class="required form-label requiredAsterisk labelText">Payment Type</label>
                      <input name="payment_method" type="hidden" value="coupons">
                  </div>

                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">Name</label>
                              <x-jet-input type="text" name="account_name" class="required" />
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="required form-label requiredAsterisk labelText">Address</label>
                              <x-jet-input type="text" name="mailing_address" class="required" value="{{ $data['mailing_address'] ?? '' }}" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">City</label>
                              <x-jet-input type="text" name="mailing_city" placeholder="City" class="required" value="{{ $data['mailing_city'] ?? '' }}" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">State</label>
                              <x-select :options="stateDropDown(['keyType' => 'state'])" class="ui dropdown required" placeholder="Select option" name="mailing_state" selected="{{ $data['mailing_state'] ?? '' }}" />

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">Zip</label>
                              <x-jet-input type="text" name="mailing_zip" placeholder="Zip" class="required zip_mask" value="{{ $data['mailing_zip'] ?? '' }}" />

                          </div>
                      </div>
                  </div>
                  <div class="text-center col-md-12">
                      <button class="button-loading btn btn-sm btn-primary saveData" type="button">Save</button>
                      <button data-remodal-action="confirm" class="btn btn-sm btn-secondary payModelsCancel">Cancel</button>
                  </div>


              </x-form>
          </div>
          <div class="paymenttab d-none" data-tab="ach">
              <x-form methode="put" class="">

                  @method('put')
                  <div class="form-group d-none">
                      <label class="required form-label requiredAsterisk labelText">Payment Type</label>
                      <input name="payment_method" type="hidden" value="ach">
                  </div>

                  <div class="row">
                      <div class='col-md-12 p-0'>
                          <label class="requiredAsterisk form-label labelText col-md-3">Account Type</label>
                          <x-input-radio name="payment_method_account_type" class="required" inline id="payment_method_account_type_1" value="Business checking" label="Business checking" />
                          <x-input-radio name="payment_method_account_type" class="required" inline id="payment_method_account_type_2" value="Personal checking" label="Personal checking" />
                          <x-input-radio name="payment_method_account_type" class="required" inline id="payment_method_account_type_3" value="Saving account" label="Saving account" />
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">Account Name</label>
                              <x-jet-input type="text" name="account_name" class="required" value="" />
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.first_name')</label>
                              <x-jet-input type="text" name="mailing_firstname" class="required" value="" />
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.last_name')</label>
                              <x-jet-input type="text" name="mailing_lastname" class="required" value="" />
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.telephone')</label>
                              <x-jet-input type="tel" name="mailing_telephone" class="required" value="" />
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.email')</label>
                              <x-jet-input type="email" name="mailing_email" class="required" value="" />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="required form-label requiredAsterisk labelText">Address</label>
                                  <x-jet-input type="text" name="mailing_address" class="required" value="{{ $data['mailing_address'] ?? '' }}" />
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label class="d-none requiredAsterisk labelText">City</label>
                                  <x-jet-input type="text" name="mailing_city" placeholder="City" class="required" value="{{ $data['mailing_city'] ?? '' }}" />
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label class="d-none requiredAsterisk labelText">State</label>
                                  <x-select :options="stateDropDown(['keyType' => 'state'])" class="ui dropdown required" placeholder="Select option" name="mailing_state" selected="{{ $data['mailing_state'] ?? '' }}" />

                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label class="d-none requiredAsterisk labelText">Zip</label>
                                  <x-jet-input type="text" name="mailing_zip" placeholder="Zip" class="required zip_mask" value="{{ $data['mailing_zip'] ?? '' }}" />

                              </div>
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">Bank Name</label>
                              <x-jet-input type="text" name="bank_name" class="required" value="" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">Bank Routing Number</label>
                              <x-jet-input type="text" name="bank_routing_number" class="required" value="" />

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">Bank Account Number</label>
                              <x-jet-input type="text" name="bank_account_number" class="required" value="" />
                          </div>
                      </div>
                      @if (!empty($paymentSetting['recurring_ach_payment']))
                      <div class="col-sm-12">
                          <div class="form-group">
                              @php
                              $recurring_ach_payment = Str::replace('{FinanceCompany}', 'Hos7', $paymentSetting['recurring_ach_payment']);
                              @endphp
                              <x-jet-checkbox value='Disclosure' name='disclosure' labelText='{!! $recurring_ach_payment !!}' id="disclosure" for="disclosure" />

                          </div>
                      </div>
                      @endif
                  </div>

                  <div class="text-center"><img src="{{ asset('assets/images/Check75.png') }}"></div>

                  <div class="text-center">


                      <button class="button-loading btn btn-sm btn-primary saveData" type="button">Save</button>

                      <button data-remodal-action="confirm" class="btn btn-sm btn-secondary payModelsCancel">Cancel</button>
                  </div>


              </x-form>
          </div>
          <div class="paymenttab d-none" data-tab="credit_card">
              <x-form methode="put" class="creditCardForm">
                  @method('put')

                  <div class="form-group d-none">
                      <label class="required form-label requiredAsterisk labelText">Payment Type</label>
                      <input name="payment_method" type="hidden" value="credit_card">
                  </div>



                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">Cardholder Name(Full
                                  Name)</label>
                              <x-jet-input type="text" name="card_holder_name" class="required" value="{{ $data['card_holder_name'] ?? '' }}" />
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="required form-label requiredAsterisk labelText">Billing Address</label>
                              <x-jet-input type="text" name="mailing_address" class="required" value="{{ $data['mailing_address'] ?? '' }}" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">Billing Address City</label>
                              <x-jet-input type="text" name="mailing_city" placeholder="City" class="required" value="{{ $data['mailing_city'] ?? '' }}" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">Billing Address State</label>
                              <x-select :options="stateDropDown(['keyType' => 'state'])" class="ui dropdown required" placeholder="Select option" name="mailing_state" selected="{{ $data['mailing_state'] ?? '' }}" />

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">Billing Address Zip</label>
                              <x-jet-input type="text" name="mailing_zip" placeholder="Zip" class="required zip_mask" value="{{ $data['mailing_zip'] ?? '' }}" />

                          </div>
                      </div>
                  </div>

                  @if(!empty($EPS->payment_gateway) && $EPS->payment_gateway == 'square')
                  <div class="row">
                      <div class="col-md-12">
                          <x-jet-input name="sqtoken" type="hidden"  />
                            <div id="card-container-model" class="sqcard__payment"></div>
                      </div>
                  </div>
                  @else
                  <div class="row">
                      <div class="col-md-5">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">Card Number</label>

                              <x-jet-input type="text" name="card_number" class="digitLimit cardNumber required" maxlenght="18" data-limit="18" value="{{ $data['card_number'] ?? '' }}" />

                          </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">Expiration Date</label>
                              <div class="row">
                                  @php
                                  $yearOption = [];
                                  @endphp
                                  @for ($year = date('Y') - 5; $year <= date('Y') + 10; $year++) @php $yearOption[$year]=$year; @endphp @endfor <div class="col-sm-6">
                                      <x-select :options="monthsDropDown('shortname')" name="month" class="ui dropdown w-25" placeholder="Months" required selected="{{ $data['month'] ?? '' }}" />
                              </div>
                              <div class="col-sm-6">
                                  <x-select :options="$yearOption" name="year" class="ui dropdown  w-25" placeholder="Year" required selected="{{ $data['year'] ?? '' }}" />
                              </div>


                          </div>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label class="required form-label labelText">CVV</label>
                          <x-jet-input type="text" name="cvv" class="digitLimit required cardCVV" data-limit="4" maxlenght="4" value="{{ $data['cvv'] ?? '' }}" />
                      </div>
                  </div>
          </div>
          @endif


          <div class="text-center">


              <button class="button-loading btn btn-sm btn-primary saveData" type="button">Save</button>

              <button data-remodal-action="confirm" class="btn btn-sm btn-secondary payModelsCancel">Cancel</button>
          </div>


          </x-form>
      </div>
  </div>





  </div>




  <div class="remodal emailReceiptModel" data-remodal-id="emailReceiptModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
      <button class="remodal-close" data-remodal-action="close"></button>
      <h4 class="modelTitle">Email Receipt</h4>
      <br>

      <x-form class="validation text-left" action="{{ routeCheck($route . 'email-receipt') }}" method="post">
          <x-jet-input type="hidden" class="id" name="id" />
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <x-select :options="['insured' => 'Insured', 'agent' => 'Agent', 'other' => 'Other']" class="ui dropdown emailReceiptSendTo" name="send_to" placeholder="Send To" required />
                  </div>
              </div>
              <div class="col-md-12 d-none emailBox">
                  <div class="form-group">
                      <x-jet-input type="email" name="email" placeholder="Enter Email" />

                  </div>
              </div>

          </div>
          <div class="buttons text-center">
              <button class="btn btn-primary btn-sm saveData">@lang('Send')</button>
              <button data-remodal-action="confirm" class="btn btn-sm btn-secondary">@lang('Cancel')</button>
          </div>
      </x-form>
  </div>



  <div class="remodal" data-remodal-id="unsuspendModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
      <button class="remodal-close" data-remodal-action="close" x-on:click="open = 'account_information'"></button>
      <h4 class="modelTitle">Unsuspend</h4>


      <x-form class="validation text-left" action="{{ routeCheck($route . 'unsuspend-account', $data?->id) }}" method="post">


          <div class="form-group row">
              <label for="reason" class="col-form-label requiredAsterisk">@lang('labels.reason')</label>
              <div class="col-sm-12">
                  <textarea name="reason" id="reason" cols="30" class="form-control" rows="3" required></textarea>
              </div>
          </div>


          <div class="buttons text-center">
              <button class="btn btn-primary btn-sm saveData">@lang('Send')</button>
              <button data-remodal-action="confirm" class="btn btn-sm btn-secondary" x-on:click="open = 'account_information'">@lang('Cancel')</button>
          </div>
      </x-form>
  </div>
