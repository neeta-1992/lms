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
                                    class="col-sm-3 col-form-label">@lang("labels.show_payments_entered_by")</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="checkbox" class=" input-sm "
                                                name="personal_maximum_finance_amount"
                                                id="personal_maximum_finance_amount" placeholder="From">
                                            <span class="custom-control-label align-baseline">@lang('labels.all')</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control input-sm "
                                                name="commercial_maximum_finance_amount"
                                                id="commercial_maximum_finance_amount" placeholder="To">
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="form-group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="button" class=" button-loading btn btn-primary saveCaoverageType">
                                        <span class="button--loading d-none"></span> <span
                                            class="button__text">Search</span>
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
