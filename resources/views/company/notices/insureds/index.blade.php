<x-app-layout>
    <x-jet-form-section :title="($pageTitle ?? '')" :activePageName="($type)" :buttonGroup="['logs']" class="validationForm" novalidate action="{{ routeCheck($route.$type) }}" method="post">
        @slot('form')





        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('labels.description') </th>
                                <th>@lang('labels.mail') </th>
                                <th>@lang('labels.fax') </th>
                                <th>@lang('labels.email') </th>
                                <th>@lang('labels.do_not_send') </th>
                                <th>@lang('labels.send_to_leave_blank_for_default')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $noticesDescriptionText = noticesDescriptionText(['onDB'=>true,'select'=>'name','type'=>'Insured']);
                            @endphp
                            @if($noticesDescriptionText)
                            @foreach($noticesDescriptionText as $key => $row)
                            @php
                            $sendType = !empty($data['option'][$key]['send_type']) ? $data['option'][$key]['send_type'] : '' ;
                            @endphp
                            <tr>
                                <td><a href="javascript:void(0)" class="noticeTemplateShow" data-url="{{ routeCheck('ajax.notice-template-data',['type'=>'general-agent','action'=>($key ??  "")]) }}" data-notice-type="{{ $sendType ?? '' }}">{{ $row ?? '' }}</a></td>
                                <td>
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                        <input id="mail_{{ $key ??  ""}}" class="form-check-input notices_description_radio" @checked($sendType=="Mail" ) name="option[{{ $key ??  ""}}]" type="radio" value="Mail">
                                        <label for="mail_{{ $key ??  ""}}" class="form-check-label">
                                    </div>
                                </td>
                                <td>
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                        <input id="fax_{{ $key ??  ""}}" class="form-check-input notices_description_radio" @checked($sendType=="Fax" ) name="option[{{ $key ??  ""}}]" type="radio" value="Fax">
                                        <label for="fax_{{ $key ??  ""}}" class="form-check-label">
                                    </div>
                                </td>
                                <td>
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                        <input id="email_{{ $key ??  ""}}" class="form-check-input notices_description_radio" @checked($sendType=="Email" ) name="option[{{ $key ??  ""}}]" type="radio" value="Email">
                                        <label for="email_{{ $key ??  ""}}" class="form-check-label">
                                    </div>
                                </td>
                                <td>
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                        <input id="do_no_send_{{ $key ??  ""}}" class="form-check-input notices_description_radio" @checked($sendType=="Do not send" ) name="option[{{ $key ??  ""}}]" type="radio" value="Do not send">
                                        <label for="do_no_send_{{ $key ??  ""}}" class="form-check-label">
                                    </div>
                                </td>
                                <td>

                                    @if($sendType == "Do not send")
                                    <x-jet-input type="text" class="notices_description_text" readonly name="send_to[{{ $key  }}]" />
                                    @elseif ($sendType == "Fax")
                                    <x-jet-input type="text" class="notices_description_text" name="send_to[{{ $key  }}]" value="{{ $data['description'][$key]['send_to'] ?? '' }}" />
                                    @else
                                    <x-jet-input type="text" class="notices_description_text" name="send_to[{{ $key  }}]" value="{{ $data['description'][$key]['send_to'] ?? '' }}" />
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <x-button-group cancel='{{ routeCheck("company.dashboard") }}' />
        @endslot
        @slot('logContent')

        <x-bootstrap-table :data="[
                    'table' => 'logs',
                    'id'    =>  $type.'-logs',
                    'cookieid' => true,
                    'sortorder' => 'desc',
                    'sortname' => 'created_at',
                    'type' => 'serversides',
                    'ajaxUrl' => routeCheck('company.logs', ['type' => $type]),
                ]">
            <thead>
                <tr>
                    <th class="" data-sortable="true" data-field="created_at" data-width="170">@lang('labels.created_date')
                    </th>

                    <th class="" data-sortable="true" data-field="username" data-width="200">
                        @lang('labels.user_name')
                    </th>
                    <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                </tr>
            </thead>
        </x-bootstrap-table>
        @endslot

    </x-jet-form-section>
    @push('page_script')
    <script>
        let editArr = @json($data ? ? []);

    </script>
    @endpush
</x-app-layout>
