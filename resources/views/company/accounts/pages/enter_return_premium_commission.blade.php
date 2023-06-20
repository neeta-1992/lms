<div class="alert aler-white pl-0">
  <b> Return Premium for Account # {{ $data->account_number ?? '' }}</b>
</div>
<x-form class="validationForm" novalidate method="POST" >
    


      <div class="tab-one">
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.insurance_policy_coverage_type')</label>
             <div class="col-sm-9">
                   <x-select :options="[]" name="policy" class="ui dropdown w-50"   />
             </div>
         </div>
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.return_premium_from')</label>
             <div class="col-sm-9">
                   <x-select :options="[]" name="return_premium_from" class="ui dropdown w-50"   />
             </div>
         </div>
     
        
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label ">@lang('labels.account_balance')</label>
             <div class="col-sm-9">
                  
             </div>
         </div>
          <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.how_to_apply_payment')</label>
             <div class="col-sm-9">
                   <x-select :options="[
                    'allow_active_spread_RP'=>'Active Spread (Spread and Recalculate)',
                    ]" name="apply_payment" class="ui dropdown w-50"   />
             </div>
         </div>
          <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.payment_method')</label>
             <div class="col-sm-9">
                   <x-select :options="[]" name="payment_method" class="ui dropdown w-50"   />
             </div>
         </div>
          <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.amount_paid')</label>
             <div class="col-sm-9">
                   <x-select :options="[]" name="amount_paid" class="ui dropdown w-50"   />
             </div>
         </div>
          <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.deposit_to_bank_account')</label>
             <div class="col-sm-9">
                   <x-select :options="[]" name="bank_account" class="ui dropdown w-50"   />
             </div>
         </div>
     
       

        


         <x-button-group class="saveData" xclick="open = 'account_information'"/>
     </div>
 </x-form>
