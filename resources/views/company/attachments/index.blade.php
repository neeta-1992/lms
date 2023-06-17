
@empty($attachment)
<x-table id="{{ $activePage ?? '' }}-attachments" ajaxUrl="{{ routeCheck('company.attachments.index') }}?typeId={{ $entityId ?? '' }}&type={{ $type ?? '' }}">
    <thead>
        <tr>
            <th class="align-middle" data-sortable="true" data-field="created_at">Created Date</th>
            <th class="align-middle" data-sortable="true" data-field="updated_at">Last Modified </th>
            <th class="align-middle" data-sortable="true" data-field="user_name">User Name</th>
            <th class="align-middle" data-sortable="true" data-field="subject"> Subject</th>
            <th class="align-middle" data-sortable="true" data-field="description">Description</th>
        </tr>
    </thead>
</x-table>
@else
<div class="policyList">
{{--      <div class="row align-items-end page_table_menu">
        <div class="col-md-12">
            <div class="row align-items-end">
                <div class="col-md-12">
                    <div class="columns d-flex justify-content-end ">

                        @if(!empty($attachment?->toArray()))
                            <button class="btn btn-default borderless collapse_all" type="button">@lang('labels.collapse_all')</button>
                            <button class="btn btn-default borderless expand_all" type="button">@lang('labels.expand_all')</button>
                        @endif
                        <button class="btn btn-default borderless" type="button" x-on:click="open = 'uploadAttachment'">@lang('labels.upload_signed_pfa')</button>
                        <button class="btn btn-default borderless" type="button" x-on:click="open = 'uploadAttachment'">@lang('labels.upload_attachment')</button>
                        <button class="btn btn-default borderless" type="button" x-on:click="open = 'quote_information'">@lang('labels.cancel')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}
    @if(!empty($attachment))
        @foreach($attachment as $key => $row)
            <table id="{{ $activePage }}-policy-list" class="table mb-1">
                <thead>
                    <tr>
                        <td class="attachmentDetails" data-id="{{  $row->id ?? '' }}" > <i class="fa-solid fa-caret-right"></i> </td>
                        <td> @lang("labels.created_date") <span class='d-block fw-400'>{{ changeDateFormat($row->created_at) ?? '' }}</span></td>
                        <td> @lang("labels.last_modified") <span class='d-block fw-400'>{{ changeDateFormat($row->updated_at) ?? '' }}</span></td>
                        <td> @lang('labels.user') <span class='d-block fw-400'>{{ decryptData($row?->first_name)." ".decryptData($row?->middle_name)." ".decryptData($row?->last_name)  }}</span></td>
                        <td style="width:260px;"> @lang('labels.subject') <span class='d-block fw-400'>{{ $row->subject ?? '' }}</span></td>
                        <td style="width:190px; word-break: break-all;"> @lang('labels.view') <span class='d-block fw-400'><a href="javascript:void(0)" onclick="fileIframeModel('{{ asset('uploads/'.$row->filename) }}')">{{ $row->original_filename ?? '' }}</a></span></td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        @endforeach
    @endif

</div>

@endempty
