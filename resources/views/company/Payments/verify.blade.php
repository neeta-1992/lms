<x-app-layout :class="['dateDropdown']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck('company.dashboard')]]]" class="validationForm findForm " :title="$pageTitle" novalidate method="post" x-data="findData" x-on:submit.prevent="findForm($formData)" x-effect="formEffect">
        @slot('form')
        <div class="form-group row">
            <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.show_payments_entered_by')</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-md-1">
                        <x-jet-checkbox name="status" @change="allDropDown($el)"  value="all" class="permissionCheckBox" id="allStatus" labelText="{{ __('labels.all') }}"  checked />
                    </div>
                    <div class="col-md-11">
                      
                        <x-semantic-dropdown placeholder="Search User" class="userDropDown  multiple">
                            <input type="hidden" name="users[]">
                        </x-semantic-dropdown>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <button type="submit" class=" button-loading btn-sm btn btn-primary saveCaoverageType">
                    <span class="button--loading d-none"></span> <span class="button__text">@lang('Search')</span>
                </button>
            </div>
        </div>
        @endslot
        @slot('otherTab')
        <div x-show="open == 'findData'" class="htmlData">
           
        </div>
        <div x-show="open == 'processEntered'" class="processEntered">
           
        </div>
        @endslot
    </x-jet-form-section>
  

</x-app-layout>
