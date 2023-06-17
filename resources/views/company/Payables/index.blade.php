 <x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <h4>{{ dynamicPageTitle('page') ?? '' }}</h4>
                    <form class="validationForm" novalidate method="POST"
                        action="{{ Route::has($route . 'store') ? route($route . 'store') : '' }}">
                        @csrf
                        <div class="tab-one" x-show="open == 'one'">
                            <div class="form-group row">
                                <label for="personal_maximum_finance_amount"
                                    class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.inception_date")</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6"><input type="text" class="form-control input-sm "
                                                name="personal_maximum_finance_amount"
                                                id="personal_maximum_finance_amount" placeholder="From"></div>
                                        <div class="col-sm-6"><input type="text" class="form-control input-sm "
                                                name="commercial_maximum_finance_amount"
                                                id="commercial_maximum_finance_amount" placeholder="To"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="personal_maximum_finance_amount" class="col-sm-3 col-form-label">
                                    @lang("labels.due_date")</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6"><input type="text" class="form-control input-sm "
                                                name="personal_maximum_finance_amount"
                                                id="personal_maximum_finance_amount" placeholder="From"></div>
                                        <div class="col-sm-6"><input type="text" class="form-control input-sm "
                                                name="commercial_maximum_finance_amount"
                                                id="commercial_maximum_finance_amount" placeholder="To"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="max_setup_fee" class="col-sm-3 col-form-label">@lang("labels.payment_type")
                                </label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm ui dropdown " name="max_setup_fee">
                                                <option value=""></option>
                                                <option value="ACH Per Policy">ACH Per Policy</option>
                                                <option value="ACH Per Statement">ACH Per Statement</option>
												<option value="ACH Per Account">ACH Per Account</option>
												<option value="Check Per Policy">Check Per Policy</option>
												<option value="Check Per Account">Check Per Account</option>
												<option value="Check Per Statement">Check Per Statement</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="row form-group">
                                <label for="open_status" class="col-sm-3 col-form-label ">
                                    @lang("labels.payable_type")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input class="" name="status[]" type="checkbox" id="open_status"
                                            value="1">
                                        <label class=" " for="open_status">@lang("labels.compensation")</label>
                                    </div>
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input class="" name="status[]" type="checkbox" id="locked_status"
                                            value="2">
                                        <label class="" for="locked_status">@lang("labels.doc_stamp_fee")

                                        </label>
                                    </div>
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input class="" name="status[]" type="checkbox" id="draft_status"
                                            value="3">
                                        <label class="" for="draft_status">@lang("labels.policy")
                                        </label>
                                    </div>
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input class="" name="status[]" type="checkbox" id="all_activation_status"
                                            value="4">
                                        <label class="" for="all_activation_status">@lang("labels.return_premium")</label>
                                    </div>
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input class="" name="status[]" type="checkbox" id="deleted_status"
                                            value="5">
                                        <label class="" for="deleted_status">@lang("labels.setup_fee")
                                        </label>
                                    </div>
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input class="" name="status[]" type="checkbox" id="delegted_status"
                                            value="5">
                                        <label class="" for="delegted_status">@lang("labels.add_on_product")
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comp_name" class="col-sm-3 col-form-label requiredAsterisk">
                                    @lang("labels.of_payment_received")</label>
                                <div class="col-sm-9">
                                    <input type="text" name="comp_name" class="form-control input-sm w-25"
                                        id="comp_name" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-3 col-form-label ">@lang("labels.payable_to")
                                </label>
                                <div class="col-sm-9">
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
										
                                        <input id="rightfax_server_email_enable" name="payable_to[]"
                                            type="checkbox" required class="form-check-input" value="true">
                                        <label for="rightfax_server_email_enable">
                                            @lang("labels.insurance_company")</label>
                                    </div>
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input id="rightfax_server_email_disable" name="payable_to[]"
                                            type="checkbox" required class="form-check-input" value="false">
                                        <label for="rightfax_server_email_disable">
                                            @lang("labels.general_agent")</label>
                                    </div>
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input id="rightfax_server_email_disablec" name="payable_to[]"
                                            type="checkbox" required class="form-check-input" value="false">
                                        <label for="rightfax_server_email_disablec">@lang("labels.agent")

                                        </label>
                                    </div>
                                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                                        <input id="rightfax_server_email_disabled" name="payable_to[]"
                                            type="checkbox" required class="form-check-input" value="false">
                                        <label for="rightfax_server_email_disabled"
                                            >@lang("labels.insured")</label>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="personal_maximum_finance_amount"
                                    class="col-sm-3 col-form-label ">@lang("labels.state")</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="checkbox" class=" input-sm "
                                                name="personal_maximum_finance_amount"
                                                id="personal_maximum_finance_amount" placeholder="From">
                                            <span class="custom-control-label align-baseline">All</span>
                                        </div>
                                        <div class="col-sm-6">
											<x-select :options="stateDropDown(['keyType' => 'state'])"
                            class="ui dropdown required" placeholder="Select State" name="mailing_state" />
                                         </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="button" class=" button-loading btn btn-primary saveCaoverageType">
                                        <span class="button--loading d-none"></span> <span
                                            class="button__text">Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
