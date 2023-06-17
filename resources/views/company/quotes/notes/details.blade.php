@php
$currentStatus = !empty($data['current_status']) ? $data['current_status'] : 0;
@endphp
<div class="col-md-12 page_table_menu">
    <div class="row ">

        <div class="col-md-12">
            <div class="row align-items-end">
                <div class="col-md-12">
                    <div class="columns d-flex justify-content-end">
                        <button class="btn btn-default" type="button" x-on:click="notesFn('quote-notes-edit/{{ $id }}','edit')">
                            @lang('labels.append')</button>
                        <button class="btn btn-default " type="button"  x-on:click="open = (open == 'notes' ? 'notesList' : 'notes')">@lang('labels.cancel')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12">
    <table class="table">

        <tbody>


            <tr>
                <td>@lang('labels.created_by')</td>
                <td> {{ $data->created_by->name ?? '' }}</td>
            </tr>

            <tr>
                <td>@lang('labels.subject')</td>
                <td> {{ $data->subject ?? '' }}</td>
            </tr>
            <tr>
                <td>@lang('labels.description')</td>
                <td> {{ $data->description ?? '' }}</td>
            </tr>
            <tr>
                <td>@lang('labels.files')</td>
                <td>
                    @php
                    $files = !empty( $data->files) ? explode(',',$data->files) : '' ;
                    @endphp
                    @if(!empty($files))
                    <ul class="preview_box list-group">
                        @foreach($files as $key => $value)
                        <li class="list-group-item">
                            <div class="flow-progress media">
                                <div class="media-body">
                                    <div>
                                        <strong class="flow-file-name">{{ $value ?? '' }}</strong>
                                        <a class="open_popup" title="Click to view"  onclick="fileIframeModel('{{ asset('uploads/'.$value) }}')"
                                            href="javascript:void(0);"><i class="fa-solid fa-file-pdf newiconcolor"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </td>
            </tr>

        </tbody>
    </table>



</div>


<div class="col-md-12">

    <x-table id="{{ $activePage ?? '' }}-notes-append-list" ajaxUrl="{{ routeCheck($route.'viewList',['qId'=>$qId,'vId'=>$vId,'parentId'=>(!empty($data->parent_id) ? $data->parent_id : $data->id)]) }}">
        <thead>
            <tr>
                <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">@lang("labels.created_date")</th>
                <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">@lang("labels.last_update_date")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="username">@lang("labels.username")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="subject">@lang("labels.subject")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="description">@lang("labels.description")</th>
            </tr>
        </thead>
       <tbody>

       </tbody>
    </x-table>


</div>


