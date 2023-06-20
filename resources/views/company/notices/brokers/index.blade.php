<x-app-layout>
    <x-jet-form-section :title="($pageTitle ?? '')" :activePageName="($type)" :buttonGroup="['logs']" class="validationForm" novalidate  action="{{ routeCheck($route.$type) }}" method="post">
        @slot('form')
 <div class="table-responsive" style="overflow: visible;">
                <table class="table table_left_padding_0 mb-3 isTitleHeading">
                    <thead class="">
                        <tr>
                            <th>@lang('labels.notice_type')</th>
                            <th>@lang('labels.frequency') </th>
                            <th>@lang('labels.cancel_days') </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td  class="vertical-middle"> Unearned Premium Statement
                                <input type="hidden" name="type[]" value="unearned_premium">
                            </td>
                            @php
                               $frequencyUnearnedPremium = !empty($data['unearned_premium']['frequency']) ? explode(",",$data['unearned_premium']['frequency']) : [];
                               $noticeOfCancelledPremium = !empty($data['notice_of_cancelled']['frequency']) ? explode(",",$data['notice_of_cancelled']['frequency']) : [];
                               $weekArray = ["MON",'TUS','WED','THU','FRI','SAT','SUN'];
                           @endphp
                            <td  class="vertical-middle">
                                @foreach ($weekArray as $weekKey => $week)
                                    @php
                                         $checked =  in_array($week,$frequencyUnearnedPremium) ? true : false;
                                    @endphp
                                    <x-jet-checkbox for="unearned_premium_statement_frequency{{ $week }}" labelText='{{ $week }}' class="changesetup setup_fees"
                                    name="unearned_premium[frequency][]" id="unearned_premium_statement_frequency{{ $week }}" value="{{ $week }}" :checked="$checked"/>
                                @endforeach

                             </td>
                            <td  class="vertical-middle">
                                <div class="d-flex align-items-center">
                                    Days Until Cancel
                                    <div class="w-5 ml-3">
                                        <div class="form-group mb-0">
                                            {!! form_dropdown('unearned_premium[cancel_days]', range(1, 30),($data['unearned_premium']['cancel_days'] ?? ""), [ 'class' => 'w-100 min-w-100'
                                            ],true) !!}
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td  class="vertical-middle">Notice Of Cancelled Account
                                <input type="hidden" name="type[]" value="notice_of_cancelled">
                            </td>
                            <td  class="vertical-middle">
                                 @foreach ($weekArray as $weekKey => $week)
                                    @php
                                         $checked =  in_array($week,$noticeOfCancelledPremium) ? true : false;
                                    @endphp
                                    <x-jet-checkbox for="notice_of_cancelled_account_frequency{{ $week }}" labelText='{{ $week }}' class="changesetup setup_fees"
                                    name="notice_of_cancelled[frequency][]" id="notice_of_cancelled_account_frequency{{ $week }}" value="{{ $week }}" :checked="$checked"/>
                                @endforeach
                            </td>
                            <td  class="vertical-middle">
                                <div class="d-flex align-items-center">
                                    Days Until Cancel
                                    <div class="w-5 ml-3  mb-0">
                                        <div class="form-group">
                                            {!! form_dropdown('notice_of_cancelled[cancel_days]', range(1, 30),  ($data['notice_of_cancelled']['cancel_days'] ?? ""), ['class' => 'min-w-100'
                                            ],true) !!}
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>


                    </tbody>
                </table>

            </div>
            <div class="mb-3">
                <p class="fw-500" style="font-size: 13px;">The notice defaults below are the initial settings for agencies, general agencies and insurance companies. When you add a new record, the notice sending preferences will be initialized to these settings. Click column headings to set all rows.</p>
            </div>
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
                                    $noticesDescriptionText = noticesDescriptionText(['onDB'=>true,'select'=>'name','type'=>'Broker']);
                                @endphp
                                @if($noticesDescriptionText)
                                    @foreach($noticesDescriptionText as $key => $row)
                                    @php
                                        $sendType = !empty($data['option'][$key]['send_type']) ? $data['option'][$key]['send_type'] : '' ;
                                    @endphp
                                           <tr>
                                                <td><a href="javascript:void(0)" class="noticeTemplateShow" data-url="{{ routeCheck('ajax.notice-template-data',['type'=>'general-agent','action'=>($key ??  "")]) }}" data-notice-type="{{ $sendType ?? '' }}" >{{ $row ?? '' }}</a></td>
                                                <td>
                                                    <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                                        <input id="mail_{{ $key ??  ""}}" class="form-check-input notices_description_radio" @checked($sendType == "Mail")  name="option[{{ $key ??  ""}}]"
                                                            type="radio" value="Mail">
                                                        <label for="mail_{{ $key ??  ""}}" class="form-check-label">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                                        <input id="fax_{{ $key ??  ""}}" class="form-check-input notices_description_radio" @checked($sendType == "Fax")  name="option[{{ $key ??  ""}}]"
                                                            type="radio" value="Fax">
                                                        <label for="fax_{{ $key ??  ""}}" class="form-check-label">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                                        <input id="email_{{ $key ??  ""}}" class="form-check-input notices_description_radio" @checked($sendType == "Email") name="option[{{ $key ??  ""}}]"
                                                            type="radio" value="Email">
                                                        <label for="email_{{ $key ??  ""}}" class="form-check-label">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                                        <input id="do_no_send_{{ $key ??  ""}}" class="form-check-input notices_description_radio" @checked($sendType == "Do not send") name="option[{{ $key ??  ""}}]"
                                                            type="radio" value="Do not send">
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
             <x-button-group cancel='{{ routeCheck("company.dashboard") }}'/>
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
        let  editArr = @json($data ?? []);
    </script>
    @endpush
</x-app-layout>
