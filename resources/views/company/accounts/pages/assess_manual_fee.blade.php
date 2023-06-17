<div class="alert aler-white pl-0">
  <b> Assess Fees for Account # {{ $data->account_number ?? '' }}</b>
</div>
<x-form class="validationForm" novalidate method="POST" action="{{ routeCheck('company.accounts.save-assess-manual-fee',$data->id) }}"  >
    


      <div class="tab-one">
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.fees')</label>
             <div class="col-sm-9">
                   <x-select required :options="['Late Fee'=>'Late Fee','NSF Fee'=>'NSF Fee','Cancel Fee'=>'Cancel Fee','Convenience Fee'=>'Convenience Fee']" name="fees" class="ui dropdown w-50" placeholder="Select"  />
             </div>
         </div>
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.amount')</label>
             <div class="col-sm-9">
                   <x-jet-input  name="amount" class="amount"  required  />
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
