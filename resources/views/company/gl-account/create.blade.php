<x-app-layout>
    <x-jet-form-section :buttonGroup="['exit']" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}" method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.gl_account_name")</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="name" id="name" required />
                </div>
            </div>


            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
