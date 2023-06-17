<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['logs','other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'update', $id) }}"
        method="post" x-data="{domiciliary:'no'}">
        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">

                        <input type="hidden" name="logsArr">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Name</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="name" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tax_id" class="col-sm-3 col-form-label ingnorTitleCase">FEIN</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="taxId" name="tax_id" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telephone" class="col-sm-3 col-form-label requiredAsterisk">
                                Telephone</label>
                            <div class="col-sm-9">
                                <x-jet-input type="tel" class="telephone" name="telephone" required
                                    placeholder="(000) 000-000" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fax" class="col-sm-3 col-form-label ">
                                Fax</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="fax" name="fax" />
                            </div>
                        </div>
                        <div class="row">
                            <label for="address" class="col-sm-3 col-form-label requiredAsterisk">Mailing
                                Address</label>
                            <div class="col-sm-9">
                                <div class="form-group row">
                                    <div class="col-md-12 mb-1">
                                        <div class="form-group">
                                            <x-jet-input type="text" name="address" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-input type="text" name="city" required />
                                    </div>
                                    <div class="col-md-4">
                                        {!! form_dropdown('state', stateDropDown(), '', [
                                            'class' => 'ui dropdown input-sm w-100',
                                            'required' => true,
                                            'id' => 'primary_address_state',
                                        ]) !!}


                                    </div>
                                    <div class="col-md-2">
                                        <x-jet-input type="text" class="zip_mask" name="zip" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group row align-items-center">
                            <label for="mailing_address_yes" class="col-sm-3 col-form-label requiredAsterisk">Additional
                                Address
                                Information?</label>
                            <div class="col-sm-9">
                                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                    <input id="mailing_address_yes" @change="domiciliary = 'yes'"
                                        name="mailing_address_radio" type="radio" required class="form-check-input"
                                        value="yes">
                                    <label for="mailing_address_yes" class="form-check-label">Yes</label>
                                </div>
                                <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                    <input id="mailing_address_no" @change="domiciliary = 'no'"
                                        name="mailing_address_radio" type="radio" required class="form-check-input"
                                        value="no">
                                    <label for="mailing_address_no" class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>-->
                        <div class="row ">
                            <label for="mailing_address" class="col-sm-3 col-form-label ">Domiciliary
                                Address</label>
                            <div class="col-sm-9 ">
                                <div class="form-group row">
                                    <div class="col-md-12 mb-1">
                                        <div class="form-group">
                                            <x-jet-input type="text" name="mailing_address" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-input type="text" name="mailing_city" />
                                    </div>
                                    <div class="col-md-4">
                                        {!! form_dropdown('mailing_state', stateDropDown(), '', [
                                            'class' => 'ui dropdown input-sm w-100',

                                            'id' => 'mailing_state',
                                        ]) !!}


                                    </div>
                                    <div class="col-md-2">
                                        <x-jet-input type="text" class="zip_mask" name="mailing_zip" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="current_aggregate_outstandings" class="col-sm-3 col-form-label">Current
                                Aggregate Outstandings</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" disabled class="amount"
                                    name="current_aggregate_outstandings" placeholder="$" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="limit_of_aggregate_outstandings" class="col-sm-3 col-form-label">Limit
                                Of
                                Aggregate Outstandings</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="amount" name="aggregate_limit"
                                    placeholder="$" />
                            </div>
                        </div>



                        {{--   <div class="form-group row">
                    <label for="website" class="col-sm-3 col-form-label ">Website</label>
                    <div class="col-sm-9">
                        <x-jet-input type="url" class="w-50" name="website" placeholder="http://www.domain.com" />

                    </div>
                </div> --}}


                        {{--  <div class="mb-3">
                    <p class="fw-600">A.M. Best</p>
                </div> --}}

                        <div class="form-group row">
                            <label for="AM_best_rating" class="col-sm-3 col-form-label ">A.M. Best
                                Rating</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="am_best[rating]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="NAIC_number" class="col-sm-3 col-form-label ">NAIC Number</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="am_best[naic_number]" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_financial_size" class="col-sm-3 col-form-label ">A.M. Best
                                Financial Size</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="am_best[financial_size]" />
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="AM_best_rating_date" class="col-sm-3 col-form-label ">A.M. Best Rating
                                Date</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class=" singleDatePicker" name="am_best[rating_date]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_number" class="col-sm-3 col-form-label ">A.M. Best
                                Number</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class=" am_best_number" name="am_best[number]" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_group_number" class="col-sm-3 col-form-label ">A.M. Best Group
                                Number</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="am_best[group_number]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_group_name" class="col-sm-3 col-form-label ">A.M. Best Group
                                Name</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="am_best[group_name]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="aggregation_code" class="col-sm-3 col-form-label ">Aggregation
                                Code</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="am_best[aggregation_code]" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_url" class="col-sm-3 col-form-label ">A.M. Best URL</label>
                            <div class="col-sm-9">
                                <x-jet-input type="url" name="am_best[url]" class="am_best_url"
                                    readonly="readonly" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-sm-3 col-form-label">Notes</label>
                            <div class="col-sm-9">
                                <textarea name="notes" id="notes" cols="30" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="row form-group align-top-radio">

                                    <div class="col-sm-12">
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                            <input id="yes" class="form-check-input" name="save_option" checked
                                                type="radio" value="save_defaults_only">
                                            <label for="yes" class="form-check-label">Save defaults only:
                                                EXISTING FINANCE
                                                COMPANIES ARE
                                                NOT AFFECTED</label>
                                        </div>
                                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                            <input id="no" class="form-check-input" name="save_option"
                                                type="radio" value="save_and_reset">
                                            <label for="no" class="form-check-label">Save and Reset
                                                existing FINANCE
                                                COMPANIES:
                                                Save the
                                                default coverage types values and apply the default coverage
                                                types
                                                values to all existing FINANCE COMPANIES for the coverage types.
                                                ALL EXISTING
                                                COVERAGE
                                                TYPES AND SPECIFIED VALUES FOR
                                                FINANCE COMPANIES WILL BE REPLACED.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                'ajaxUrl' => routeCheck('admin.logs', ['type' => activePageName(), 'id' => $id]),
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
