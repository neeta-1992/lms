<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs','other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm fullLableText hasAlpine" novalidate action="{{ routeCheck($route . 'update', $id) }}"
        method="post"  x-data="{ruleTable:'table',ruleEditUrl:null,tableShow:'',agencySelect:true}"
        x-effect="async () => {
            switch (ruleTable) {
                case 'table':
                    tableShow = 'table';
                    $('#down-payment-rules-fee-table').bootstrapTable('refresh')
                    $('.ruleForm').html('');
                    break;
                 case 'ruleForm':
                    const tableLength = $('#down-payment-rules-fee-table').bootstrapTable('getData').length;
                    tableShow =  tableLength > 0 ? 'table' : '';
                    const ruleUrl = ruleEditUrl ?? '{{ routeCheck($route . 'form') }}';
                    let result = await doAjax(ruleUrl, method='post');
                    $('.ruleForm').html(result);
                    $('.ui.dropdown').dropdown();
                    amount();  telephoneMaskInput();
                    break;
                default:
                    break;
            }

            agencySelect = '{{ $data['agency'] == 'all' }}' ? true : false;

        }">
        @slot('form')
            @method('put')
        <input type="hidden" name="logsArr">

               <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.rule_name')</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="name" id="name" required placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label">@lang('labels.description')</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" cols="30" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.enable")</label>
                <div class="col-sm-9">
                    <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                        <input id="status_yes" name="status" type="radio" required class="form-check-input"
                            value="1">
                        <label for="status_yes" class="form-check-label">Yes</label>
                    </div>
                    <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                        <input id="status_no" name="status" type="radio" required class="form-check-input"
                            value="0">
                        <label for="status_no" class="form-check-label">No</label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label ">@lang('labels.round_down_payment_to_nearest_dollar')</label>
                <div class="col-sm-9">
                     <x-jet-checkbox for="round_down_payment" name="round_down_payment" id="round_down_payment"
                            value="yes" />
                </div>
            </div>
            <div class="row form-group">


                        <label for="minimum_down_payment_policies"
                            class="col-sm-3 col-form-label">@lang('labels.minimum_down_payment_for_all_policies')</label>



                        <div class="col-sm-9">
                            <x-jet-input type="text" class="amount w-25" name="minimum_down_payment_policies"
                                placeholder="$" />

                        </div>

            </div>

             <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label">@lang('labels.assign') @lang('labels.to')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-md-12">
                            <x-jet-checkbox for="check_all_agencies" class="permissionCheckBox" name="agency"
                                id="check_all_agencies" value="all" checked labelText="Check all agencies"
                                @change="($el.checked === true ? agencySelect = true : agencySelect = false)" />
                        </div>
                        <div class="col-md-12 mt-2" x-show="agencySelect == false">
                            <x-select :options="agencyType()" name="agency[]"
                                x-bind:name="(agencySelect == false ? 'agency[]' : '')" class="ui dropdown"
                                placeholder="Select Option" multiple />
                        </div>
                    </div>
                </div>
            </div>

            <hr>

        <div class="form-group row">
            <label for="description" class="col-sm-3 col-form-label">@lang("labels.number_of_installments")</label>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                    <label for="quote_id"
                        class="col-sm-6 col-form-label requiredAsterisk">@lang("labels.monthly")</label>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-md-4">
                <div class="form-group row">
                    <label for="monthly_minimum_installment"
                        class="col-sm-7 col-form-label">@lang("labels.minimum_of_installments")</label>
                    <div class="col-sm-5">
                           <x-jet-input type="text" class="digitLimit" maxlength="2" name="monthly_minimum_installment" required />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="monthly_deafult_installment"
                        class="col-sm-7 col-form-label">@lang("labels.default_of_installments")</label>
                    <div class="col-sm-5">
                        <x-jet-input type="text" class="digitLimit" maxlength="2" name="monthly_deafult_installment" required />

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="monthly_maximum_installment"
                        class="col-sm-7 col-form-label">@lang("labels.maximum_of_installments")</label>
                    <div class="col-sm-5">
                        <x-jet-input type="text" class="digitLimit" maxlength="2" name="monthly_maximum_installment" required />
                    </div>
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                    <label for="quote_id"
                        class="col-sm-6 col-form-label requiredAsterisk">@lang("labels.quarterly")</label>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-md-4">
                <div class="form-group row">
                    <label for="quarterly_minimum_installment"
                        class="col-sm-7 col-form-label">@lang("labels.minimum_of_installments")</label>
                    <div class="col-sm-5">
                         <x-jet-input type="text" class="digitLimit" maxlength="2" name="quarterly_minimum_installment" required />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="quarterly_deafult_installment"
                        class="col-sm-7 col-form-label">@lang("labels.default_of_installments")</label>
                    <div class="col-sm-5">
                       <x-jet-input type="text" class="digitLimit" maxlength="2" name="quarterly_deafult_installment" required />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="quarterly_maximum_installment"
                        class="col-sm-7 col-form-label">@lang("labels.maximum_of_installments")</label>
                    <div class="col-sm-5">
                         <x-jet-input type="text" class="digitLimit" maxlength="2" name="quarterly_maximum_installment" required />
                    </div>
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                    <label for="quote_id"
                        class="col-sm-6 col-form-label requiredAsterisk">@lang("labels.annually")</label>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-md-4">
                <div class="form-group row">
                    <label for="annually_minimum_installment"
                        class="col-sm-7 col-form-label">@lang("labels.minimum_of_installments")</label>
                    <div class="col-sm-5">
                         <x-jet-input type="text" class="digitLimit" maxlength="2" name="annually_minimum_installment" required />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="annually_deafult_installment"
                        class="col-sm-7 col-form-label">@lang("labels.default_of_installments")</label>
                    <div class="col-sm-5">
                            <x-jet-input type="text" class="digitLimit" maxlength="2" name="annually_deafult_installment" required />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="annually_maximum_installment"
                        class="col-sm-7 col-form-label">@lang("labels.maximum_of_installments")</label>
                    <div class="col-sm-5">
                           <x-jet-input type="text" class="digitLimit" maxlength="2" name="annually_maximum_installment" required />
                    </div>
                </div>
            </div>
		</div>
		<hr>
       

        <div style="position: relative" class="down_payment_table mt-5" x-show="tableShow == 'table'">
                <x-bootstrap-without-pagination-table :data="[
                    'id'  => 'down-payment-rules-fee-table',
                    'cookieid'  => true,
                    'sortorder' => 'desc',
                    'sortname'  => 'created_at',
                    'type'      => 'serverside',
                    'ajaxUrl'   => routeCheck($route.'list',['id'=>$id]),
                ]">
                    <thead>
                        <tr>
                            <th class="align-middle"   data-width="10" data-formatter="CheckBoxFormat"></th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">@lang("labels.created_date")</th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">@lang("labels.last_update_date ")</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="rule_name">@lang("labels.rule_set_name")</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="rule_description">@lang("labels.description")</th>

                        </tr>
                    </thead>
                </x-bootstrap-without-pagination-table>
        </div>

        <div x-show="ruleTable == 'ruleForm'" class="ruleForm">

        </div>

        <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>

        @endslot

        @slot('logContent')
            <x-bootstrap-table :data="[
                'table' => 'logs',
                'cookieid' => true,
                'sortorder' => 'desc',
                'sortname' => 'created_at',
                'type' => 'serversides',

                'ajaxUrl' => routeCheck('company.logs', ['type' => activePageName(), 'id' => $id]),
            ]">
                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">
                            User Name
                        </th>
                        <th class="" data-sortable="true" data-field="message">Description</th>
                    </tr>
                </thead>
            </x-bootstrap-table>
        @endslot
    </x-jet-form-section>
    @push('page_script')
        <script>
            let editArr = @json($data ?? []);
        </script>
    @endpush
</x-app-layout>
