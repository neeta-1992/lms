 <form class="contactForm" novalidate action="{{ routeCheck($route .'entity-contact-save') }}" method="post">

     <input type="hidden" name="entity_id" value="{{ $id ?? '' }}">
     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">First Name</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="first_name" required />
         </div>
     </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">M/I</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="middle_name"  />
         </div>
     </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Last Name</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="last_name"  required/>
         </div>
     </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">Title</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="title"  />
         </div>
     </div>
       <div class="form-group row">
        <label for="max_setup_fee" class="col-sm-3 col-form-label">DOB</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-6">

                    {!! form_dropdown('month',monthsDropDown($type="number"),'', ["class"=>"ui dropdown monthsNumber input-sm w-100",'placeholder'=> 'Month']) !!}
                </div>
                <div class="col-sm-6">
                    {!! form_dropdown('day',[],'', ["class"=>" daysList",'placeholder'=> 'Day']) !!}

                </div>
            </div>
        </div>
    </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">Email</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="email"  class="w-50" />
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">Primary Telephone</label>
         <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-6">
                   <x-jet-input type="tel" name="telephone" class="telephone"  />

                </div>
                <div class="col-sm-6">
                    <x-jet-input type="text" name="extension" class="extension w-25"  placeholder="Extension"/>
                </div>
            </div>


         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">Fax</label>
         <div class="col-sm-9">

             <x-jet-input type="text" name="fax"  class="w-50 fax" />
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
        <button type="submit"  class="button-loading btn btn-primary  saveContacts">
            <span class="button--loading d-none"></span> <span class="button__text">Save</span>
        </button>
        <button type="button" class="btn btn-secondary" x-on:click="open = 'contacts'">
            Cancel
        </button>
    </div>
</div>
 </form>
