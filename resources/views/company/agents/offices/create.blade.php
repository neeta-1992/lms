 <form class="validationForm" novalidate action="{{ routeCheck('company.agents.office.create',$id) }}" method="post">
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
     <div class="form-group row">
         <label for="address" class="col-sm-3 col-form-label ">@lang('labels.address')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="address"  />
         </div>
     </div>
     <div class="form-group row">
        <label for="state" class="col-sm-3 col-form-label ">@lang('labels.state')</label>
        <div class="col-sm-9">
            {!! form_dropdown('state', stateDropDown(), '', ['class' => " w-100"]) !!}
        </div>
    </div>
     <div class="form-group row">
         <label for="city" class="col-sm-3 col-form-label ">@lang('labels.city')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="city"  />
         </div>
     </div>

     <div class="form-group row">
         <label for="zip" class="col-sm-3 col-form-label ">@lang('labels.zip')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="zip"  class="zip_mask"/>
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
