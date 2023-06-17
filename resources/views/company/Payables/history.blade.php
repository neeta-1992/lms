<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <h4>Payable History</h4>
                    <form class="validationForm" novalidate method="POST"
                        action="{{ Route::has($route . 'store') ? route($route . 'store') : '' }}">
                        @csrf
                        <div class="tab-one" x-show="open == 'one'">
                            <div class="form-group row">
                                <label for="personal_maximum_finance_amount"
                                    class="col-sm-3 col-form-label ">@lang("labels.from_date_to_date")</label>
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
                                <label for="max_setup_fee" class="col-sm-3 col-form-label ">@lang("labels.status")
                                    </label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select class="form-control input-sm ui dropdown " name="max_setup_fee">
                                                <option value=""></option>
                                                <option value="Yes">Completed</option>
                                                <option value="No">Void</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="button" class=" button-loading btn btn-primary saveCaoverageType">
                                        <span class="button--loading d-none"></span> <span
                                            class="button__text">View Payables</span>
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
