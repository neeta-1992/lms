 <x-form class="validationForm" novalidate method="POST" >
    


      <div class="tab-one">
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.manual_status_change')</label>
             <div class="col-sm-9">
                   <x-select :options="['1'=>'Move to Cancel','2'=>'Move to Closed','3'=>'Cancel RP']" name="manualstatus" class="ui dropdown w-50"   />
             </div>
         </div>
     
         <div class="form-group row">
             <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.note")</label>
             <div class="col-sm-9">
                 <textarea name="note" id="note" cols="30" class="form-control" rows="3" required></textarea>
             </div>
         </div>

        


         <x-button-group class="saveData" xclick="open = 'account_information'"/>
     </div>
 </x-form>
