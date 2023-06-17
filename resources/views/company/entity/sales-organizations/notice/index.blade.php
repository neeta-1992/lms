<form class="validationForm otherEditForm" novalidate action="{{ routeCheck($route . 'notice.save', [$id]) }}" method="post">
    <input type="hidden" name="entity_id" value="{{ $id ?? '' }}">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Mail</th>
                            <th>Fax</th>
                            <th>Email</th>
                            <th>Do Not Send</th>
                            <th>Send To(Leave Blank For Default)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $noticesDescriptionText = noticesDescriptionText(['onDB' => true, 'select' => 'name','type'=>"Sales_organizations"]);
                        @endphp
                        @if ($noticesDescriptionText)
                            @foreach ($noticesDescriptionText as $key => $row)
                                @php
                                    $sendType = !empty($data['option'][$key]['send_type']) ? $data['option'][$key]['send_type'] : '';
                                @endphp
                                <tr>
                                    <td><a href="javascript:void(0)" class="noticeTemplateShow"
                                            data-url="{{ routeCheck('ajax.notice-template-data', ['type' => 'sales-organizations', 'action' => $key ?? '']) }}"
                                            data-notice-type="{{ $sendType ?? '' }}">{{ $row ?? '' }}</a></td>
                                    <td>
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                            <input id="mail_{{ $key ?? '' }}"
                                                class="form-check-input notices_description_radio"
                                                @checked($sendType == 'Mail') name="option[{{ $key ?? '' }}]"
                                                type="radio" value="Mail">
                                            <label for="mail_{{ $key ?? '' }}" class="form-check-label">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                            <input id="fax_{{ $key ?? '' }}"
                                                class="form-check-input notices_description_radio"
                                                @checked($sendType == 'Fax') name="option[{{ $key ?? '' }}]"
                                                type="radio" value="Fax">
                                            <label for="fax_{{ $key ?? '' }}" class="form-check-label">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                            <input id="email_{{ $key ?? '' }}"
                                                class="form-check-input notices_description_radio"
                                                @checked($sendType == 'Email') name="option[{{ $key ?? '' }}]"
                                                type="radio" value="Email">
                                            <label for="email_{{ $key ?? '' }}" class="form-check-label">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                            <input id="do_no_send_{{ $key ?? '' }}"
                                                class="form-check-input notices_description_radio"
                                                @checked($sendType == 'Do not send') name="option[{{ $key ?? '' }}]"
                                                type="radio" value="Do not send">
                                            <label for="do_no_send_{{ $key ?? '' }}" class="form-check-label">
                                        </div>
                                    </td>
                                    <td>

                                        @if ($sendType == 'Do not send')
                                            <x-jet-input type="text" class="notices_description_text" readonly
                                                name="send_to[{{ $key }}]" />
                                        @elseif ($sendType == 'Fax')
                                            <x-jet-input type="text" class="notices_description_text"
                                                name="send_to[{{ $key }}]"
                                                value="{{ $data['description'][$key]['send_to'] ?? '' }}" />
                                        @else
                                            <x-jet-input type="text" class="notices_description_text"
                                                name="send_to[{{ $key }}]"
                                                value="{{ $data['description'][$key]['send_to'] ?? '' }}" />
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
    <x-button-group class="saveData" />
    <script>
        var    editFormArr = @json($data ?? []);
    </script>

</form>

