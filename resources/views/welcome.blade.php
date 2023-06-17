<x-app-layout :class="['datepicker']">
    <x-jet-form-section  class="validationForm" novalidate  method="post">
        @slot('form')			
		<table class="table table-bordered table-hover">
				<tr>
					<td colspan="2">Total pure premium: $2,60000 Total Premium (incl. Fees):$302,225</td>
				</tr>
				<tr>
					<td class="w-50">
						<div class="form-group row">					
							<label for="tin" class="col-sm-6 col-form-label ">@lang('labels.billing_schedule')</label>
							<div class="col-sm-6">
								<x-jet-input type="text" name="billing_schedule"/>
							</div>
						</div>	
						<div class="form-group row">					
							<label for="tin" class="col-sm-6 col-form-label ">@lang('labels.number_of_payments')</label>
							<div class="col-sm-6">
								<x-jet-input type="text"  name="number_of_Payments"  />
							</div>
						</div>	
						<div class="form-group row">					
							<label for="tin" class="col-sm-6 col-form-label ">@lang('labels.total_down_payment')</label>
							<div class="col-sm-6">
								<x-jet-input type="text"  name="total_down_payment"  />
							</div>
						</div>	
						<div class="form-group row">					
							<label for="tin" class="col-sm-6 col-form-label ">@lang('labels.setup_fee_in_down_payment')</label>
							<div class="col-sm-6">
								<x-jet-input type="text"  name="setup_fee_in_down_payment"  />
							</div>
						</div>	
						<div class="form-group row">					
							<label for="tin" class="col-sm-6 col-form-label ">@lang('labels.inception_date')</label>
							<div class="col-sm-6">
								<x-jet-input type="text"  name="inception_date"  />
							</div>
						</div>	
						<div class="form-group row">					
							<label for="tin" class="col-sm-6 col-form-label ">@lang('labels.first_payment_due_date')</label>
							<div class="col-sm-6">
								<x-jet-input type="text"  name="first_payment_due_date"  />
							</div>
						</div>	
						<div class="form-group row">					
							<label for="tin" class="col-sm-6 col-form-label ">@lang('labels.interest_rate')</label>
							<div class="col-sm-6">
								<x-jet-input type="text"  name="interest_rate"  />
							</div>
						</div>	
					</td>
					<td class="w-50">
						<div class="form-group row">					
							<label for="tin" class="col-sm-12 col-form-label ">@lang('labels.account_summary')</label>
							</div>	
						<div class="row">					
							<label for="tin" class="col-sm-7 col-form-label">@lang('labels.payment_amount')</label>
							<span class="col-sm-5">11.95%</span>
						</div>	
						<div class="row">					
							<label for="tin" class="col-sm-7 col-form-label">@lang('labels.effective_apr')</label>
							<span class="col-sm-5">10</span>
						</div>	
						<div class="row">					
							<label for="tin" class="col-sm-7 col-form-label">@lang('labels.number_of_payments')</label>
							<span class="col-sm-5">$21,681.71</span>
						</div>	
						<div class="row">					
							<label for="tin" class="col-sm-4 col-form-label">@lang('labels.amount_financed')</label>
							<span class="col-sm-6">$21,681.71</span>
						</div>	
						<div class="row">					
							<label for="tin" class="col-sm-4 col-form-label">@lang('labels.doc_stamp_fee')</label>
							<span class="col-sm-6">$0.00</span>
						</div>	
						<div class="row">					
							<label for="tin" class="col-sm-7 col-form-label">@lang('labels.finance_charge')</label>
							<span class="col-sm-5">$11,417.71</span>
						</div>	
						<div class="row">					
							<label for="tin" class="col-sm-7 col-form-label">@lang('labels.interest')</label>
							<span class="col-sm-5">$21,681.71</span>
						</div>	
						<div class="row">					
							<label for="tin" class="col-sm-4 col-form-label">@lang('labels.setup_fee_unpaid')</label>
							<span class="col-sm-6">$11,417</span>
						</div>							
					</td>
				</tr>
		</table>
            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>

