<x-app-layout>
     <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label requiredAsterisk"> @lang("labels.program_name")</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control input-sm" name="name" id="name" required
                                    placeholder="">
                            </div>
                        </div>


           <x-button-group :cancel="routeCheck($route . 'index')"/>
        @endslot
    </x-jet-form-section>
</x-app-layout>
