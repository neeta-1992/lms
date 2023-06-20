<div class="paymentReModel text-left" data-remodal-id="modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">


    <form action=""></form>

    <form class="paymentforms validationForm {{ (!empty($data?->status) && $data?->status == 2) ? 'disabled' : '' }}" action="" method="post">
        <div class="">
            <div class="paymenttab d-none" data-tab="ach">
                <div class="text-center">
                    <h4 class="modelTitle mb-4">@lang('labels.ach_information') </h4>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.account_name') </label>
                            <x-jet-input type="text" name="account_name" class="required" value="{{ $data['account_name'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.account_type') </label>
                            <x-select :options="[
                        '' => 'Selct Account Type',
                        'Business checking' => 'Business checking',
                        'Personal checking' => 'Personal checking',
                        'Saving account' => 'Saving account',
                    ]" class="ui dropdown required" name="payment_method_account_type" selected="{{ $data['payment_method_account_type'] ?? '' }}" />

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.bank_routing_number') </label>
                            <x-jet-input type="text" name="bank_routing_number" class="required" value="{{ $data['bank_routing_number'] ?? '' }}" />

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.bank_account_number') </label>
                            <x-jet-input type="text" name="bank_account_number" class="required" value="{{ $data['bank_account_number'] ?? '' }}" />
                        </div>
                    </div>
                    @if (!empty($paymentSetting['recurring_ach_payment']))
                    <div class="col-sm-12">
                        <div class="form-group">
                            @php
                            $recurring_ach_payment = Str::replace('{FinanceCompany}', 'Hos7',
                            $paymentSetting['recurring_ach_payment']);
                            @endphp
                            <x-jet-checkbox value='Disclosure' name='disclosure' labelText='{!! $recurring_ach_payment !!}' id="disclosure" for="disclosure" />

                        </div>
                    </div>
                    @endif
                </div>

                <div class="text-center"><img src="{{ asset('assets/images/Check75.png') }}"></div>


            </div>
            <div class="paymenttab d-none" data-tab="credit_card">
                <div class="text-center">
                    <h4 class="modelTitle mb-4 ">@lang('labels.credit_card_information')</h4>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.cardholder_name_full_name')</label>
                            <x-jet-input type="text" name="card_holder_name" class="required" value="{{ $data['card_holder_name'] ?? '' }}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required form-label requiredAsterisk labelText">@lang('labels.billing_address') </label>
                            <x-jet-input type="text" name="mailing_address" class="required" value="{{ $data['mailing_address'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="d-none requiredAsterisk labelText">@lang('labels.billing_address_city')</label>
                            <x-jet-input type="text" name="mailing_city" placeholder="City" class="required" value="{{ $data['mailing_city'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="d-none requiredAsterisk labelText">@lang('labels.billing_address_state') </label>
                            <x-select :options="stateDropDown(['keyType' => 'state'])" class="ui dropdown required" placeholder="Select option" name="mailing_state" selected="{{ $data['mailing_state'] ?? '' }}" />

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="d-none requiredAsterisk labelText">@lang('labels.billing_address_zip') </label>
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask" placeholder="Zip" class="required" value="{{ $data['mailing_zip'] ?? '' }}" />

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.cardholder_email_address')</label>
                            <x-jet-input type="email" name="email" class="required" value="{{ $data['email'] ?? '' }}" />

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.card_number')</label>

                            <x-jet-input type="text" name="card_number" class="digitLimit cardNumber required" maxlenght="18" data-limit="18" value="{{ $data['card_number'] ?? '' }}" />

                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="requiredAsterisk form-label labelText">@lang('labels.expiration_date') </label>
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
                        <label class="required form-label labelText">@lang('labels.cvv') </label>
                        <x-jet-input type="text" name="cvv" class="digitLimit required cardCVV" data-limit="4" maxlenght="4" value="{{ $data['cvv'] ?? '' }}" />
                    </div>
                </div>
            </div>
            @if (!empty($paymentSetting['recurring_credit_card_payment']))
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        @php
                        $recurring_credit_card_payment = Str::replace('{FinanceCompany}', 'Hos7',
                        $paymentSetting['recurring_credit_card_payment']);
                        @endphp
                        <x-jet-checkbox value='Disclosure' name='disclosure' labelText='{!! $recurring_credit_card_payment !!}' />
                    </div>
                </div>
            </div>
            @endif
        </div>
</div>



<div class="text-center">

    @if((!empty($data?->status) && $data?->status != 2))
    <button class="button-loading btn btn-sm btn-primary paySave" type="button">Save</button>
    @endif
    <button data-remodal-action="confirm" class="btn btn-sm btn-secondary payModelsCancel">Cancel</button>
</div>
</form>
</div>



@push('page_script_code')
<script>
    let cardtypesArr = @json($paymentSetting['card_types'] ? ? []);

</script>
@endpush
