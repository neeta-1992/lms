<x-app-layout>
       <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
             <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.status")</label>
                <div class="col-sm-3">
                   {!! form_dropdown('status',[1=>'Enable',0=>'Disable'],'', ["class"=>"","required"=>true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.bank_name")</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="bank_name" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.account_number")</label>
                <div class="col-sm-9">
                   <x-jet-input type="text" name="account_number" required />

                </div>
            </div>
            <div class="form-group row">
                <label for="gl_account" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.gl_account")</label>
               <div class="col-sm-9">
                   {!! form_dropdown('gl_account',glAccountDropDown(['onDB'=>true,'select'=>'number']),'', ["class"=>"","required"=>true]) !!}
                </div>
            </div>


              <x-button-group :cancel="routeCheck($route . 'index')"/>
        @endslot
    </x-jet-form-section>
</x-app-layout>
