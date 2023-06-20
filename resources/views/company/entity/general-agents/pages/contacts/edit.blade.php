 <form class="contactForm editForm" novalidate action="{{ routeCheck($route .'edit',$id) }}" method="post">
    <input type="hidden" name="id" value="{{ $editId ?? '' }}">
   <input type="hidden" name="logsArr">
     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.first_name')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="first_name" required :value="$data['first_name']"/>
         </div>
     </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.m_i')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="middle_name" :value="$data['middle_name']" />
         </div>
     </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.last_name')</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="last_name" required :value="$data['last_name']"/>
         </div>
     </div>

       <div class="form-group row">
        <label for="max_setup_fee" class="col-sm-3 col-form-label">@lang('labels.dob')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-6">

                    {!! form_dropdown('month',monthsDropDown($type="number"),$data['month'], ["class"=>"ui dropdown monthsNumber input-sm w-100",'placeholder'=> 'Month']) !!}
                </div>
                <div class="col-sm-6">
                    {!! form_dropdown('day',[],'', ["class"=>" daysList",'placeholder'=> 'Day','dataSelected'=> $data['day']]) !!}

                </div>
            </div>
        </div>
    </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.email') </label>
         <div class="col-sm-9">
             <x-jet-input type="email" name="email"  class="w-50" :value="$data['email']"/>
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label "> @lang('labels.primary_telephone')</label>
         <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-6">
                   <x-jet-input type="tel" name="telephone" class="telephone"   :value="$data['telephone']"/>

                </div>
                <div class="col-sm-6">
                    <x-jet-input type="text" name="extension" class="extension w-25" :value="$data['extension']"  placeholder="Extension"/>
                </div>
            </div>


         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.fax') </label>
         <div class="col-sm-9">

             <x-jet-input type="text" name="fax"  class="w-50 fax"  :value="$data['fax']" />
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">@lang('labels.notes')</label>
         <div class="col-sm-9">
              <textarea name="notes" class="form-control" id="notes" cols="30" rows="5">{!! $data['notes'] !!}</textarea>
         </div>
     </div>
      <x-button-group class="saveData" />

 </form>
 <script>
     var editFormArr = @json($data ?? []);
 </script>
