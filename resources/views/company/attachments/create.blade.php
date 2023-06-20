 <form class="validationForm" novalidate method="POST"
     action="{{ routeCheck($route . 'store', ['quoteId' => $quotesId, 'versionId' => $versionId]) }}">
     @csrf

     <input type="hidden" name="logsArr">
     @if (!empty($entityId))
         <input type="hidden" name="typeId" value="{{ $entityId ?? '' }}">
     @endif
     @if (!empty($type))
         <input type="hidden" name="type" value="{{ $type ?? '' }}">
     @endif
     @if (!empty($pfa))
         <input type="hidden" name="is_pfa" value="true">
     @endif


     <div class="tab-one">
         <div class="form-group row">
             <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.subject')</label>
             <div class="col-sm-9">
                 <x-jet-input type="text" name="subject" required />
             </div>
         </div>
         @if (!empty($type) && $type == 'quotes')
             <div class="form-group row">
                 <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.type')</label>
                 <div class="col-sm-9">
                     <x-select :options="['Private' => 'Private', 'Public' => 'Public']" name="attachment_type" class="ui dropdown w-50" />
                 </div>
             </div>
         @endif
         <div class="form-group row">
             <label for="state" class="col-sm-3 col-form-label ">@lang('labels.description')</label>
             <div class="col-sm-9">
                 <textarea name="description" id="description" cols="30" class="form-control" rows="3"></textarea>
             </div>
         </div>

         <div class="form-group row ">
             <label for="notes" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.attachments')</label>
             <div class="col-sm-9 ">
                 <x-input-file label="Max file size allowed is 8 MB and Accepted file types are pdf" name="attachments"
                     data-file="attachments" accept=".pdf" required multiple />
             </div>
         </div>


         <x-button-group class="saveData" xclick="open = 'attachments'" />
     </div>
 </form>
