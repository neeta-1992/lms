 <div class="alert aler-white pl-0">
     <b> @lang('labels.account_suspend_message_text') </b>
 </div>
 <x-form class="validationForm" novalidate method="POST" action="{{ routeCheck($route.'suspend-account',$data?->id) }}">



     <div class="tab-one">
         <div class="form-group row">
             <label for="days" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.days_to_suspend')</label>
             <div class="col-sm-4">
                 <x-jet-input  type="text" name="days" class="digitLimit" data-limit="3" maxlength="3" required />
             </div>
             <div class="col-sm-5">
                 @lang('labels.note_use_suspend_indefinitely')
             </div>
         </div>

         <div class="form-group row">
             <label for="reason" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.reason")</label>
             <div class="col-sm-9">
                 <textarea name="reason" id="reason" cols="30" class="form-control" rows="3" required></textarea>
             </div>
         </div>




         <x-button-group class="saveData" xclick="open = 'account_information'" />
     </div>
 </x-form>
