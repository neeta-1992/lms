{{--  <div class="alert aler-white pl-0">
    <b> Return Premium for Account # {{ $account_number ?? '' }}</b>
</div>  --}}
<x-form class="validationForm enterReturnPremiumCommissionForm" novalidate method="POST" action="{{ routeCheck($route.'enter-return-premium-sava') }}">

      
     <x-jet-input type="hidden" name="account_id" value="{{ $accountId }}" />
   
    <div class="tab-one">
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.insurance_policy_coverage_type')</label>
            <div class="col-sm-9">
                <x-select :options="$quotePolicyOption ?? []" name="policy" required
                    class="ui dropdown w-50 insurance_policy_coverage_type" placeholder="Select Option" />
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.return_premium_from')</label>
            <div class="col-sm-9">
                <x-select :options="[]" name="return_premium_from" required
                    class="ui dropdown w-50 return_premium_from" placeholder="Select Option" />
            </div>
        </div>


        <div class="form-group row agent_commision_none_fields"> 
            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.account_balance')</label>
            <div class="col-sm-9">
               <x-jet-input class="amount"  value="{{ ($balance ?? 0) }}" disabled /> 
            </div>
        </div>
        <div class="form-group row" >
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.how_to_apply_payment')</label>
            <div class="col-sm-9">
                <x-select  :options="$applyPaymentOption ?? []" name="apply_payment" class="ui dropdown w-50 selectDataTabs" required
                    placeholder="Select Option" />
            </div>
        </div>
         <div class="form-group row d-none agent_return_commission_due_div" >
            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.agent_return_commission_due')</label>
            <div class="col-sm-9">
              <x-jet-input class="amount"  value="0" disabled /> 
            
            </div>
        </div>
        <div class="form-group row"  >
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.payment_method')</label>
            <div class="col-sm-9">
                <x-select :options="['Check' => 'Check', 'eCheck' => 'eCheck']" name="payment_method" class="ui dropdown selectDataTabs w-50" required
                    placeholder="Select Option" />
            </div>
        </div>
        

        <div class="form-group row d-none"  data-name="payment_method" data-stab="check">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.check_number')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="check_number" class='required' />
            </div>
        </div>
        <div class="form-group row  d-none"  data-name="payment_method" data-stab="echeck">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.account_holder_name')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="account_holder_name" class='required' />
            </div>
        </div>
        <div class="form-group row d-none"  data-name="payment_method" data-stab="echeck">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.bank_name')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="bank_name" class='required' />
            </div>
        </div>
        <div class="form-group row d-none"  data-name="payment_method" data-stab="echeck">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.bank_details')</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-md-6">
                        <x-jet-input type="text" name="bank_name" class='required digitLimit' data-limit="14"
                            maxlength="14" placeholder="{{ __('labels.bank_routing_number') }}" />
                    </div>
                    <div class="col-md-6">
                        <x-jet-input type="text" name="account_number" class='required digitLimit' data-limit="14"
                            maxlength="14" placeholder="{{ __('labels.bank_account_number') }}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.amount_paid')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" class="amount" name="amount_paid" required />
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.deposit_to_bank_account')</label>
            <div class="col-sm-9">
                <x-select :options="$bankAccount ?? []" name="bank_account" class="ui dropdown w-50" />
            </div>
        </div>

        <div class="form-group row">
            <label for="print_rp_notices" class="col-sm-3 col-form-label ">@lang('labels.print_rp_notices')</label>
            <div class="col-sm-9">
                <x-jet-checkbox name="print_rp_notices" value="Yes" id="print_rp_notices" />
            </div>
        </div>
        <div class="form-group row" data-name="apply_payment" data-stab="allow_active_spread_rp">
            <label for="reduce_remaining_interest" class="col-sm-3 col-form-label ">@lang('labels.reduce_remaining_interest')</label>
            <div class="col-sm-9">
                <x-jet-checkbox name="reduce_remaining_interest" value="Yes" id="reduce_remaining_interest"
                    labelText="{{ __('labels.reduce_remaining_interest_leable_text') }}" />
            </div>
        </div>
        <div class="form-group row d-none" data-name="apply_payment" data-stab="allow_active_spread_rp">
            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.first_payment_due_date_text')</label>
            <div class="col-sm-9">
                <x-select :options="$quoteAccountExposure ?? []" name="first_payment_due_date" class="ui dropdown w-50" :is_date_format="true" />
            </div>
        </div>
        <div class="form-group row d-none"  data-name="apply_payment" data-stabs="allow_cancel_rp_net">
            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.agent_commission_due')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" class="amount" name="agent_commission_due"  />
            </div>
        </div>

        <x-button-group class="saveData" xclick="open = 'account_information'" />
    </div>
</x-form>
