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
                @lang('labels.account')
             </th>
             <th class="align-middle" data-sortable="false" data-field="created_at">
               @lang('labels.created_date')
             </th>
             <th class="align-middle" data-sortable="false" data-field="updated_at">
                 @lang('labels.last_modified')</th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.insured_name')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.status')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.balance')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.payoff_amount')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.installment_amount')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.next_due_date')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.installment')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.last_payment_date') 
             </th>

         </tr>
     </thead>
 </x-bootstrap-table>
