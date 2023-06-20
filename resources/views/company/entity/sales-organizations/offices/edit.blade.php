 <form class="validationForm editForm" novalidate action="{{ routeCheck($route.'.edit',$id) }}" method="post">
 <input type="hidden" name="logsArr">
 @csrf

     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="name" required value="{{ $data['name'] }}"/>
         </div>
     </div>
     <div class="form-group row">
         <label for="description" class="col-sm-3 col-form-label ">@lang('labels.description')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="description"   value="{{ $data['description'] }}"/>
         </div>
     </div>
     <div class="form-group row">
         <label for="address" class="col-sm-3 col-form-label ">@lang('labels.address')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="address" value="{{ $data['address'] }}"  />
         </div>
     </div>
     <div class="form-group row">
        <label for="state" class="col-sm-3 col-form-label ">@lang('labels.state')</label>
        <div class="col-sm-9">
            {!! form_dropdown('state', stateDropDown(),  $data['state'], ['class' => " w-100"]) !!}
        </div>
    </div>
     <div class="form-group row">
         <label for="city" class="col-sm-3 col-form-label ">@lang('labels.city')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="city"  value="{{ $data['city'] }}" />
         </div>
     </div>

     <div class="form-group row">
         <label for="zip" class="col-sm-3 col-form-label ">@lang('labels.zip')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="zip"  class="zip_mask" value="{{ $data['zip'] }}"/>
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.telephone')</label>
         <div class="col-sm-9">
            <x-jet-input type="tel" name="telephone" class="telephone" value="{{ $data['telephone'] }}" />
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.fax')</label>
         <div class="col-sm-9">

             <x-jet-input type="text" name="fax" class="fax" value="{{ $data['fax'] }}" />
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.notes') </label>
         <div class="col-sm-9">
              <textarea name="notes" class="form-control" id="notes" cols="30" rows="5">{{ $data['notes'] }}</textarea>
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

<script>
    var editFormArr = @json($data ?? []);
</script>

