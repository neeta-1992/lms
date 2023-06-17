 <form class="validationForm" novalidate action="{{ routeCheck($route.'.create',$id) }}" method="post">
@csrf
     <input type="hidden" name="entity_id" value="{{ $id ?? '' }}">
     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="name" required />
         </div>
     </div>
     <div class="form-group row">
         <label for="description" class="col-sm-3 col-form-label ">@lang('labels.description')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="description"  />
         </div>
     </div>
                <div class="row">
                <label for="payment_coupons_address"
                    class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.physical_address')</label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <x-jet-input type="text" name="address" required />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-jet-input type="text" name="city" required placeholder="City" />

                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('state', stateDropDown(), '', [
                                'class' => 'ui dropdown input-sm w-100',
                                'required' => true,'placeholder'=>'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="zip" class="zip_mask" required   placeholder="Zip"/>

                        </div>
                    </div>
                </div>
            </div>



            <div class="row mailing_address_box">
                <label for="mailing_address" class="col-sm-3 col-form-label ">@lang('labels.mailing_address')</label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <x-jet-input type="text" name="mailing_address" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-jet-input type="text" name="mailing_city" placeholder="City" />

                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('mailing_state', stateDropDown(), '', [
                                'class' => 'ui dropdown
                                 input-sm w-100','placeholder'=>'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask" placeholder="Zip" />

                        </div>
                    </div>
                </div>
            </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.telephone')</label>
         <div class="col-sm-9">
            <x-jet-input type="tel" name="telephone" class="telephone"  />
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.fax')</label>
         <div class="col-sm-9">

             <x-jet-input type="text" name="fax" class="fax"  />
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">Notes</label>
         <div class="col-sm-9">
              <textarea name="notes" class="form-control" id="notes" cols="30" rows="5"></textarea>
         </div>
     </div>
     <div class="form-group row">
    <label for="esignature" class="col-sm-3 col-form-label"></label>
    <div class="col-sm-9">
        <button type="submit"  class="button-loading btn btn-primary  saveData">
            <span class="button--loading d-none"></span> <span class="button__text">Save</span>
        </button>
        <button type="button" class="btn btn-secondary" x-on:click="open = 'offices'">
            Cancel
        </button>
    </div>
</div>
 </form>
