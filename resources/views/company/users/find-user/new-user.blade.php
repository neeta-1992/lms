<x-app-layout :class="['datepicker']">
    <x-jet-form-section :title="$pageTitle" :buttonGroup="['other' => [['text' => __('labels.cancel'), 'url' => routeCheck('company.dashboard')]]]" class="validationForm reloadForm"  novalidate
        action='{{ routeCheck($route."user-create") }}' method="post" x-data="{ insuredList :null,userType:null,agency:null,salesOrganization:null,resetPassword :null,entityId:null }"
        x-effect="async () => {
            $('.userForm').html(null);

            let ajaxRunFunction = false;
            if(!isEmptyChack(userType)){
                if(userType == 2 &&  !isEmptyChack(agency)){
                    ajaxRunFunction = true;
                    remotelyDropDown('.agencyList', 'common/entity/agency');
                }if(userType == 5 ){
                    remotelyDropDown('.agencyList', 'common/entity/agency');
                    if(!isEmptyChack(agency)){
                        remotelyDropDown('.insuredList', 'common/entity/insured',{agency:agency});
                    }
                    if(!isEmptyChack(insuredList) && !isEmptyChack(agency)){
                        ajaxRunFunction = true;
                    }


                }else if(userType == 6){
                    if(!isEmptyChack(salesOrganization)){
                        ajaxRunFunction = true;
                    }
                    remotelyDropDown('.salesOrganization', 'common/entity/sales-organization');
                }else if(userType == 4){
                    ajaxRunFunction = true;

                }
                if(ajaxRunFunction){
                    let mainUrl = '{{ routeCheck($route . 'user-view') }}';
                    const usersUrl = `${mainUrl}?userType=${userType}&agency=${agency}&salesOrganization=${salesOrganization}`;
                    let usersUrlResult = await doAjax(usersUrl, method='post');
                    $('.userForm').html(usersUrlResult);
                    $('.ui.dropdown').dropdown();
                    telephoneMaskInput();
                    faxMaskInput();
                    zipMask();
                    daysList();
                    singleDatePicker();
                    percentageInput();
                }
            }
         }">
        @slot('form')
        <input type="hidden" name="entityId"  x-bind:value="entityId">
        <div class="col-md-12 p-0">
            <div class="row form-group">
                <label for="quote_id" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.user_type')</label>
                <div class="col-sm-9">
                    <x-select name='user_type' :options="loginUserTypeArr()" class="ui dropdown w-100 userType" required placeholder="Select Type" x-model="userType"/>
                </div>
            </div>
        </div>

        <div class="col-md-12 p-0" x-show="(userType == 2 || userType == 5)">
        <div class="row form-group">
            <label for="agencyList" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.agency')</label>
            <div class="col-sm-9">
                <div class="ui search selection dropdown agencyList notUi input-sm">
                        <input type="hidden" name="agency" @change="agency = $el.value;entityId =$el.value">
                        <i class="dropdown icon"></i>
                        <input type="text" class="search">
                        <div class="default text">Search Agency</div>
                    </div>
                </div>
              </div>
        </div>



        <div class="col-md-12  p-0" x-show="(userType == 6)">
        <div class="row form-group">
            <label for="quote_id" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.sales_organization')</label>
            <div class="col-sm-9">
                <div class="ui search selection dropdown salesOrganization notUi input-sm">
                        <input type="hidden" name="sales_organization" @change="salesOrganization = $el.value;entityId =$el.value">
                        <i class="dropdown icon"></i>
                        <input type="text" class="search">
                        <div class="default text">Search @lang('labels.sales_organization')</div>
                    </div>
                </div>
              </div>
        </div>
        <div class="col-md-12  p-0"  x-show="(userType == 5 && !isEmptyChack(agency))">
        <div class="row form-group">
            <label for="quote_id" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.insured") @lang("labels.name")</label>
            <div class="col-sm-9">
                <div class="ui search selection dropdown insuredList notUi input-sm">
                        <input type="hidden" name="insured" @change="insuredList = $el.value;entityId =$el.value">
                        <i class="dropdown icon"></i>
                        <input type="text" class="search">
                        <div class="default text">Search @lang('labels.insured')</div>
                    </div>
                </div>
              </div>
        </div>

        <div class="userForm"></div>






        <x-button-group :cancel="routeCheck('company.dashboard')" />
        @endslot
    </x-jet-form-section>

       @push('page_script')
        <script>

        </script>
    @endpush
</x-app-layout>
