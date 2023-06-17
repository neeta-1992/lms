<x-form action="{{ routeCheck($route.'store',['qId'=>$qId,'vId'=>$vId]) }}" method="post">

    <div class="form-group row">
        <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.subject')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="subject" required />
        </div>
    </div>


    <div class="form-group row">
        <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.type')</label>
        <div class="col-sm-3">
            <x-select :options="['Private' => 'Private', 'Public' => 'Public']" name="type" required class="ui dropdown"
                placeholder="Select {{ __('labels.type') }}" />
        </div>
    </div>

    <div class="form-group row">
        <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.description')</label>
        <div class="col-sm-9">
            <textarea name="description" id="description" cols="30" rows="5" class="form-control" required></textarea>
        </div>
    </div>

    <div class="form-group row ">
        <label for="notes" class="col-sm-3 col-form-label">@lang('labels.upload_file')</label>
        <div class="col-sm-9 ">
            <x-input-file label="{{ __('labels.upload_file') }}" name="files[]" data-file="notes"
                accept=".jpeg,.png,.gif,.pdf" multiple data-multiple-caption="{count} files selected" />
        </div>
    </div>



    <x-button-group xclick="open = 'notesList'"/>
</x-form>
