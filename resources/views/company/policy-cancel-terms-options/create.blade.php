<x-app-layout>
    <x-jet-form-section :buttonGroup="['exit']" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')

            <div class="form-group row">
                <label for="days" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.number_of_days")</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="days" required class="digitLimit" data-limit="2"/>
                </div>
            </div>


            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
