<x-app-layout :class="['dateDropdown']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck('company.dashboard')]]]" class="validationForm findForm " :title="$pageTitle" novalidate method="post" x-data="findData" x-on:submit.prevent="findForm($formData)" method="post">
        @slot('form')
        <div class="form-group row">
            <label for="quote_id" class="col-sm-3 col-form-label ">@lang("labels.Account")</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="accountId" maxlength="100" />
            </div>
        </div>
        <div class="row form-group">
            <label for="open_status" class="col-sm-3 col-form-label requiredAsterisk">
                @lang("labels.account_status")</label>
            <div class="col-sm-9">
                <x-jet-checkbox for="All" class="changesetup setup_fees" name="status[]" id="All" value="All" labelText="All" checked />
                <x-jet-checkbox for="Current" class="changesetup setup_fees" name="status[]" id="Current" value="Current" labelText="Current" checked />
                <x-jet-checkbox for="Intent to Cancel" class="changesetup setup_fees" name="status[]" id="Intent to Cancel" value="Intent to Cancel" labelText="Intent to Cancel" checked />
                <x-jet-checkbox for="Suspended" class="changesetup setup_fees" name="status[]" id="Suspended" value="Suspended" labelText="Suspended" checked />
                <x-jet-checkbox for="Canceled" class="changesetup setup_fees" name="status[]" id="Canceled" value="Canceled" labelText="Canceled" checked />
                <x-jet-checkbox for="Cancel 1" class="changesetup setup_fees" name="status[]" id="Cancel_1" value="Cancel 1" labelText="Cancel 1" checked />
                <x-jet-checkbox for="Cancel 2" class="changesetup setup_fees" name="status[]" id="Cancel_2" value="Cancel 2" labelText="Cancel 2" checked />
                <x-jet-checkbox for="Flat Canceled" class="changesetup setup_fees" name="status[]" id="Flat_Canceled" value="Flat Canceled" labelText="Flat Canceled" checked />
                <x-jet-checkbox for="Collection" class="changesetup setup_fees" name="status[]" id="Collection" value="Collection" labelText="Collection" checked />
                <x-jet-checkbox for="Closed" class="changesetup setup_fees" name="status[]" id="Closed" value="Closed" labelText="Closed" checked />


            </div>
        </div>
        <div class="form-group row">
            <label for="policy_number" class="col-sm-3 col-form-label">@lang("labels.policy")</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="policy_number" />

            </div>
        </div>
         <div class="form-group row">
            <label for="coverage_type" class="col-sm-3 col-form-label ">@lang('labels.coverage_type')</label>
            <div class="col-sm-9">
                <x-select :options="coverageTypeDropDown()" placeholder="Select" name="coverage_type" class="ui dropdown w-100" />
            </div>
        </div>
         <div class="form-group row">
            <label for="insured_name" class="col-sm-3 col-form-label">@lang('labels.insured_name')</label>
            <div class="col-sm-9">
                <x-semantic-dropdown placeholder="Search Insured" class="insuredList">
                    <input type="hidden" name="insured">
                </x-semantic-dropdown>
            </div>
        </div>
         <div class="row form-group">
            <label for="general_agent" class="col-sm-3 col-form-label">@lang('labels.general_agent')</label>
            <div class="col-sm-9">
                <x-semantic-dropdown placeholder="Search General Agent" class="general_agentDropdown">
                    <input type="hidden" name="general_agent">
                </x-semantic-dropdown>
            </div>
        </div>
        <div class="row form-group">
            <label for="insurance_companyDropdown" class="col-sm-3 col-form-label ">@lang('labels.insurance_company')</label>
            <div class="col-sm-9">
                <x-semantic-dropdown placeholder="Search Insurance Company" class="insurance_companyDropdown">
                    <input type="hidden" name="insurance_company">
                </x-semantic-dropdown>
            </div>
        </div>


        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">@lang("labels.insured_email")</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <x-jet-input type="email" name="email" />
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <label for="telephone" class="col-sm-5 col-form-label">@lang("labels.insured_telephone")</label>
                            <div class="col-sm-7">
                                <x-jet-input type="tel" name="telephone" class="telephone" />

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <label for="primary_address" class="col-sm-3 col-form-label">@lang("labels.address")</label>
            <div class="col-sm-9">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-jet-input type="text" name="address" />


                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-jet-input type="text" name="city" placeholder="City" />

                    </div>
                    <div class="col-md-4">
                        {!! form_dropdown('primary_address_state', stateDropDown(), '', [
                        'class' => "ui dropdown input-sm
                        w-100",
                       
                        'id' => 'primary_address_state',
                        ]) !!}


                    </div>
                    <div class="col-md-4">
                        <x-jet-input type="text" name="zip" class="zip_mask" placeholder="Zip" />

                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">@lang("labels.installment_amount")</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <x-jet-input type="text" name="installment_amount" class="amount" placeholder="$" />

                    </div>
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <label for="telephone" class="col-sm-5 col-form-label">@lang("labels.payment_due_date")</label>
                            <div class="col-sm-7">
                                 <x-jet-input type="hidden" name="payment_due_date" class="dataDropDown" />
                            
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">@lang("labels.last_payment_amount")</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <x-jet-input type="text" name="last_payment_amount" class="amount" placeholder="$" />
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <label for="telephone" class="col-sm-5 col-form-label">@lang("labels.last_payment_date")</label>
                            <div class="col-sm-7">
                                 <x-jet-input type="hidden" name="last_payment_date" class="dataDropDown" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">@lang("labels.payment_method")</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <x-select :options='accountPaymentMethod()' class='ui dropdown' name='payment_method'/>
                       
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <label for="telephone" class="col-sm-5 col-form-label">@lang("labels.paid_by")</label>
                            <div class="col-sm-7">
                                <input type="tel" class="form-control input-sm " name="" id="" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>



         <div class="form-group row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <button type="submit" class=" button-loading btn btn-primary saveCaoverageType">
                    <span class="button--loading d-none"></span> <span class="button__text">Find</span>
                </button>
            </div>
        </div>
        @endslot
         @slot('otherTab')
        <div x-show="open == 'findTable'">
            <x-table id="{{ $activePage }}-find" ajaxUrl="{{ routeCheck($route . 'index') }}">
                <thead>
                    <tr>
                          <th class="align-middle" data-sortable="false" data-field="account_number">@lang('labels.account') #
                        </th>
                        <th class="align-middle" data-sortable="true" data-field="insured">@lang('labels.insured') @lang('labels.name')</th>
                        <th class="align-middle" data-sortable="true" data-field="agency">@lang('labels.agency') @lang('labels.name')</th>
                        <th class="align-middle" data-sortable="false"  data-field="status">@lang('labels.status')</th>
                        <th class="align-middle" data-sortable="false"  data-field="balance_due">@lang('labels.balance_due')</th>
                        <th class="align-middle" data-sortable="false"  data-field="payment_amount">@lang('labels.installment_amount')</th>
                        <th class="align-middle" data-sortable="false"  data-field="next_due_date">@lang('labels.next_due_date')</th>
                        <th class="align-middle" data-sortable="false"  data-field="installment">@lang('labels.installment')</th>

                    </tr>
                </thead>
            </x-table>
        </div>
        @endslot
    </x-jet-form-section>
 @push('page_script')
    <script>
        let formInfo = {};
        document.addEventListener('alpine:init', () => {
            Alpine.data('findData', () => ({
                init() {
                    remotelyDropDown('.insurance_companyDropdown', 'common/entity/insurance_company');
                    remotelyDropDown('.general_agentDropdown', 'common/entity/general_agent');
                    remotelyDropDown('.insuredList', 'common/entity/insured');
                }
                ,findForm(formData) {
                   
                    let fillerObj = objClean(formData);

                    let isValid = isValidation($('.findForm'), (notClass = true));
                    let args    = serializeFilter($('.findForm'), (filter = true));
                    if (isValid) {
                        this.open = 'findTable';
                        formInfo = formData;
                        $('#{{ $activePage ?? '' }}-find').bootstrapTable("refresh",{
                            url: "{{ routeCheck($route . 'index') }}?" + $.param(args),
                        });
                      

                    }
                }
            }))
        })




        $(document.body).on('change', 'input[name="status[]"]', function() {
            statuses = []
            $('.find_quote_form').find('input[name="status[]"]:checked').each(function() {
                statuses.push($(this).val());
            });
            if (statuses.includes('all') && $(this).val() == 'all') {
                $('.find_quote_form').find('input[name="status[]"]').prop('checked', true);
            } else if ($(this).val() == 'all') {
                $('.find_quote_form').find('input[name="status[]"]').prop('checked', false);
            } else {
                $('.find_quote_form').find('input[name="status[]"][value="all"]').prop('checked', false);
            }
        });

    </script>
    @endpush
</x-app-layout>
