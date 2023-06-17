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
                 Created Date
             </th>
             <th class="align-middle" data-sortable="false" data-field="updated_at">
                 Last
                 Modified </th>
             <th class="align-middle" data-sortable="false" data-field="name">User Name
             </th>
             <th class="align-middle" data-sortable="false" data-field="name"> Subject
             </th>
             <th class="align-middle" data-sortable="false" data-field="name">Description
             </th>
             <th class="align-middle" data-sortable="false" data-field="name"> Action
             </th>

         </tr>
     </thead>
 </x-bootstrap-table>
