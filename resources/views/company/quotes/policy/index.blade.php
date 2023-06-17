<div class="policyList">
    <div class="row align-items-end page_table_menu">
        <div class="col-md-12">
            <div class="row align-items-end">
                <div class="col-md-12">
                    <div class="columns d-flex justify-content-end ">
                        @if(!empty($data?->toArray()))
                            <button class="btn btn-default borderless collapse_all" type="button">@lang('labels.collapse_all')</button>
                            <button class="btn btn-default borderless expand_all" type="button">@lang('labels.expand_all')</button>
                        @endif
                        
                        @if($quoteData->status != 6)
                            @if($quoteData->status != 2)
                                <button class="btn btn-default borderless" type="button" x-on:click="open = 'addPolicy'">@lang('labels.add') @lang("labels.policy")</button>
                            @endif
                        @endif
                       
                        <button class="btn btn-default borderless" type="button" x-on:click="open = 'terms'">@lang('labels.terms')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!empty($data))
        @foreach($data as $key => $row)
            <table id="{{ $activePage }}-policy-list" class="table mb-1">
                <thead>
                    <tr>
                        <td class="policyDetails" data-id="{{  $row->id ?? '' }}"> <i class="fa-solid fa-caret-right"></i> </td>
                        <td> @lang("labels.coverage_type") <span class='d-block fw-400'>{{ $row->coverage_type_data?->name }}</span></td>
                        <td> @lang('labels.insurance_company') <span class='d-block fw-400'>{{ $row->insurance_company_data?->name }}</span></td>
                        <td> @lang('labels.general_agent') <span class='d-block fw-400'>{{ $row->general_agent_data?->name }}</span></td>
                        <td> @lang('labels.premium') <span class='d-block fw-400'>@money($row->pure_premium ?? 0)</span></td>
                        <td> @lang('labels.unearned_fee') <span class='d-block fw-400'>@money($row->unearned_fees ?? 0)</span></td>
                        <td> @lang('labels.earned_fee') <span class='d-block fw-400'>@money($row->earned_fees ?? 0)</span></td>
                        <td> @lang('labels.total') <span class='d-block fw-400'>@money($row->total ?? 0)</span></td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        @endforeach
    @endif

</div>
