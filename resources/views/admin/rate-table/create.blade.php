<x-app-layout>

    <x-jet-form-section class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}" method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control input-sm" id="name" placeholder="" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="type" class="col-sm-3 col-form-label requiredAsterisk">Rate table type</label>
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
                <label for="account_type" class="col-sm-3 col-form-label requiredAsterisk">Account types</label>
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
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">State</label>
                <div class="col-sm-9">
                    {!! form_dropdown('state', stateDropDown(['addKey' => ['All' => 'All States']]), '', [
                        'class' => "ui dropdown input-sm
                                                        w-100",
                        'required' => true,
                    ]) !!}


                </div>
            </div>
            <div class="form-group row">
                <label for="coverage_type" class="col-sm-3 col-form-label requiredAsterisk">Coverage type</label>
                <div class="col-sm-9">
                    {!! form_dropdown('coverage_type', coverageTypeDropDown(['addOption'=>['0'=>"All"]]), '', [
                        'class' => "ui dropdown input-sm
                                                        w-100",
                        'required' => true,
                    ]) !!}


                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label ">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" cols="30" class="form-control" rows="3" placeholder="{{ __('Rule of 78 (Fixed rate) This is company wide default rate') }}"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <div class="row form-group align-top-radio">

                        <div class="col-sm-12">
                            <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                <input id="yes" class="form-check-input" name="save_option" checked type="radio"
                                    value="save_defaults_only">
                                <label for="yes" class="form-check-label">Save defaults only: EXISTING FINANCE
                                    COMPANIES ARE
                                    NOT AFFECTED</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                <input id="no" class="form-check-input" name="save_option" type="radio"
                                    value="save_and_reset">
                                <label for="no" class="form-check-label">Save and Reset existing FINANCE COMPANIES:
                                    Save the
                                    default coverage types values and apply the default coverage types
                                    values to all existing FINANCE COMPANIES for the coverage types. ALL EXISTING COVERAGE
                                    TYPES AND SPECIFIED VALUES FOR
                                    FINANCE COMPANIES WILL BE REPLACED.</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
