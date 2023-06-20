<x-app-layout :class="['dateDropdown']">
    <section class="font-1 pt-5 hq-full" x-data="{ open: 'general-information' }"
        x-effect="async () => {
            switch (open) {

                case 'general-information':
                    title = 'General Information'
                    break;

                default:
                    break;
            }

        }">
        <div class="container tableButtonInlineShow">
            <div class="row">
                <div class="col-md-12 page_table_heading">
                    <x-jet-section-title>
                        <x-slot name="title">
                            {{ $pageTitle }}
                        </x-slot>
                    </x-jet-section-title>
                </div>
                @php
                    $currentStatus = !empty($data['current_status']) ? $data['current_status'] : 0;
                @endphp
                <div class="col-md-12 page_table_menu">
                    <div class="row ">

                        <div class="col-md-12">
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end">
                                        @if ($currentStatus !== 1)
                                            <button class="btn btn-default closeTask" type="button"
                                                x-show="(open != 'append' && open != 'logs')"
                                                data-id="{{ $id }}">
                                                @lang('labels.close')</button>
                                            <button class="btn btn-default" type="button" x-on:click="open= 'append'"
                                                x-show="(open != 'append' && open != 'logs')">
                                                @lang('labels.append')</button>
                                        @else
                                            <button class="btn btn-default reopenTask" type="button"
                                                x-show="open != 'logs'" data-id="{{ $id }}">
                                                @lang('labels.reopen')</button>
                                        @endif


                                        <button class="btn btn-default " type="button" x-on:click="open = 'logs'"
                                            x-show="open != 'logs'">
                                            @lang('labels.logs')</button>
                                        <button class="btn btn-default " type="button"> <a
                                                href="{{ routeCheck($route . 'index') }}" data-turbolinks="false"
                                                x-show="(open != 'logs' && open != 'append')">
                                                @lang('labels.cancel')</a></button>
                                        <button class="btn btn-default " type="button"
                                            x-on:click="open = 'general-information'"
                                            x-show="(open != 'logs' && open == 'append')">@lang('labels.cancel')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12" x-show="open == 'general-information'">
                    <table class="table">

                        <tbody>
                            <tr>
                                <td>@lang('labels.status')</td>
                                <td> {{ taskStatus($data['current_status'] ?? 'null', true) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('labels.priority')</td>
                                <td> {{ $data['priority'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('labels.schedule')</td>
                                <td> {{ changeDateFormat($data['shedule']) ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('labels.created_by')</td>
                                <td> {{ $data->created_by->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('labels.assigned')</td>
                                <td> {{ $data->assigned->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('labels.subject')</td>
                                <td> {!! $data->subject ?? '' !!}</td>
                            </tr>
                            <tr>
                                <td>@lang('labels.notes')</td>
                                <td> {!! $data->notes ?? '' !!}</td>
                            </tr>

                        </tbody>
                    </table>



                </div>
                <div class="col-md-12" x-show="open == 'append'">
                    <form action="{{ routeCheck($route . 'update', $id) }}" method="post"
                        class="validationForm editForm reloadForm" novalidate>
                        @csrf
                        @method('put')
                        <input type="hidden" name="logsArr">
                        <div class="form-group row">
                            <label for="bank_name"
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.subject')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="subject" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label ">@lang('labels.notes')</label>
                            <div class="col-sm-9">
                                <textarea name="notes" id="notes" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="schedule"
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.schedule')</label>
                            <div class="col-md-6">
                                <x-jet-input type="hidden" name="shedule" class="dataDropDown" data-required="true"
                                    data-min-date="true" data-value='{{ date('Y-m-d') }}' />
                            </div>
                            <div class="col-md-1">
                                <x-link class="dataDropDownClear">Clear</x-link>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status"
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.priority')</label>
                            <div class="col-sm-3">
                                <x-select :options="['High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low']" name="priority" required class="ui dropdown"
                                    placeholder="Select {{ __('labels.priority') }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status"
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                            <div class="col-sm-3">
                                <x-select :options="taskStatus()" name="status" class="ui dropdown"
                                    placeholder="Select {{ __('labels.status') }}" required
                                    selected="{{ $data['current_status'] }}" />
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="notes" class="col-sm-3 col-form-label">@lang('labels.upload_file')</label>
                            <div class="col-sm-9 ">
                                <x-input-file label="{{ __('labels.upload_file') }}" name="files[]" data-file="task"
                                    accept=".jpeg,.png,.gif,.pdf" multiple
                                    data-multiple-caption="{count} files selected" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gl_account" class="col-sm-3 col-form-label ">@lang('labels.assign_task')</label>
                            <div class="col-sm-3">
                                <x-select :options="$userData ?? []" name="assign_task" class="ui dropdown"
                                    placeholder="Select" />
                            </div>
                        </div>
                        <x-button-group :cancel="routeCheck($route . 'index')" xclick="open = 'general-information'" />
                    </form>
                </div>

                <div class="col-md-12" x-show="open != 'logs'">
                    <!--<x-jet-section-title>
                        <x-slot name="title">
                            Task History
                        </x-slot>
                    </x-jet-section-title>-->


                    <x-table id="{{ $activePage }}-list"
                        ajaxUrl="{{ routeCheck($route . 'index', ['parentId' => $id]) }}">
                        <thead>
                            <tr>
                                <th class="align-middle" data-sortable="true" data-width="170"
                                    data-field="created_at">
                                    @lang('labels.created_date')</th>
                                <th class="align-middle" data-sortable="true" data-width="170"
                                    data-field="updated_at">
                                    @lang('labels.last_update_date')</th>
                                <th class="align-middle" data-sortable="true" data-width="" data-field="username">
                                    @lang('labels.username')</th>
                                <th class="align-middle" data-sortable="true" data-width="" data-field="subject">
                                    @lang('labels.subject')
                                </th>

                                <th class="align-middle" data-sortable="" data-width="" data-field="shedule">
                                    @lang('labels.schedule')
                                </th>
                                <th class="align-middle" data-sortable="" data-width="" data-field="priority">
                                    @lang('labels.priority')
                                </th>
                                <th class="align-middle" data-sortable="" data-width="" data-field="status">
                                    @lang('labels.status')
                                </th>
                                <th class="align-middle" data-sortable="" data-width="" data-field="assign_task">
                                    @lang('labels.assign_task')
                                </th>

                            </tr>
                        </thead>
                    </x-table>
                </div>


                <div class="col-md-12" x-show="open == 'logs'">
                    <x-table id="{{ $activePage }}-logs"
                        ajaxUrl="{{ routeCheck('company.logs', ['type' => activePageName(), 'id' => $id]) }}">
                        <thead>
                            <tr>
                                <th class="" data-sortable="true" data-field="created_at" data-width="170">
                                    @lang('labels.created_date')
                                </th>
                                <th class="" data-sortable="true" data-field="username" data-width="200">
                                    @lang('labels.user_name')</th>
                                <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                            </tr>
                        </thead>
                    </x-table>
                    <div class="remodal" id="closeTaskModel"
                        data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
                        <button data-remodal-action="close" class="remodal-close"></button>
                        <h5>@lang('labels.close_task') </h5>
                        <form action="{{ routeCheck($route . 'cloes-task') }}" class="reloadForm">
                            <div class="form-group text-left ">
                                <x-jet-input type="hidden" name="id" value="{{ $id }}" />
                                <label for="notes"
                                    class=" col-form-label requiredAsterisk">@lang('labels.notes')</label>
                                <div class="">
                                    <textarea name="notes" id="notes" required cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                            <button class="btn btn-sm btn-primary saveData">Submit</button>
                            <button data-remodal-action="cancel" class="btn btn-default btn-sm">Cancel</button>

                        </form>
                    </div>
                    <div class="remodal" id="reopenTaskModel"
                        data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
                        <button data-remodal-action="close" class="remodal-close"></button>
                        <h5>@lang('labels.reopen_task') </h5>
                        <form action="{{ routeCheck($route . 'reopen-task') }}" class="reloadForm">
                            <div class="form-group text-left ">
                                <x-jet-input type="hidden" name="id" value="{{ $id }}" />
                                <label for="description"
                                    class=" col-form-label requiredAsterisk">@lang('labels.description')</label>
                                <div class="">
                                    <textarea name="description" id="description" required cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                            <button class="btn btn-sm btn-primary saveData">Submit</button>
                            <button data-remodal-action="cancel" class="btn btn-default btn-sm">Cancel</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('page_script')
        <script>
            let editArr = @json($data?->toArray() ?? []);
            $(document).on('click', '.closeTask', function() {
                let closeTaskModel = $('#closeTaskModel').remodal();
                closeTaskModel.open()
            });
            $(document).on('click', '.reopenTask', function() {
                let reopenTaskModel = $('#reopenTaskModel').remodal();
                reopenTaskModel.open()
            });
            $(document).on('click', '.taskDataGet', async function() {
                let id = $(this).data('id');
                const url = BASE_URL + "task/" + id + "/edit";
                console.log(url);
                let result = await doAjax(url, 'get');

                if (result) {
                    notes = result.notes ?? '';
                    var html = `<div class="row text-left">
                        <label for="notes" class="col-sm-1 col-form-label ">Notes</label>
                        <div class="col-sm-9">
                           ${notes}
                        </div>
                    </div>`;
                    htmlAlertModel(html);

                }
            });
        </script>
    @endpush
</x-app-layout>
