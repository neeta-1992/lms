 <form class="validationForm editForm" novalidate method="POST" action="{{ routeCheck($route . 'update', $id) }}">
     @csrf
     @method('put')
     <input type="hidden" name="logsArr">
     @if (!empty($entityId))
         <input type="hidden" name="typeId" value="{{ $entityId ?? '' }}">
     @endif
     @if (!empty($type))
         <input type="hidden" name="type" value="{{ $type ?? '' }}">
     @endif
     <div class="tab-one">
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.subject')</label>
             <div class="col-sm-9">
                 <x-jet-input type="text" name="subject" required value="{{ $data['subject'] ?? '' }}" />
             </div>
         </div>
         @if(!empty($type) && $type == 'quotes')
         <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.type')</label>
            <div class="col-sm-9">
               <x-select :options="['Private'=>'Private','Public'=>'Public']" name="attachment_type" class="ui dropdown w-50"   />
            </div>
        </div>
         @endif
         <div class="form-group row">
             <label for="state" class="col-sm-3 col-form-label ">@lang('labels.description')</label>
             <div class="col-sm-9">
                 <textarea name="description" id="description" cols="30" class="form-control" rows="3">{{ $data['description'] ?? '' }}</textarea>
             </div>
         </div>

         <div class="form-group row ">
             <label for="notes" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.filename')</label>
             <div class="col-sm-9 ">
                  <x-jet-input type="text" name="original_filename" class="username" required value="{{ basename($data['original_filename'],'.'.pathinfo($data['original_filename'], PATHINFO_EXTENSION)) ?? '' }}" />
             </div>
         </div>
         <div class="form-group row ">
             <label for="notes" class="col-sm-3 col-form-label "></label>
             <div class="col-sm-9 ">
                 <a href="javascript:void(0)" onclick="fileIframeModel('{{ asset('uploads/'.$data['filename']) }}')">{{ $data['original_filename'] ?? '' }}</a>
             </div>
         </div>


         <x-button-group class="saveData" xclick="open = 'attachments'" cancelClass='cancelList' />
     </div>
 </form>
 <script>
     var editFormArr = @json($data ?? []);
 </script>
