<x-app-layout>
       <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="name" required />
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label">@lang('labels.description')</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" cols="30" class="form-control" rows="3"></textarea>

                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.active')
                </label>
                <div class="col-sm-9">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="rightfax_server_email_enable" name="status" type="radio" required
                            class="form-check-input" value="1">
                        <label for="rightfax_server_email_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="rightfax_server_email_disable" name="status" type="radio" required
                            class="form-check-input" value="0">
                        <label for="rightfax_server_email_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status_id')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="status_id" class="digitLimit w-25" required />

                </div>
            </div>

             <x-button-group :cancel="routeCheck($route . 'index')"/>
        @endslot
    </x-jet-form-section>
</x-app-layout>
