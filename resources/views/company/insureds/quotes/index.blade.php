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
                  Quote #
              </th>
              <th class="align-middle" data-sortable="false" data-field="created_at">
                  Created Date
              </th>
              <th class="align-middle" data-sortable="false" data-field="updated_at">
                  Last
                  Modified </th>
              <th class="align-middle" data-sortable="false" data-field="name"> Insured Name
              </th>
              <th class="align-middle" data-sortable="false" data-field="name"> Account Type
              </th>
              <th class="align-middle" data-sortable="false" data-field="name"> Quote Type
              </th>
              <th class="align-middle" data-sortable="false" data-field="name"> Pure Premium
              </th>
              <th class="align-middle" data-sortable="false" data-field="name"> Total
              </th>
          </tr>
      </thead>
  </x-bootstrap-table>
