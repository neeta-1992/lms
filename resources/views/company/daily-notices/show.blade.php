<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ $pageTitle ??  dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
        <div class="table-responsive-sm">
            <x-table id="{{ $activePage ?? '' }}-list" ajaxUrl="{{ routeCheck($route.'show',$type) }}">
                <thead>
                    <tr>
                        <th class="text-left" data-checkbox="true" data-width="20"></th>
                        <th class="align-middle" data-field="created_at" data-width="100">@lang('labels.created_date')</th>
                        <th class="align-middle" data-field="account_number" data-width="50">@lang('labels.account_number')</th>
                        <th class="align-middle" data-field="insured_name" data-width="100">@lang('labels.insured_name')</th>
                        <th class="align-middle" data-field="notice" data-width="400">@lang('labels.notice') @lang('labels.name')</th>
                        <th class="align-middle" data-field="send_to" data-width="100">@lang('labels.send_to')</th>
                        <th class="align-middle" data-field="status" data-width="100">@lang('labels.status')</th>
                    </tr>
                </thead>
            </x-table>
        </div>
        <div class="remodal" data-remodal-id="dailyNoticeModel">
            <button class="remodal-close" data-remodal-action="close"></button>
 
            <div class=" d-flex justify-content-end pr-2">
                <a class="processNotices mx-1 linkButton {{ $type == 'fax' ? 'd-none' : ''  }}" href="javascript:void(0)" id="process_notices" ><i class="fal fa-send"></i>@lang('labels.process_notices')</a>
                <div class="createdPrint mx-1  {{ $type != 'fax' ? 'd-none' : ''  }}" id="disclosureprint" data-content=".template_section" title=""><i class="fal fa-print"></i></div>
                <div class="windowpop_close mx-1" data-remodal-action="close"><i class="fa-regular fa-circle-xmark"></i></div>
            </div>
            <div class="template_section text-left" style="overflow: auto;  height: 400px;"></div>
        </div>
        @endslot
    </x-jet-action-section>
    @push('page_script')
    <script>
        const activePage = "{{ $activePage ?? '' }}"; 
        const noticeType = "{{ $type ?? '' }}"; 
    </script>
    @endpush
    <!--/.section-->


</x-app-layout>
