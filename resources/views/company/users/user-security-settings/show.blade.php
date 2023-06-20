<x-app-layout>
       <x-jet-form-section :title="$pageTitle" :buttonGroup="['logs','other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm reloadForm editForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
           <input type="hidden" name="logsArr">
            <input type="hidden" name="user_type" value="{{ $id ?? '' }}">
            <div class="form-group row">
                <label for="minimum_length" class="col-sm-3 col-form-label">@lang("labels.minimum_length")</label>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="minimum_length" class="digitLimit" data-limit="2"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-3 col-form-label ">@lang("labels.minimum_digits")</label>
                <div class="col-sm-4">
                   <x-jet-input type="text" name="minimum_digits" class="digitLimit" data-limit="2" />
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-3 col-form-label ">@lang("labels.minimum_upper_case_letters")</label>
                <div class="col-sm-4">
                   <x-jet-input type="text" name="minimum_upper_case_letters" class="digitLimit" data-limit="2" />
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-3 col-form-label ">@lang("labels.minimum_lower_case_letters")</label>
                <div class="col-sm-4">
                   <x-jet-input type="text" name="minimum_lower_case_letters" class="digitLimit" data-limit="2" />
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-3 col-form-label ">@lang("labels.minimum_special_characters")</label>
                <div class="col-sm-4">
                   <x-jet-input type="text" name="minimum_special_characters" class="digitLimit" data-limit="2" />
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-3 col-form-label ">@lang("labels.special_characters")</label>
                <div class="col-sm-4">
                   <x-jet-input type="text" name="special_characters"  />
                </div>
            </div>
            <div class="form-group row">
                <label for="minimum_password_age" class="col-sm-3 col-form-label ">@lang("labels.minimum_password_age")</label>
                <div class="col-sm-4 d-flex align-items-center">
                   <x-jet-input type="text" name="minimum_password_age" class="digitLimit" data-limit="2"/>  <span class="d-inline  ml-1 fs-0">days</span>
                </div>
            </div>
           {{--  <div class="form-group row">
                <label for="expires_every" class="col-sm-3 col-form-label ">@lang("labels.expires_every")</label>
                <div class="col-sm-4 d-flex align-items-center">
                   <x-jet-input type="text" name="expires_every" class="digitLimit" data-limit="2" /> <span class="d-inline ml-1 fs-0">days</span>
                </div>
            </div> --}}
            <div class="form-group row">
                <label for="number_unsuccessful_in" class="col-sm-3 col-form-label ">@lang("labels.number_unsuccessful_in_text")</label>
                <div class="col-sm-9">
                   <div class="row">
                       <div class="col-md-3">
                            <x-jet-input type="text" name="number_unsuccessful_in"  class="digitLimit" data-limit="2"/>
                       </div>
                       <div class="">
                           in
                       </div>
                       <div class="col-md-3 d-flex align-items-center">
                            <x-jet-input type="text" name="number_unsuccessful_minutes" class="digitLimit" data-limit="2"/><span class="d-inline ml-1 fs-0">minutes</span>
                       </div>
                   </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-3 col-form-label ">@lang("labels.number_inactivity_days")</label>
                <div class="col-sm-4">
                   <x-jet-input type="text" name="number_inactivity_days" class="digitLimit" data-limit="3" />
                </div>
            </div>

            <div class="form-group row">
                <label for="gl_account" class="col-sm-3 col-form-label">@lang("labels.prevent_reuse")</label>
               <div class="col-sm-4">
                   <x-select name="prevent_reuse" :options="['yes'=>'Yes','no'=>'No']" class="ui dropdown"/>
                </div>
            </div>


              <x-button-group :cancel="routeCheck($route . 'index')"/>
        @endslot
        @slot('logContent')
        <x-table id="{{ $activePage }}-logs"  ajaxUrl="{{ routeCheck('company.logs', ['type' => $activePage,'id'=>$id]) }}">

                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">@lang('labels.created_date')
                        </th>

                        <th class="" data-sortable="false" data-field="username" data-width="200">@lang('labels.user_name')
                        </th>
                        <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                    </tr>
                </thead>
            </x-table>
        @endslot

    </x-jet-form-section>
     @push('page_script')
        <script>
            let editArr = @json($data ?? []);
        </script>
    @endpush
</x-app-layout>
