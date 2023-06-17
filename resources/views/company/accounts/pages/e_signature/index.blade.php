<x-table id="{{ $activePage ?? '' }}-esignature" ajaxUrl="{{ routeCheck('company.quotes.esignature_logs',['quoteId'=>$data->quote]) }}&versionId={{ $data->version }}">
    <thead>
        <tr class="bg-white">
            <th class="" colspan="5">
                <div class="siganturelogshtml">
                    <div class="text-left mb-4"><b>Signature Certificate</b></div>
                    <div>Document Name: Finance Agreement</div>
                    <div><i class="fa-solid fa-lock"></i> Unique Document ID: <span style="text-transform:uppercase;" class="versionsigdocumentid"></span></div>
                    <div class="row signaturehtml mt-2 mb-2">
                        <div class="col-md-2">Parties</div>
                        <div class="col-md-10">Status</div>
                        <div class="col-md-2">{{ $data?->agency_data?->name ?? '' }}</div>
                        <div class="col-md-10 versionsigagentstatus"></div>
                        <div class="col-md-2">{{ $data?->insur_data?->name ?? '' }}</div>
                         <div class="col-md-10 versionsiginsuredstatus"></div>
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th class="align-middle" data-sortable="true" data-field="created_at"> @lang('labels.timestamp')</th>
            <th class="align-middle" data-sortable="true" data-field="ip">@lang('labels.ip_address')</th>
            <th class="align-middle" data-sortable="true" data-field="action"> @lang('labels.action')</th>
            <th class="align-middle" data-sortable="true" data-field="ip_location"> @lang('labels.ip_location')</th>
            <th class="align-middle" data-sortable="true" data-field="description"> @lang('labels.description')</th>
        </tr>
    </thead>
</x-table>
