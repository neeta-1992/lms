  <x-bootstrap-table :data="[
      'table' => 'quotes',
      'id'    => 'general-agents-quotes',
      'cookieid' => true,
      'sortorder' => 'desc',
      'sortname' => 'created_at',
      'type' => 'serversides',
      'ajaxUrl' =>'',
  ]">
      <thead>
          <tr>
              <th class="align-middle" data-sortable="false" data-field="id">
                  @lang('labels.quote')
              </th>
              <th class="align-middle" data-sortable="false" data-field="created_at">
                 @lang('labels.created_date')
              </th>
              <th class="align-middle" data-sortable="false" data-field="updated_at">
                 @lang('labels.last_modified')</th>
              <th class="align-middle" data-sortable="false" data-field="name"> @lang('labels.insured_name')
              </th>
              <th class="align-middle" data-sortable="false" data-field="name"> @lang('labels.account_type')
              </th>
              <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.quote_type')
              </th>
              <th class="align-middle" data-sortable="false" data-field="name"> @lang('labels.pure_premium')
              </th>
              <th class="align-middle" data-sortable="false" data-field="name"> @lang('labels.total')
              </th>
          </tr>
      </thead>
  </x-bootstrap-table>
