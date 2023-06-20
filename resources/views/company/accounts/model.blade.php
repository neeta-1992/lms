  <div class="remodal" data-remodal-id="overrideDueDate"
      data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
      <button class="remodal-close" data-remodal-action="close"></button>
      <h4 class="modelTitle">Override Due Date</h4>
      <br>

      <x-form class="validation text-left" action="" method="post">

          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="requiredAsterisk form-label labelText">@lang('labels.payment_due_date')</label>
                      <x-jet-input class="singleDatePicker" readonly required data-current-date="true"
                          name="payment_due_date" />
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="requiredAsterisk form-label labelText">@lang('labels.notes')</label>
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




  <div class="paymentReModel text-left" data-remodal-id="modal"
      data-remodal-options="hashTracking: false, closeOnOutsideClick: false">


      <form action=""></form>



      <div class="">
          <div class="text-center">
              <h4 class="modelTitle mb-4">@lang('labels.edit_payment_information')</h4>
          </div>

          <div class="row form-group">
              <label for="payment_method" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.payment_type')</label>
              <div class="col-sm-9">
                  <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                      <input id="payment_method_coupons" name="payment_method" checked type="radio" required
                          class="form-check-input" value="coupons">
                      <label for="payment_method_coupons" class="form-check-label">@lang('labels.coupons')</label>
                  </div>


                  <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                      <input id="payment_method_ach" name="payment_method" type="radio" required
                          class="form-check-input" value="ach">
                      <label for="payment_method_ach" class="form-check-label">@lang('labels.ach')</label>
                  </div>

                  <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                      <input id="payment_method_credit_card" name="payment_method" type="radio" required
                          class="form-check-input" value="credit_card">
                      <label for="payment_method_credit_card" class="form-check-label">@lang('labels.credit_card')</label>
                  </div>

              </div>
          </div>

          <x-form methode="put">

              <div class="paymenttab d-none" data-tab="coupons">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.name')</label>
                              <x-jet-input type="text" name="account_name" class="required" />
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="required form-label requiredAsterisk labelText">@lang('labels.address')</label>
                              <x-jet-input type="text" name="mailing_address" class="required"
                                  value="{{ $data['mailing_address'] ?? '' }}" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">@lang('labels.city')</label>
                              <x-jet-input type="text" name="mailing_city" placeholder="City" class="required"
                                  value="{{ $data['mailing_city'] ?? '' }}" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">@lang('labels.state')</label>
                              <x-select :options="stateDropDown(['keyType' => 'state'])" class="ui dropdown required" placeholder="Select option"
                                  name="mailing_state" selected="{{ $data['mailing_state'] ?? '' }}" />

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">@lang('labels.zip')</label>
                              <x-jet-input type="text" name="mailing_zip" class="zip_mask" placeholder="Zip"
                                  class="required" value="{{ $data['mailing_zip'] ?? '' }}" />

                          </div>
                      </div>
                  </div>
                  <div class="text-center col-md-12">
                      <button class="button-loading btn btn-sm btn-primary saveData" type="button">Save</button>
                      <button data-remodal-action="confirm"
                          class="btn btn-sm btn-secondary payModelsCancel">Cancel</button>
                  </div>
              </div>

          </x-form>
          <x-form methode="put" class="">

              <div class="paymenttab d-none" data-tab="ach">

                  <div class="row">
                      <div class='col-md-12 p-0'>
                          <label class="requiredAsterisk form-label labelText col-md-3">@lang('lables.account_type')</label>
                          <x-input-radio name="payment_method_account_type" class="required" inline
                              id="payment_method_account_type_1" value="Business checking"
                              label="Business checking" />
                          <x-input-radio name="payment_method_account_type" class="required" inline
                              id="payment_method_account_type_2" value="Personal checking"
                              label="Personal checking" />
                          <x-input-radio name="payment_method_account_type" class="required" inline
                              id="payment_method_account_type_3" value="Saving account" label="Saving account" />
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.account_name')</label>
                              <x-jet-input type="text" name="account_name" class="required" value="" />
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.first_name')</label>
                              <x-jet-input type="text" name="mailing_firstname" class="required"
                                  value="" />
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
                              <x-jet-input type="tel" name="mailing_telephone" class="required"
                                  value="" />
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.email')</label>
                              <x-jet-input type="email" name="mailing_email" class="required" value="" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('lables.account_type')</label>
                              <x-select :options="[
                                  '' => 'Selct Account Type',
                                  'Business checking' => 'Business checking',
                                  'Personal checking' => 'Personal checking',
                                  'Saving account' => 'Saving account',
                              ]" class="ui dropdown required"
                                  name="payment_method_account_type" selected="" />

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.bank_routing_number')</label>
                              <x-jet-input type="text" name="bank_routing_number" class="required"
                                  value="" />

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.bank_account_number')</label>
                              <x-jet-input type="text" name="bank_account_number" class="required"
                                  value="" />
                          </div>
                      </div>
                      @if (!empty($paymentSetting['recurring_ach_payment']))
                          <div class="col-sm-12">
                              <div class="form-group">
                                  @php
                                      $recurring_ach_payment = Str::replace('{FinanceCompany}', 'Hos7', $paymentSetting['recurring_ach_payment']);
                                  @endphp
                                  <x-jet-checkbox value='Disclosure' name='disclosure'
                                      labelText='{!! $recurring_ach_payment !!}' id="disclosure" for="disclosure" />

                              </div>
                          </div>
                      @endif
                  </div>

                  <div class="text-center"><img src="{{ asset('assets/images/Check75.png') }}"></div>

                  <div class="text-center">


                      <button class="button-loading btn btn-sm btn-primary saveData" type="button">Save</button>

                      <button data-remodal-action="confirm"
                          class="btn btn-sm btn-secondary payModelsCancel">Cancel</button>
                  </div>
              </div>

          </x-form>
          <x-form methode="put">

              <div class="paymenttab d-none" data-tab="credit_card">
                  <div class="text-center">
                      <h4 class="modelTitle mb-4 ">@lang('labels.credit_card_information')</h4>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
