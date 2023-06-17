<div class="row">
    <div class="col-md-12 page_table_menu">
        <div class="columns d-flex justify-content-end ">
            <button class="btn btn-default" type="button" name="Add"
                x-on:click="ruleTable = 'table'">@lang('labels.exit')</button>
        </div>
    </div>
</div>
<input type="hidden" name="settingId" value="{{ $data['id'] ?? '' }}">

<div class="form-group row">
    <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.override_settings')</label>
    <div class="col-sm-9">
        <x-select :options="Overridesettings()" :selected="($data['override_settings'] ?? '')" class='ui dropdown input-sm override_settings' required name='override_settings' placeholder="Select option" />

    </div>
</div>
<div class="form-group row">
    <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.assigned_territory')</label>
    <div class="col-sm-9">
        <x-select :options="($territorySetting ?? [])" :selected="($data['assigned_territory'] ?? '')" class='ui dropdown input-sm' required name='assigned_territory'  placeholder="Select option" />

    </div>
</div>


<div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.assigned_states')</label>
    <div class="col-sm-9">
        <x-select :options="stateDropDown(['keyType'=>'state'])" :selected="(!empty($data['assigned_states']) ? explode(',',$data['assigned_states']) : '')" class='ui dropdown input-sm' multiple required name='assigned_states[]'  placeholder="Select option"  />
    </div>
</div>

<div class="form-group row">
    <label for="value" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.value')</label>
    <div class="col-sm-9 statevalues">
        <x-jet-input type="text" name="value" required value="{{ $data['value'] ?? '' }}"/>
    </div>
</div>


