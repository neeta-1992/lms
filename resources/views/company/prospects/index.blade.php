<x-app-layout :class="['dateDropdown']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck('company.dashboard')]]]" class="validationForm " novalidate method="post" x-data="findUser"
        x-on:submit.prevent="findUser($formData)">
        @slot('form')
            <div class="row">
                <div class="col-md-6">
                    <div class="row form-group">
                        <label for="name" class="col-sm-3 col-form-label">@lang('labels.agency_name')</label>
                        <div class="col-sm-9">
                            <x-jet-input type="text" name="name" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row form-group">
                        <label for="sales_organization" class="col-sm-3 col-form-label">@lang('labels.sales_organization')</label>
                        <div class="col-sm-9">
                            <x-select class="ui dropdown input-sm" name="sales_organization"
                                placeholder="Select Sales Organization" :options="salesOrganizationType(['all' => true])" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row form-group">
                        <label for="state" class="col-sm-3 col-form-label">@lang('labels.state')</label>
                        <div class="col-sm-9">
                            <x-select :options="stateDropDown()" name="state" class="ui dropdown" required
                                placeholder="Select State" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row form-group">
                        <label for="status" class="col-sm-3 col-form-label">@lang('labels.status')</label>
                        <div class="col-sm-9">
                            <x-select :options="prospectsStatuArr()" name="status" class="ui dropdown  " required
                                placeholder="Select Status" />
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <label for="date" class="col-sm-3 col-form-label">@lang('labels.date')</label>
                                <div class="col-md-9">
                                    <x-jet-input type="hidden" name="form_date" class="dataDropDown " data-range="toDate" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <label for="date" class="col-sm-3 col-form-label">@lang('labels.to')</label>
                                <div class="col-md-8">
                                    <x-jet-input type="hidden"  name="to_date" class="dataDropDown toDate" />
                                </div>
                                <div class="col-md-1">
                                    <x-link class="dataDropDownClear">Clear</x-link>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                   <div class="d-flex">
                    <button type="submit" class=" button-loading btn btn-primary">
                        <span class="button--loading d-none"></span> <span class="button__text">Find</span>
                    </button>
                    <button type="button" class="button-loading btn btn-primary resetForm">Clear</span>
                    </button>
                   </div>
                </div>
                {{-- <div class="col-md-12">

                </div> --}}
            </div>
        @endslot


        @slot('otherTab')
            <div x-show="open == 'userTable'" >
                <x-table id="{{ $activePage }}" ajaxUrl="{{ routeCheck($route . 'index') }}" queryParams="queryParams">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">
                                @lang('labels.created_date')</th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">
                                @lang('labels.last_update_date ')</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="name">@lang('labels.agency')
                                @lang('labels.name')</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="status">
                                @lang('labels.status')</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="state">
                                @lang('labels.state')</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="sales_organization">
                                @lang('labels.sales_organization')</th>

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
                        this.open = 'userTable';
                        formInfo = formData;
                        console.log(formInfo);
                        $("#{{ $activePage }}").bootstrapTable('refresh');
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
