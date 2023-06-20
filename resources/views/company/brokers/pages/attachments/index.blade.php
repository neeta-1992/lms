 <x-bootstrap-table :data="[
     'table' => 'attachments',
      'id' => 'general-agents-attachments',
     'cookieid' => true,
     'sortorder' => 'desc',
     'sortname' => 'created_at',
     'type' => 'serversides',
       'ajaxUrl' => '' ,
 ]">
     <thead>
         <tr>

             <th class="align-middle" data-sortable="false" data-field="created_at">
                 @lang('labels.created_date')
             </th>
             <th class="align-middle" data-sortable="false" data-field="updated_at">
                @lang('labels.last_modified')</th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.user_name')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name"> @lang('labels.subject')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">@lang('labels.description')
             </th>
             <th class="align-middle" data-sortable="false" data-field="name"> @lang('labels.action')
             </th>

         </tr>
     </thead>
 </x-bootstrap-table>
