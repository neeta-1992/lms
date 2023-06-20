<x-app-layout>
    <x-jet-form-section
        :buttonGroup="['logs', 'other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')]]]"
        class="validationForm editForm fullLableText hasAlpine" method="post" novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post"
        x-data="{ ruleTable: 'table', ruleEditUrl: null, tableShow: '' }" x-effect="async () => {
            switch (ruleTable) {
                case 'table':
                    tableShow = 'table';
                  $('#program-settings-override-settings').bootstrapTable('refresh')
                    $('.ruleForm').html('');
                    break;
                 case 'ruleForm':

                    const tableLength = $('#program-settings-override-settings').bootstrapTable('getData').length;
                    tableShow =  tableLength > 0 ? 'table' : '';
                    const ruleUrl = ruleEditUrl ?? '{{ routeCheck($route . 'statefrom') }}';
                    let result = await doAjax(ruleUrl, method='post');
                    $('.ruleForm').html(result);
					var overridevalue = $('.statevalues input').val();
					$('.override_settings').change();
					if($('.statevalues select').length>0){
						$('.statevalues select').val(overridevalue);
					}else{
						$('.statevalues input').val(overridevalue);
					}
                    $('.ui.dropdown').dropdown();
                    amount();  telephoneMaskInput();
                    break;
                default:
                    break;
            }ruleTable
        }">
        @slot('form')
        @method('put')
        <input type="hidden" name="logsArr">
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk"> @lang('labels.program_name')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control input-sm" name="name" id="name" required placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
            <div class="col-sm-9">
                {!! form_dropdown('status', ['1' => 'Enable', '0' => 'Disable'], 0, [
                'class' => 'w-100 ',
                'required' => true,
                ]) !!}
            </div>
        </div>
           <div x-show="ruleTable == 'ruleForm'" class="ruleForm">

        </div>

        <div style="position: relative" class="mt-5" x-show="tableShow == 'table'">
            <x-table id="{{ $activePage }}-override-settings" ajaxUrl="{{  routeCheck($route . 'viewlist', ['id' => $id]) }}" >
                <thead>
                    <tr>
                        <th class="align-middle" data-width="10" data-formatter="CheckBoxFormat"></th>
                        <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">
                            @lang('labels.created_date')</th>
                        <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">
                            @lang('labels.last_modified')</th>
                        <th class="align-middle" data-sortable="true" data-width="" data-field="override_settings">
                            @lang('labels.override_settings')</th>
                    </tr>
                </thead>
            </x-table>
        </div>



        <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
        @endslot
        @slot('logContent')
        <x-table id="{{ $activePage }}-logs" ajaxUrl="{{ routeCheck('company.logs', ['type' => $activePage, 'id' => $id]) }}">
            <thead>
                <tr>
                    <th class="" data-sortable="true" data-field="created_at" data-width="170">@lang('labels.created_date')
                    </th>

                    <th class="" data-sortable="true" data-field="username" data-width="200">
                      @lang('labels.user_name')
                    </th>
                    <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                </tr>
            </thead>
        </x-table>
        @endslot
    </x-jet-form-section>
    @push('page_script')
    <script>
		function allmaskjs(){
			$(".Dollar").each(function(){
				vanillaTextMask.maskInput({
					inputElement:$(this)[0],
					mask: textMaskAddons.createNumberMask({
						allowDecimal: '.',
						prefix: ' $',
						suffix: '',
						thousandsSeparatorSymbol: ',',
						allowDecimal: true,
						decimalLimit: 2,
						integerLimit : 5
					})
				});
			});
			$(".percentage").each(function(){
				vanillaTextMask.maskInput({
					inputElement:$(this)[0],
					mask: textMaskAddons.createNumberMask({
						prefix: '',
						suffix: '%',
						thousandsSeparatorSymbol: '',
						integerLimit : 3,
						allowDecimal: true,
						decimalLimit: 2,
					})
				});
			});
		}

        let editArr = @json($data ?? []);
        let OverridesettingValuesArr = @json(OverridesettingValues() ?? []);
        $(document.body).on("change",'select[name="override_settings"]',function(){
		var override_settingshtml = '';
		var override_settings = $(this).val();
		if(override_settings != '' && override_settings != undefined && OverridesettingValuesArr != '' && OverridesettingValuesArr != undefined && OverridesettingValuesArr[override_settings]){
			var override_settingsType = OverridesettingValuesArr[override_settings]['type'];
			var override_settingsclass = OverridesettingValuesArr[override_settings]['class'] != '' && OverridesettingValuesArr[override_settings]['class'] != undefined ?  OverridesettingValuesArr[override_settings]['class'] : '';
			if(override_settingsType == 'text'){
				override_settingshtml = '<input required class="state_value form-control input-sm required '+override_settingsclass+'" name="value"  type="text">';
			}else if(override_settingsType == 'select'){
				var overridesettingsoption = OverridesettingValuesArr[override_settings]['option'];
				var overridesettingsoptionhtml = '<option value=""></option>';
				if(overridesettingsoption != '' && overridesettingsoption != undefined){
					overridesettingsoption = overridesettingsoption.split(",");
					 for(var i = 0; i < overridesettingsoption.length; i++){
						 overridesettingsoptionhtml += '<option value="'+overridesettingsoption[i]+'">'+overridesettingsoption[i]+'</option>';
					}
				}
				override_settingshtml = '<select required class="ui dropdown  state_value" name="value"  type="text">'+overridesettingsoptionhtml+'</select>';
			}else if(override_settingsType == 'radio'){
				var overridesettingsoption = OverridesettingValuesArr[override_settings]['option'];
				var override_settingshtml = '<div class="custom-controls-stacked">';
				if(overridesettingsoption != '' && overridesettingsoption != undefined){
					overridesettingsoption = overridesettingsoption.split(",");
					 for(var i = 0; i < overridesettingsoption.length; i++){
						override_settingshtml +='<label class="custom-control custom-radio d-inline mr-3 "><input class="required custom-control-input state_value"  name="state_value" value="'+overridesettingsoption[i]+'" type="radio"><span class="custom-control-label">'+overridesettingsoption[i]+'</span></label>';
					}
				}
				override_settingshtml += '</div>';
			}
			$('.statevalues').html(override_settingshtml);
            $(".ui.dropdown").dropdown();
			allmaskjs();
		}
	});
	    </script>
    @endpush
</x-app-layout>
