@props(['ajaxUrl','ajaxFunction','queryParams','sortname','sortorder','noToggle','pagination'=>true])

<div class="table-responsive-sm">
    <table
           @if(!$attributes->has('id'))
               id = "{{  activePageName() }}"
           @endif

           @empty($noToggle)
            data-table="bootstrap-table"
           @endempty
          
           data-icons-prefix="fa-thin"
           data-loading-template="loadingTemplate"
           data-buttons-class="default borderless"
           data-pagination="{{ $pagination ?? 'true' }}"
           data-page-list="[25, 50, 100, ALL]"
           data-page-size="25"
           data-buttons="buttons"
           data-side-pagination="server"
           data-cookie="true"
           data-auto-refresh-status="true"
           data-show-button-text="1"
           data-ajax-options="ajaxOptions"
           data-sort-name="{{ $sortname ?? 'created_at' }}"
           data-sort-order="{{ $sortorder ?? 'desc' }}"
           data-cookie-id-table="{{ $attributes->get('id') ??  activePageName() }}"
           @if(!empty($ajaxFunction))
                data-ajax="{{ $ajaxFunction ?? '' }}"
           @endif
           @if(!empty($queryParams))
                data-query-params="{{ $queryParams ?? '' }}"
           @endif
            @if(!empty($ajaxUrl))
                data-url="{{ $ajaxUrl }}"
           @endif
           {{ $attributes->merge(['class'=>'table table-bordered table-hover']) }}>

        {{-- Table Html Body Append --}}
        {{ $slot ?? '' }}
    </table>
</div>
