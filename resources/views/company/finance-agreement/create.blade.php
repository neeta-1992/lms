<x-app-layout :class="['codemirror']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.name")</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="fw-600" name="name" id="name" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.description")</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control" required cols="30" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="template" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.text")</label>
                <div class="col-sm-9">
                    <textarea name="template" id="template" class="form-control financeAgreementCodemirrorEditor templateEditor" required
                        cols="30" rows="3"></textarea>

                </div>
            </div>

            <x-button-group :cancel="routeCheck($route . 'index')"/>

        @endslot
    </x-jet-form-section>
</x-app-layout>
