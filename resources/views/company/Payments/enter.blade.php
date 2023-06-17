<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center" x-data="{ open: 'Action' }">
                <div class="col-lg-12">
                    <h4>
                        <h4>Enter Payment</h4>
                    </h4>
                    <form class="validationForm" novalidate method="POST" action="">
                        @csrf
                        <div class="tab-one">
                            <div class="form-group row">
                                <label for="comp_name" class="col-sm-3 col-form-label">@lang('labels.Account')</label>
                                <div class="col-sm-9">
                                    <input type="text" name="comp_name" class="form-control input-sm" id="comp_name"
                                        placeholder="" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comp_name" class="col-sm-3 col-form-label">@lang('labels.insured_name')</label>
                                <div class="col-sm-9">
                                    <input type="text" name="comp_name" class="form-control input-sm" id="comp_name"
                                        placeholder="" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="esignature" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="button" class=" button-loading btn btn-primary nextTab">
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
