<x-app-layout>
    <x-jet-form-section :activePageName="$activePage" class="validationForm" :title="$pageTitle" novalidate
        action="{{ routeCheck($route . 'new-quotes') }}" method="post">
        @slot('form')
            <div class="form-group row">
                <div class="col-sm-4">
                    <div class="row">
                        <label for="email" class="col-sm-4 col-form-label">@lang('labels.insured_name')</label>
                        <div class="col-sm-8">
                            <x-jet-input type="text" required name="insured_name" id="insured_name" />
                        </div>

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label for="email" class="col-sm-3 col-form-label">@lang('labels.agent')</label>
                        <div class="col-sm-9">
                            <x-jet-input type="text" required name="agent" id="agent_name" />
                        </div>

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label for="email" class="col-sm-5 col-form-label">@lang('labels.email_notification')</label>
                        <div class="col-sm-7">
                            {!! form_dropdown('email_notification', stateDropDown(), '', [
                                'class' => 'ui dropdown input-sm w-100',
                                'required' => true,
                                'id' => 'email_notification',
                            ]) !!}
                        </div>

                    </div>
                </div>

            </div>


            <div class="form-group row">
                <div class="col-sm-4">
                    <div class="row">
                        <label for="email" class="col-sm-4 col-form-label">@lang('labels.line_of_business')</label>
                        <div class="col-sm-8">
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="account_type" @change="domiciliary = 'yes'" name="line_of_business"
                                    type="radio" required class="form-check-input" value="yes">
                                <label for="account_type" class="form-check-label">@lang('labels.commercial')</label>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label for="email" class="col-sm-3 col-form-label">@lang('labels.quote_type')</label>
                        <div class="col-sm-9">
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="new" @change="domiciliary = 'yes'" name="quote_type" type="radio"
                                    required class="form-check-input" value="new">
                                <label for="new" class="form-check-label">@lang('labels.new')</label>
                            </div>
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="renewal" @change="domiciliary = 'yes'" name="quote_type" type="radio"
                                    required class="form-check-input" value="renewal">
                                <label for="renewal" class="form-check-label">@lang('labels.renewal')</label>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label for="email" class="col-sm-5 col-form-label">@lang('labels.rate_table')</label>
                        <div class="col-sm-7">
                            <x-jet-input type="text" required name="rate_table" id="rate_table" />
                        </div>

                    </div>
                </div>
            </div>



            <div class="form-group row">
                <div class="col-sm-6">
                    <div class="row">
                        <label for="email" class="col-sm-4 col-form-label">@lang('labels.origination_state')</label>
                        <div class="col-sm-8">
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="insured_physical" @change="domiciliary = 'yes'" name="origination_state"
                                    type="radio" required class="form-check-input" value="insured_physical">
                                <label for="insured_physical" class="form-check-label">@lang('labels.insured_physical') </label>
                            </div>
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="insured_mailing" @change="domiciliary = 'yes'" name="origination_state"
                                    type="radio" required class="form-check-input" value="insured_mailing">
                                <label for="insured_mailing" class="form-check-label">@lang('labels.insured_mailing')</label>
                            </div>
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="agent" @change="domiciliary = 'yes'" name="origination_state" type="radio"
                                    required class="form-check-input" value="agent">
                                <label for="agent" class="form-check-label">@lang('labels.agent')</label>
                            </div>

                        </div>

                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="row">
                        <label for="email" class="col-sm-4 col-form-label">@lang('labels.payment_method')</label>
                        <div class="col-sm-8">
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="coupons" @change="payment_method = 'coupons'" name="payment_method" type="radio"
                                    required class="form-check-input" value="coupons">
                                <label for="coupons" class="form-check-label">@lang('labels.coupons')</label>
                            </div>
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="ach" @change="payment_method = 'ach'" name="payment_method" type="radio"
                                    required class="form-check-input" value="ach">
                                <label for="ach" class="form-check-label">@lang('labels.ach')</label>
                            </div>
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="credit_card" @change="payment_method = 'credit_card'" name="payment_method"
                                    type="radio" required class="form-check-input" value="credit_card">
                                <label for="credit_card" class="form-check-label">@lang('labels.credit_card')</label>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.insurance_company')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            <x-jet-input type="text" required name="insurance_company" id="insurance_company_name" />
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label">@lang('labels.inception_date')</label>
                                <div class="col-sm-7">
                                    <x-jet-input type="text" required name="inception_date" id="inception_date" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.general_agent')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            <x-jet-input type="text" required name="general_agent" id="general_agent" />
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label">@lang('labels.policy_term')</label>
                                <div class="col-sm-7">
                                    {!! form_dropdown('policy_term', stateDropDown(), '', [
                                        'class' => 'ui dropdown input-sm w-100',
                                        'required' => true,
                                        'id' => 'term',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.policy_number')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            <x-jet-input type="text" required name="policy_number" id="policy_number" />
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label">@lang('labels.expiration_date')</label>
                                <div class="col-sm-7">
                                    <x-jet-input type="text" required name="expiration_date" id="expiration_date" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.coverage_type')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            {!! form_dropdown('coverage_type', stateDropDown(), '', [
                                'class' => 'ui dropdown input-sm w-100',
                                'required' => true,
                                'id' => 'coverage_type',
                            ]) !!}
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label">@lang('labels.first_installment_date')</label>
                                <div class="col-sm-7">
                                    <x-jet-input type="text" required name="first_installment_date"
                                        id="first_installment_date" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.pure_premium')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            <x-jet-input type="text" required name="pure_premium" id="pure_premium" />
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label"> @lang('labels.policy_fee')</label>
                                <div class="col-sm-7">
                                    <x-jet-input type="text" required placeholder="$0" name="policy_fee"
                                        id="policy_fee" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.minimum_earned')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            <x-jet-input type="text" required name="minimum_earned" id="minimum_earned" />
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label">@lang('labels.taxes_stamp_fees')</label>
                                <div class="col-sm-7">
                                    <x-jet-input type="text" required placeholder="$0" name="taxes_stamp_fees"
                                        id="taxes_and_stamp_fees" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.cancel_term_in_days')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            {!! form_dropdown('cancel_term_in_days', stateDropDown(), '', [
                                'class' => 'ui dropdown input-sm w-100',
                                'required' => true,
                                'id' => 'cancel_terms',
                            ]) !!}
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label"> @lang('labels.broker_fee')</label>
                                <div class="col-sm-7">
                                    <x-jet-input type="text" required placeholder="$0" name="broker_fee"
                                        id="broker_fee" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.short_rate')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="yes" @change="domiciliary = 'yes'" name="short_rate" type="radio"
                                    required class="form-check-input" value="yes">
                                <label for="yes" class="form-check-label">@lang('labels.yes')</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                <input id="no" @change="domiciliary = 'no'" name="short_rate" type="radio"
                                    required class="form-check-input" value="no">
                                <label for="no" class="form-check-label">@lang('labels.no')</label>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label"> @lang('labels.inspection_fee')</label>
                                <div class="col-sm-7">
                                    <x-jet-input type="text" required placeholder="$0" name="inspection_fee"
                                        id="inspection_fee" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">@lang('labels.auditable')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                <input id="yes2" @change="domiciliary = 'yes'" name="auditable" type="radio"
                                    required class="form-check-input" value="yes">
                                <label for="yes2" class="form-check-label">@lang('labels.yes')</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                <input id="no2" @change="domiciliary = 'no'" name="auditable" type="radio"
                                    required class="form-check-input" value="no">
                                <label for="no2" class="form-check-label">@lang('labels.no')</label>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-5 col-form-label">@lang('labels.puc_filings')</label>
                                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                    <input id="yes3" @change="domiciliary = 'yes'" name="puc_filings"
                                        type="radio" required class="form-check-input" value="yes">
                                    <label for="yes3" class="form-check-label">@lang('labels.yes')</label>
                                </div>
                                <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                    <input id="no3" @change="domiciliary = 'no'" name="puc_filings" type="radio"
                                        required class="form-check-input" value="no">
                                    <label for="no3" class="form-check-label">@lang('labels.no')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                <div class="col-sm-9">
                    <textarea name="notes" id="notes" required cols="30" class="form-control dark" rows="3"></textarea>
                </div>
            </div>


            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>


</x-app-layout>
