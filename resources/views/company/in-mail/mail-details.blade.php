<div class="inmail_tab_list_heading">
    @if (!empty($drafts))
        <div class="inmail_tab_list_check"> {{ $row->to_name ?? '' }}</div>
    @elseif(!empty($type) && $type == 'inbox')
        <div class="inmail_tab_list_form">
            @if ($row?->form_user?->user_type == 1)
                <button type="button" class="btn btn-dark btn-circle btn-xsm"></button>
            @elseif($row?->form_user?->user_type == 2)
                <button type="button" class="btn btn-danger btn-circle btn-xsm"></button>
            @elseif($row?->form_user?->user_type == 4)
                <button type="button" class="btn btn-success btn-circle btn-xsm"></button>
            @elseif($row?->form_user?->user_type == 5)
                <button type="button" class="btn btn-info btn-circle btn-xsm"></button>
            @elseif($row?->form_user?->user_type == 6)
                <button type="button" class="btn btn-warning btn-circle btn-xsm"></button>
            @else
            @endif
            {{ $row->form_user->name ?? '' }}
        </div>
    @elseif(!empty($type))
        <div class="inmail_tab_list_form">
            @if ($row->user?->user_type == 1)
                <button type="button" class="btn btn-dark btn-circle btn-xsm"></button>
            @elseif($row->user?->user_type == 2)
                <button type="button" class="btn btn-danger btn-circle btn-xsm"></button>
            @elseif($row->user?->user_type == 4)
                <button type="button" class="btn btn-success btn-circle btn-xsm"></button>
            @elseif($row->user?->user_type == 5)
                <button type="button" class="btn btn-info btn-circle btn-xsm"></button>
            @elseif($row->user?->user_type == 6)
                <button type="button" class="btn btn-warning btn-circle btn-xsm"></button>
            @else
            @endif
            {{ $row->user->name ?? '' }}
        </div>
    @endif
    <div class="inmail_tab_list_subject"> {{ $row->subject ?? '' }}</div>
    <div class="inmail_tab_list_date"> {{ changeDateFormat($row->created_at) ?? '' }}</div>
    <div class="inmail_tab_list_full_message mt-3">
        {!! $row->message ?? '' !!}
    </div>

    <div class="inmail_tab_list_files">
        @if(!empty($row->files))
            @foreach($row->files as $key => $file)
                  <a href="javascript:void(0)" class="file_list badge mr-1 badge-primary" onclick="fileIframeModel('{{ url('public/uploads/'.$file->file_name) }}')">
                        {{ $file->original_name ?? '' }}
                  </a>
            @endforeach
        @endif
    </div>
</div>

@includeWhen(!empty($row?->reply_mail), "company.in-mail.reply-mail-row", ['data' => $row?->reply_mail])
