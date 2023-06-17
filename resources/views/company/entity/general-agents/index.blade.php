<x-app-layout>
    <x-jet-action-section x-data="index">
        <x-slot name="title">
            {{ $pageTitle ??  dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('uiDropDwon')
           
                <div class="ui selection dropdown table-head-dropdown maindropdown">
                    <input type="hidden" x-bind:value=tab /><i class="dropdown icon"></i>
                    <div class="text">@lang('labels.active') {{ $pageTitle ?? '' }}</div>
                    <div class="menu">
                        <div class="item" x-on:click="tab = 'active';initTable()" x-show="tab != 'active'">@lang('labels.active') {{ $pageTitle ?? '' }}</div>
                        <div class="item" x-on:click="tab = 'temporary';initTable()" x-show="tab != 'temporary'">@lang('labels.temporary') {{ $pageTitle ?? '' }}</div>
                    
                    </div>
                </div>
            @endslot
        
            @slot('content')
                <x-table id="{{ $activePage ?? '' }}"  >
                    <thead>
                        <tr>
                              <th class="align-middle" data-width="170" data-sortable="true" data-field="created_at">@lang('labels.created_date')</th>
                            <th class="align-middle" data-width="170"  data-sortable="true" data-field="updated_at">@lang('labels.last_modified')</th>
                            <th class="align-middle"  data-sortable="true" data-width="" data-field="name">@lang('labels.name')</th>
                        

                        </tr>
                    </thead>
                </x-table>
            @endslot
    </x-jet-action-section>
    <!--/.section-->
    @push('page_script_code')
        <script>
            document.addEventListener("alpine:init", () => {
                Alpine.data("index", () => ({
                    tab: 'active',
                    title: '',
                    init() {
                        this.initTable()
                    },
                    initTable() {
                        $('#{{ $activePage ??  '' }}').bootstrapTable('destroy')
                            .bootstrapTable({
                                url: "{{ routeCheck($route . 'index') }}?tab=" + this.tab
                            });
                    }


                }));
            });
        </script>
    @endpush 
</x-app-layout>
