@if (!empty($data))
    @foreach ($data as $key => $row)
        <div class="inmail_tab_list_heading {{ ($row->read == 0 &&  $type == 'inbox' && empty($isDeleted)) ? 'unread' : '' }}">
            <div class="inmail_tab_list_check d-flex">
                <x-jet-checkbox for="sentall_{{ $row->id }}" id="sentall_{{ $row->id }}" labelText=''
                    value="{{ $row->id }}" name="mailbox" class="allsekect permissionCheckBox" />
                @if (empty($drafts) && empty($isDeleted))
                   @if(!empty($type) && $type == 'inbox')
                    <div class="starrating" >
                        <input type="checkbox" id="star_{{ $row->id }}" {{ $row->important == 1 ? 'checked' : '' }}
                            name="rating" value="{{ $row->id }}" @change='importantMail($el)' /><label
                            for="star_{{ $row->id }}" title="important"></label>
                    </div>
                    @elseif(!empty($type) && $type == 'sent')
                    <div class="starrating" >
                        <input type="checkbox" id="star_{{ $row->id }}" {{ $row->sent_important == 1 ? 'checked' : '' }}
                            name="rating" value="{{ $row->id }}" @change='importantMail($el)' /><label
                            for="star_{{ $row->id }}" title="important"></label>
                    </div>
                    @endif
                @elseif (!empty($isDeleted))
                    <a href="javascript:void(0)" class="d-block text-big" data-id="{{ $row->id }}" data-drafts="{{ $drafts ?? false }}"  @click='deleteMail($el)'><i class="fa-thin fa-trash-can"></i></a>
                @endif
            </div>
            @if (!empty($drafts))
                <div class="inmail_tab_list_form" x-on:click="mailDetails('{{ $row->id }}','{{ $type ?? '' }}')"> {{ $row->to_name ?? '' }}</div>
            @elseif(!empty($inbox))
            <div class="inmail_tab_list_form" x-on:click="mailDetails('{{ $row->id }}','{{ $type ?? '' }}')">
                    @if ($row->form_user?->user_type == 1)
                        <button type="button" class="btn btn-dark btn-circle btn-xsm"></button>
                    @elseif($row->form_user?->user_type == 2)
                        <button type="button" class="btn btn-danger btn-circle btn-xsm"></button>
                    @elseif($row->form_user?->user_type == 4)
                        <button type="button" class="btn btn-success btn-circle btn-xsm"></button>
                    @elseif($row->form_user?->user_type == 5)
                        <button type="button" class="btn btn-info btn-circle btn-xsm"></button>
                    @elseif($row->form_user?->user_type == 6)
                        <button type="button" class="btn btn-warning btn-circle btn-xsm"></button>
                    @else
                    @endif
                {{ $row->form_user->name ?? '' }}
            </div>
            @elseif(empty($inbox))
                <div class="inmail_tab_list_form" x-on:click="mailDetails('{{ $row->id }}','{{ $type ?? '' }}')">
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
            <div class="inmail_tab_list_subject" x-on:click="mailDetails('{{ $row->id }}','{{ $type ?? '' }}')"> {{ $row->subject ?? '' }}</div>
            <div class="inmail_tab_list_date" x-on:click="mailDetails('{{ $row->id }}','{{ $type ?? '' }}')"> {{ changeDateFormat($row->created_at) ?? '' }}</div>
        </div>
    @endforeach
@endif
