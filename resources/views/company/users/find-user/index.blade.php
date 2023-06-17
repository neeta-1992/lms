<x-app-layout>
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck('company.dashboard')]]]" class="validationForm " novalidate method="post" x-data="findUser" x-on:submit.prevent="findUser($formData)">
        @slot('form')
        <div class="row">
            <div class="col-md-6">
                <div class="row form-group">
                    <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.first_name')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="first_name" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row form-group">
                    <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.last_name')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="last_name" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row form-group">
                    <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.email')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="email" name="email" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row form-group">
                    <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.telephone')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="tel" name="telephone" class="telephone" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row form-group">
                    <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.user')
                        @lang('labels.role')</label>
                    <div class="col-sm-9">
                        {!! form_dropdown('role',  [1=>'Adminstrator',2=>'User'], '', ['class' => 'w-100']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row form-group">
                    <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.user_type')</label>
                    <div class="col-sm-9">
                        {!! form_dropdown('user_type', loginUserTypeArr(), '', ['class' => 'w-100']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row form-group">
                    <label for="quote_id" class="col-sm-3 col-form-label">@lang('labels.status')</label>
                    <div class="col-sm-9">
                        {!! form_dropdown('status', statusArr(), '', ['class' => 'w-100']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class=" button-loading btn btn-primary">
                    <span class="button--loading d-none"></span> <span class="button__text">Find</span>
                </button>
            </div>
        </div>

        @endslot


        @slot('otherTab')
        <div x-show="open == 'userTable'">
            <x-table id="{{ $activePage }}-user"  ajaxUrl="{{ routeCheck($route.'user-list') }}" queryParams="queryParams">
                <thead>
                    <tr>
                        <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at"> @lang('labels.created_date')</th>
                        <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at"> @lang('labels.last_update_date')</th>
                        <th class="align-middle" data-sortable="true" data-width="450" data-field="first_name"> @lang('labels.name')</th>
                        <th class="align-middle" data-sortable="true" data-width="" data-field="user_type"> @lang('labels.entity_type')</th>
                        <th class="align-middle" data-sortable="true" data-field="role">@lang('labels.user_role')</th>
                        <th class="align-middle" data-sortable="true" data-field="email">@lang('labels.email')</th>
                        <th class="align-middle" data-sortable="true" data-field="mobile">@lang('labels.telephone')</th>
                    </tr>

                </thead>
            </x-table>
        </div>
        @endslot

    </x-jet-form-section>
    @push('page_script')
    <script>
        let formInfo = {};
        document.addEventListener('alpine:init', () => {
            Alpine.data('findUser', () => ({
                findUser(formData) {
                    let fillerObj = objClean(formData);
                   /*  if ($.isEmptyObject(fillerObj) == false) { */
                        this.open = 'userTable';
                        formInfo = formData;
                        $("#{{ $activePage }}-user").bootstrapTable('refresh');
                    /*     console.log(this.open);
                    } */
                }
            }))
        })

        function queryParams(params) {
            const paramsObj = Object.assign(params, formInfo)
            return paramsObj
        }



    </script>
    @endpush
</x-app-layout>
