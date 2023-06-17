
 <form class="contactForm editForm" novalidate action="{{ routeCheck($route .'edit',$id) }}" method="post">
    <input type="hidden" name="userId" value="{{ $editId ?? '' }}">
    <input type="hidden" name="logsArr">
    @csrf
     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label requiredAsterisk">First Name</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="first_name" required :value="$data['first_name']"/>
         </div>
     </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">M/I</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="middle_name" :value="$data['middle_name']" />
         </div>
     </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Last Name</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="last_name" required :value="$data['last_name']"/>
         </div>
     </div>
     <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">Title</label>
         <div class="col-sm-9">
             <x-jet-input type="text" name="title"  :value="$data['title']"/>
         </div>
     </div>
       <div class="form-group row">
        <label for="max_setup_fee" class="col-sm-3 col-form-label">DOB</label>
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
         <label for="state" class="col-sm-3 col-form-label ">Email</label>
         <div class="col-sm-9">
             <x-jet-input type="email" name="email"  class="w-50" :value="$data['email']"/>
         </div>
     </div>
      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">Primary Telephone</label>
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
        <label for="office" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.office')</label>
        <div class="col-sm-9">
            {!! form_dropdown('office', $office, ($data['office'] ?? ''), [
            'class' => 'ui dropdown input-sm w-100 office_select','required' => true
            ]) !!}
        </div>
    </div>
 {{--    <div class="form-group row">
        <label for="office" class="col-sm-3 col-form-label ">@lang('labels.user_groups')</label>
        <div class="col-sm-9">
            {!! form_dropdown('user_groups', stateDropDown(), '', [
            'class' => 'ui dropdown input-sm w-100',
            ]) !!}
        </div>
    </div> --}}
    <div class="form-group row">
        <label for="role" class="col-sm-3 col-form-label ">@lang('labels.user') @lang("labels.role")</label>
        <div class="col-sm-9">
            {!! form_dropdown('role', [1=>'Adminstrator',2 =>'User'], ($data['role'] ?? "0"), [
            'class' => 'ui dropdown input-sm w-100 role_select','dataSelected' => ($data['role'] ?? "0")
            ]) !!}
        </div>
    </div>


      <div class="form-group row">
         <label for="state" class="col-sm-3 col-form-label ">Notes</label>
         <div class="col-sm-9">
              <textarea name="notes" class="form-control" id="notes" cols="30" rows="5">{!! $data['notes'] !!}</textarea>
         </div>
     </div>
      <x-button-group class="saveData" />

 </form>
 <script>
     var editFormArr = @json($data ?? []);
 </script>
