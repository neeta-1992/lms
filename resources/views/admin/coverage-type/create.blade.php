<x-app-layout>
   <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route.'store') }}" method="post">
       @slot('form')
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Coverage name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control input-sm fw-600" name="name" id="name" required placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Account type</label>
            <div class="col-sm-9">
                <?=  form_dropdown('account_type', ['all'=>'All','commercial'=>'Commercial','personal'=>'Personal'], '', ["class"=>"w-100","required"=>true]); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Active</label>
            <div class="col-sm-9">
                <?=  form_dropdown('account_active',['yes'=>'Yes','no'=>'No'],'', ["class"=>"ui dropdown input-sm w-100","required"=>true]); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Cancel terms</label>
            <div class="col-sm-9">
                {!! form_dropdown('cancel_terms',['10'=>'10 Days','20'=>'20 Days','30'=>'30 Days','45'=>'45 Days'],"10", ["class"=>"ui dropdown input-sm w-100","required"=>true,'isBankOption'=>false]) !!}
            </div>
        </div>
           <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label"></label>
            <div class="col-sm-9">
                <div class="row form-group align-top-radio">

                    <div class="col-sm-12">
                        <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                            <input id="yes" class="form-check-input" name="save_option" checked type="radio" value="save_defaults_only">
                            <label for="yes" class="form-check-label">Save defaults only: EXISTING FINANCE COMPANIES ARE
                                NOT AFFECTED</label>
                        </div>
                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                            <input id="no" class="form-check-input" name="save_option" type="radio" value="save_and_reset">
                            <label for="no" class="form-check-label">Save and Reset existing FINANCE COMPANIES: Save the
                                default coverage types values and apply the default coverage types
                                values to all existing FINANCE COMPANIES for the coverage types. ALL EXISTING COVERAGE
                                TYPES AND SPECIFIED VALUES FOR
                                FINANCE COMPANIES WILL BE REPLACED.</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <x-button-group :cancel="routeCheck($route . 'index')"/>
        @endslot
    </x-jet-form-section>
</x-app-layout>