<<<<<<< Updated upstream
                              <label class="requiredAsterisk form-label labelText">Cardholder Name(Full
                                  Name)</label>
                              <x-jet-input type="text" name="card_holder_name" class="required" value="{{ $data['card_holder_name'] ?? '' }}" />
=======
                              <label class="requiredAsterisk form-label labelText">@lang('labels.cardholder_name_full_name')</label>

                              <x-jet-input type="text" name="card_holder_name" class="required"
                                  value="{{ $data['card_holder_name'] ?? '' }}" />
>>>>>>> Stashed changes
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="required form-label requiredAsterisk labelText">@lang('labels.billing_address')</label>
                              <x-jet-input type="text" name="mailing_address" class="required"
                                  value="{{ $data['mailing_address'] ?? '' }}" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">@lang('labels.billing_address_city')</label>
                              <x-jet-input type="text" name="mailing_city" placeholder="City" class="required"
                                  value="{{ $data['mailing_city'] ?? '' }}" />
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">@lang('labels.billing_address_state')</label>
                              <x-select :options="stateDropDown(['keyType' => 'state'])" class="ui dropdown required" placeholder="Select option"
                                  name="mailing_state" selected="{{ $data['mailing_state'] ?? '' }}" />

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <label class="d-none requiredAsterisk labelText">@lang('labels.billing_address_zip')</label>
                              <x-jet-input type="text" name="mailing_zip" class="zip_mask" placeholder="Zip"
                                  class="required" value="{{ $data['mailing_zip'] ?? '' }}" />

                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.cardholder_email_address')</label>
                              <x-jet-input type="email" name="email" class="required"
                                  value="{{ $data['email'] ?? '' }}" />

                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-5">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.card_number')</label>

                              <x-jet-input type="text" name="card_number" class="digitLimit cardNumber required"
                                  maxlenght="18" data-limit="18" value="{{ $data['card_number'] ?? '' }}" />

                          </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                              <label class="requiredAsterisk form-label labelText">@lang('labels.expiration_date')</label>
                              <div class="row">
                                  @php
                                      $yearOption = [];
                                  @endphp
                                  @for ($year = date('Y') - 5; $year <= date('Y') + 10; $year++)
                                      @php
                                          $yearOption[$year] = $year;
                                      @endphp
                                  @endfor
                                  <div class="col-sm-6">
                                      <x-select :options="monthsDropDown('shortname')" name="month" class="ui dropdown w-25"
                                          placeholder="Months" required selected="{{ $data['month'] ?? '' }}" />
                                  </div>
                                  <div class="col-sm-6">
                                      <x-select :options="$yearOption" name="year" class="ui dropdown  w-25"
                                          placeholder="Year" required selected="{{ $data['year'] ?? '' }}" />
                                  </div>


                              </div>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label class="required form-label labelText">@lang('labels.cvv')</label>
                              <x-jet-input type="text" name="cvv" class="digitLimit required cardCVV"
                                  data-limit="4" maxlenght="4" value="{{ $data['cvv'] ?? '' }}" />
                          </div>
                      </div>
                  </div>
                  @if (!empty($paymentSetting['recurring_credit_card_payment']))
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  @php
                                      $recurring_credit_card_payment = Str::replace('{FinanceCompany}', 'Hos7', $paymentSetting['recurring_credit_card_payment']);
                                  @endphp
                                  <x-jet-checkbox value='Disclosure' name='disclosure'
                                      labelText='{!! $recurring_credit_card_payment !!}' />
                              </div>
                          </div>
                      </div>
                  @endif

                  <div class="text-center">


                      <button class="button-loading btn btn-sm btn-primary saveData" type="button">Save</button>

                      <button data-remodal-action="confirm"
                          class="btn btn-sm btn-secondary payModelsCancel">Cancel</button>
                  </div>
              </div>

          </x-form>
      </div>





  </div>
