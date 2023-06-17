   <div class="">
       <table class="table mb-4">
           <tr>
               <td>
                   <b>Agent Information</b><br />
                   <a class="linkButton" href="{{ routeCheck('company.agents.edit',encryptUrl($data?->agency_data->id ?? 'null')) }}">{{ !empty($data?->agency_data->name) ? ucfirst($data?->agency_data->name) : '' }}</a> <br>
                   {{ $data?->agent_user->name ??  '' }} <br>
                   {{ $data?->agent_user->email ??  '' }} <br>
                   {{ $data?->agent_user->mobile ??  '' }} <br>
                   {{ $data?->agency_data->address ??  '' }} <br> {{ $data?->agency_data->city ??  '' }} , {{ $data?->agency_data->state ??  '' }} {{ $data?->agency_data->zip ??  '' }}
               </td>
               <td>
                   <b>Insured Information</b><br />
                   <a class="linkButton" href="{{ routeCheck('company.insureds.edit',encryptUrl($data?->insur_data->id ?? 'null')) }}">{{ !empty($data?->insur_data->name) ? ucfirst($data?->insur_data->name) : '' }}</a> <br>
                   {{ $data?->insured_user->name ??  '' }} <br>
                   {{ $data?->insured_user->email ??  '' }} <br>
                   {{ $data?->insured_user->mobile ??  '' }} <br>
                   {{ $data?->insur_data->address ??  '' }} <br> {{ $data?->insur_data->city ??  '' }} , {{ $data?->insur_data->state ??  '' }} {{ $data?->insur_data->zip ??  '' }}
               </td>
           </tr>
       </table>
   </div>

   <div class="viewAccountDetails">
        @includeIf('company.accounts.pages.view-account',['data'=>$data])
   </div>
