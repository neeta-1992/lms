<x-app-layout :class="['dateDropdown']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck('company.dashboard')]]]" class="validationForm find_quote_form " :title="$pageTitle" novalidate method="post" x-data="findData" x-on:submit.prevent="findForm($formData)">
        @slot('form')
        <div class="form-group row">
            <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.quote')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" class="quoteId" name="quoteId" />
            </div>
        </div>
        <div class="row form-group">
            <label for="open_status" class="col-sm-3 col-form-label requiredAsterisk">
                @lang('labels.quote_status')</label>
            <div class="col-sm-9">
                <x-jet-checkbox name="status[]" value="all" id="allStatus" labelText="{{ __('labels.all') }}" required checked />
                <x-jet-checkbox name="status[]" value="open_tab" id="allopen" labelText="{{ __('labels.open') }}" required checked />
                <x-jet-checkbox name="status[]" value="draft_quote" id="alldraft" labelText="{{ __('labels.draft') }}" required checked />
                <x-jet-checkbox name="status[]" value="request_for_activation" id="all_activation_review" required labelText="{{ __('labels.all_activation_review') }}" checked />
                <x-jet-checkbox name="status[]" value="locked_tab" id="locked" labelText="{{ __('labels.locked') }}" required checked />
                <x-jet-checkbox name="status[]" value="delete_quote" id="deleted" labelText="{{ __('labels.deleted') }}" required checked />
            </div>
        </div>
        <div class="form-group row">
            <label for="policy_number" class="col-sm-3 col-form-label">@lang('labels.policy')</label>
            <div class="col-sm-9">
                <input type="text" name="policy_number" class="form-control input-sm policy_number" id="policy_number" />
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
        <div class="form-group row">
            <label for="coverage_type" class="col-sm-3 col-form-label ">@lang('labels.coverage_type')</label>
            <div class="col-sm-9">
                <x-select :options="coverageTypeDropDown()" placeholder="Select" name="coverage_type" class="ui dropdown w-100" />
            </div>
        </div>
        <div class="row form-group">
            <label for="commercial_status" class="col-sm-3 col-form-label">@lang('labels.line_of_business')</label>
            <div class="col-sm-9">
                <x-jet-checkbox name="account_type[]" value="commercial" id="commercial_status" labelText="{{ __('labels.commercial') }}" class="deleteCheckBoxFee" />
                <x-jet-checkbox name="account_type[]" value="personal" id="personal_status" labelText="{{ __('labels.personal') }}"  class="deleteCheckBoxFee" />


            </div>
        </div>

        <div class="row form-group">
            <label for="new_quote_type" class="col-sm-3 col-form-label">@lang('labels.quote_type')</label>
            <div class="col-sm-9">
                <x-jet-checkbox name="quote_type[]" value="new" id="new_quote_type" labelText="{{ __('labels.new') }}"  class="deleteCheckBoxFee" />
                <x-jet-checkbox name="quote_type[]" value="renewal" id="renewal_quote_type" labelText="{{ __('labels.renewal') }}"  class="deleteCheckBoxFee" />



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
            <label for="email" class="col-sm-3 col-form-label">@lang('labels.email')</label>
            <div class="col-sm-9">
                <input type="email" class="form-control input-sm email" name="email" id="email" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="telephone" class="col-sm-3 col-form-label">@lang('labels.telephone')</label>
            <div class="col-sm-9">
                <input type="tel" class="form-control input-sm telephone" name="telephone" id="telephone" placeholder="">
            </div>
        </div>


        <div class="row">
            <label for="primary_address" class="col-sm-3 col-form-label">@lang('labels.address')</label>
            <div class="col-sm-9">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="address" id="address" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-sm" id="primary_address_city" placeholder="" name="primary_address_city">
                    </div>
                    <div class="col-md-4">
                        <x-select :options="stateDropDown()" class="ui dropdown" name="primary_address_state" id="primary_address_state" placholder=""  />
                     

                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-sm zip_mask" id="primary_address_zip" name="primary_address_zip" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="schedule" class="col-sm-3 col-form-label ">@lang('labels.date')</label>
            <div class="col-sm-9">
                <div class="row">
                  <div class="col-md-4">
                    <x-jet-input type="hidden" name="start_date" class="dataDropDown" />
                </div>
                <div class="col-md-1 text-center">
                    @lang('labels.to')
                </div>
                <div class="col-md-4">
                    <x-jet-input type="hidden" name="end_date" class="dataDropDown" />
                </div>
                <div class="col-md-1">
                    <x-link class="dataDropDownClear">Clear</x-link>
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
        <div x-show="open == 'findQuotes'">
            <x-table id="{{ $activePage }}-find" >
                <thead>
                    <tr>
                        <th class="align-middle" data-sortable="true" data-field="quoteid">@lang('labels.quote')
                            {{ '#' }} </th>
                        <th class="align-middle" data-sortable="true" data-field="created_at">@lang('labels.created_date')</th>
                        <th class="align-middle" data-sortable="true" data-field="updated_at">@lang('labels.last_modified')</th>
                        <th class="align-middle" data-sortable="true" data-field="insured">@lang('labels.insured')
                            @lang('labels.name')</th>
                        <th class="align-middle" data-sortable="true" data-field="agency">@lang('labels.agency')
                            @lang('labels.name')</th>
                        <th class="align-middle" data-sortable="true" data-field="premium">@lang('labels.premium') </th>
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
                , findForm(formData) {
                    console.log(formData)
                    let fillerObj = objClean(formData);

                    let isValid = isValidation($('.find_quote_form'), (notClass = true));
                    let args = serializeFilter($('.find_quote_form'), (filter = true));
                    if (isValid) {
                        this.open = 'findQuotes';
                        formInfo = formData;
                        $('#{{ $activePage ?? '' }}-find').bootstrapTable('destroy').bootstrapTable({
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
