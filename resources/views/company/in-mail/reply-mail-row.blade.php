@if (!empty($data))
    @foreach ($data as $replykey => $reply)
        <div class="{{ !empty($is_children) ? 'reply_children_box' : 'reply_parent_box' }}">
            <div class="reply_parent_box_list_inner">
                <div class="reply_parent_box_list">
                    <a class="linkButton" x-on:click="replayMail('{{ $reply->id }}')"
                        href="javascript:void(0)">@lang('labels.replay')</a>
                    <a class="linkButton" x-on:click="forwardMail('{{ $reply->id }}')" href="javascript:void(0)">@lang('labels.forward')</a>
                </div>
            </div>
            <div class="inmail_tab_list_heading">

                <div class="inmail_tab_list_form">
                    @if ($reply->form_user?->user_type == 1)
                        <button type="button" class="btn btn-dark btn-circle btn-xsm"></button>
                    @elseif($reply->form_user?->user_type == 2)
                        <button type="button" class="btn btn-danger btn-circle btn-xsm"></button>
                    @elseif($reply->form_user?->user_type == 4)
                        <button type="button" class="btn btn-success btn-circle btn-xsm"></button>
                    @elseif($reply->form_user?->user_type == 5)
                        <button type="button" class="btn btn-info btn-circle btn-xsm"></button>
                    @elseif($reply->form_user?->user_type == 6)
                        <button type="button" class="btn btn-warning btn-circle btn-xsm"></button>
                    @else
                    @endif
                    {{ $reply->form_user->name ?? '' }}
                </div>

                <div class="inmail_tab_list_subject"> {{ $reply->subject ?? '' }}</div>
                <div class="inmail_tab_list_date"> {{ changeDateFormat($reply->created_at) ?? '' }}</div>
                <div class="inmail_tab_list_full_message mt-3">
                    {!! $reply->message ?? '' !!}
                </div>
                <div class="inmail_tab_list_files">
                    @if(!empty($reply->files))
                        @foreach($reply->files as $key => $file)
                            <a href="javascript:void(0)" class="file_list badge mr-1 badge-primary" onclick="fileIframeModel('{{ url('public/uploads/'.$file->file_name) }}')">
                                    {{ $file->original_name ?? '' }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            @if(!empty($reply->children))
                @includeWhen(!empty($reply->children), "company.in-mail.reply-mail-row", ['data' => $reply->children,'is_children'=>true])
            @endif
        </div>


    @endforeach
@endif

