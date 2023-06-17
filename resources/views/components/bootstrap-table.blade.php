<div class="table-responsive-sm">
     @php
       $otherArr =[];
       $typeTable = isset($data['table']) ? $data['table'] : '';
       $dataIdAttr = isset($data['id']) ? $data['id'] : '';
       if($typeTable == 'logs'){
           $id = "{$activePage}-logs";
       }else{
           $id = $activePage;
       }
       $id = !empty($dataIdAttr) ? $dataIdAttr : $id ;
       $otherButton = !empty($otherButton) ? $otherButton : "";
       if(!empty($otherButton)){
         $otherArr[$id] = $otherButton;
       }

     @endphp

    <table
        data-toggle="table"
        data-icons-prefix="fa-regular"
        data-loading-template="loadingTemplate"
        data-buttons-class="default borderless"
        data-buttons="buttons"
        data-show-refresh="{{ !empty($icons[$id]['Refresh']['status']) ? true : false }}"
        data-show-columns="{{ !empty($icons[$id]['Column']['status']) ? true : false }}"
       {{--  data-auto-refresh-status="true" --}}
        data-show-button-text="true"
        data-show-export="{{ !empty($icons[$id]['export']['status']) ? true : false }}"
        data-icons="icons"
        id="{{ $id ?? '' }}"
        @if(!empty($data['cookieid']))
            data-cookie="true"
            data-cookie-id-table="{{ $id ?? '' }}"
        @endif
        data-search="{{ !empty($icons[$id]['Search']['status']) ? true : false }}"
        data-sort-name="{{ $data['sortname'] ?? '' }}"
        data-sort-order="{{ $data['sortorder'] ?? '' }}"
        data-pagination="true"
        data-page-list="[25, 50, 100, ALL]"
        data-page-size="25"
        @if(!empty($data['type']) && $data['type']=='serverside' )
            data-side-pagination="server"
        @endif
        @if(!empty($data['ajax']))
            data-ajax="{{ $data['ajax'] ?? '' }}"
        @endif @if(!empty($data['ajaxUrl']))
            data-url="{{ $data['ajaxUrl'] ?? '' }}"
        @endif

        data-other="{{ !empty($otherArr) ? json_encode($otherArr) : '' }}">

        {{-- Table Html Body Append --}}
        {{ $slot ?? '' }}
    </table>

</div>


