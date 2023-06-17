<x-app-layout>
        <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.coverage_name")</label>
            <div class="col-sm-9">
                <input type="text" class="form-control input-sm fw-600" name="name" id="name" required placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.account_type")</label>
            <div class="col-sm-9">
                <?=  form_dropdown('account_type', ['all'=>'All','commercial'=>'Commercial','personal'=>'Personal'], '', ["class"=>"w-100","required"=>true]); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.active")</label>
            <div class="col-sm-9">
                <?=  form_dropdown('account_active',['yes'=>'Yes','no'=>'No'],'', ["class"=>"ui dropdown input-sm w-100","required"=>true]); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.cancel_terms")</label>
            <div class="col-sm-9">
                {!! form_dropdown('cancel_terms',['10'=>'10 Days','20'=>'20 Days','30'=>'30 Days','45'=>'45 Days'],"10", ["class"=>"ui dropdown input-sm w-100","required"=>true,'isBankOption'=>false]) !!}
            </div>
        </div>

        <x-button-group :cancel="routeCheck($route . 'index')"/>
        @endslot
    </x-jet-form-section>
</x-app-layout>
