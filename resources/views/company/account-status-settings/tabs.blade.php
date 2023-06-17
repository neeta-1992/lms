<x-app-layout>
    <x-jet-form-section :title="$pageTitle" :buttonGroup="['logs', 'other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'show',[$id])]]]" class="validationForm singleForm" novalidate
        action="{{ routeCheck($route . 'store') }}" method="post">
        @slot('form')

          <input type="hidden" name="state_id" value="{{ $id }}">
            @if (file_exists(resource_path("views/company/account-status-settings/{$tab}.blade.php")))
                @includeIf('company.account-status-settings.' . $tab,['id'=>$id])
            @else
             @php
                 abort(404)
             @endphp
            @endif

        @endslot
        @slot('logContent')
            <x-bootstrap-table :data="[
                'table' => 'logs',
                'cookieid' => true,
                'sortorder' => 'desc',
                'sortname' => 'created_at',
                'type' => 'serversides',
                'ajaxUrl' => routeCheck('company.logs', ['type' => activePageName(), 'id' => $id]),
            ]">
                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">
                            User Name
                        </th>
                        <th class="" data-sortable="true" data-field="message">Description</th>
                    </tr>
                </thead>
            </x-bootstrap-table>
        @endslot
    </x-jet-form-section>

      @push('page_script')
        <script>
            let editArr = @json($data ?? []);

        </script>
    @endpush
</x-app-layout>
