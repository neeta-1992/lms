<x-form method="post" class="replyMailBox row p-3"
    action="{{ routeCheck($route . 'reply-save-mail', $row->id ?? '') }}">
    @if (!empty($replayType) && $replayType == 'forward')
        <h4>@lang('labels.forward')</h4>
    @else
        <h4>@lang('labels.replay')</h4>
    @endif

    <div class="col-md-12">
        <b>@lang('labels.from')</b> : {{ $row->form_user->name ?? '' }}
    </div>
    <div class="col-md-12">
        {{ changeDateFormat($row->created_at ?? '') }}
    </div>
    <div class="col-md-12">
        @if (!empty($replayType) && $replayType == 'forward')
            <span>FW</span>: {{ $row->subject ?? '' }}
        @else
            <span>RE</span>: {{ $row->subject ?? '' }}
        @endif

    </div>
    @if (!empty($replayType) && $replayType == 'forward')
        <div class="form-group col-md-12">
            <label for="forwardto" class="requiredAsterisk">@lang('labels.to')</label>
            <x-semantic-dropdown class="userDropdown multiple" name="forwardto" required="required" id="forwardto" />

        </div>
        <div class="form-group col-md-12">
            <label for="forwardcc">@lang('labels.cc')</label>
            <x-semantic-dropdown class="userDropdown multiple" name="forwardcc" id="forwardcc" />
        </div>

        <div class="form-group col-md-12">
            <label for="to" class="requiredAsterisk">@lang('labels.message')</label>
            <x-quill-editor style="height: 350px" id="repalymessage" name="repalymessage" data-name="repalymessage"
                required value="{!! $row->message ?? '' !!}" :files="($row?->files ?? [])"/>
        </div>
    @else
        <div class="form-group col-md-12">
            <label for="to" class="requiredAsterisk">@lang('labels.message')</label>
            <x-quill-editor style="height: 350px" id="repalymessage" name="repalymessage" data-name="repalymessage"
                required />
        </div>
    @endif
    <div class="col-md-6">
        <b>@lang('labels.from')</b> : {{ $row->form_user->name ?? '' }}
    </div>
    <div class="col-md-6">
        {{ changeDateFormat($row->created_at ?? '') }}
    </div>
    <div class="col-md-12">
        {!! $row->message !!}
    </div>
    @if(!empty($replayType) && $replayType == 'forward')


    <div class="col-md-12">
        @php
            $filesArr = !empty($row->files) ? $row->files?->toArray() : null;
            $filesArr = !empty($filesArr) ? array_column($filesArr,'file_name') : [];
            $filesString =  !empty($filesArr) ? implode(",",$filesArr) : null;
        @endphp
        <input type="hidden" class="attachments" name="attachments" value="{{ $filesString ?? null }}">
    </div>
    @endif

</x-form>
