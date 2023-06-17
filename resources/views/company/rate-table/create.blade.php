<x-app-layout>
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}" method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.name")</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control input-sm" id="name" placeholder="" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="type" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.rate_table_type")</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'type',
                        rateTableTypeDropDown(),
                        [],
                        ['class' => 'ui fluid normal dropdown input-sm', 'required' => true],
                    ) !!}


                </div>
            </div>
            <div class="form-group row">
                <label for="account_type" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.account_types")</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'account_type',
                        rateTableAccountType(),
                        [],
                        ['class' => 'ui fluid normal dropdown input-sm', 'required' => true],
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.state")</label>
                <div class="col-sm-9">
                    {!! form_dropdown('state', stateDropDown(['addKey' => ['All' => 'All States']]), '', [
                        'class' => "ui dropdown input-sm
                                                        w-100",
                        'required' => true,
                    ]) !!}


                </div>
            </div>
            <div class="form-group row">
                <label for="coverage_type" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.coverage_type")</label>
                <div class="col-sm-9">
                    {!! form_dropdown('coverage_type', coverageTypeDropDown(['addOption'=>['0'=>"All"]]), '', [
                        'class' => "ui dropdown input-sm
                                                        w-100",
                        'required' => true,
                    ]) !!}


                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label ">@lang("labels.description")</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" cols="30" class="form-control" rows="3" placeholder="{{ __('Rule of 78 (Fixed rate) This is company wide default rate') }}"></textarea>
                </div>
            </div>



            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
