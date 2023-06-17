 <x-bootstrap-table :data="[
     'table' => 'accounts',
     'id' => 'general-agents-accounts',
     'cookieid' => true,
     'sortorder' => 'desc',
     'sortname' => 'created_at',
     'type' => 'serversides',
     'ajaxUrl' => '',
 ]">
     <thead>
         <tr>
             <th class="align-middle" data-sortable="false" data-field="id">
                 Account #
             </th>
             <th class="align-middle" data-sortable="false" data-field="created_at">
                 Created Date
             </th>
             <th class="align-middle" data-sortable="false" data-field="updated_at">
                 Last
                 Modified </th>
             <th class="align-middle" data-sortable="false" data-field="name">Insured Name
             </th>
             <th class="align-middle" data-sortable="false" data-field="name"> Status
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">Balance Due
             </th>
             <th class="align-middle" data-sortable="false" data-field="name"> Payoff Amount
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">Installment Amount
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">Next Due Date
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">Installment #
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">Last Payment Date
             </th>

         </tr>
     </thead>
 </x-bootstrap-table>
