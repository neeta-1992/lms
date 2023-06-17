@php
    $userType = auth()->user()?->id ?? null;
@endphp
<x-app-layout :class="['dateDropdown', 'datepicker']">
    <x-jet-form-section data-ajax-url="{{ routeCheck($route . 'index') }}" title="{!! $pageTitle ?? '' !!}" class="validationForm mainForm"
        novalidate action="{{ routeCheck($route . 'store') }}" method="post" x-data="mailBox"
        x-effect="slideEffect">
        @slot('form')
            <x-jet-input type="hidden" class="draftId" name="draftId" value="{{ !empty($data?->id) ? $data?->id : '' }}" />

            <div class="searchform">
                <div class="row form-group" x-show="(userType != 2 && userType != 5)" >
                    <label for="agencyList" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.agency')</label>
                    <div class="col-sm-9">
                        <div class="ui search selection dropdown agencyListQuotes notUi input-sm" >
                            <input type="hidden" class="agencyhidden" name="agency" value="{{ !empty($agencyId) ? $agencyId : '' }}"
                                @change="insuredDropDown($el.value);">
                            <i class="dropdown icon"></i>
                            <input type="text" class="search">
                            <div class="default text">Search Agency</div>
                        </div>
                    </div>
                </div>
                <div class="row form-group" x-show="(userType != 5 && !isEmptyChack(agency))">
                    <label for="quote_id" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.insured')
                        @lang('labels.name')</label>
                    <div class="col-sm-9">
                        <div class="ui search selection dropdown insuredList notUi input-sm">
                            <input type="hidden" class="insuredhidden" name="insured"  value="{{ !empty($insuredId) ? $insuredId : '' }}"
                                @change="insuredList = $el.value;entityId =$el.value">
                            <i class="dropdown icon"></i>
                            <input type="text" class="search">
                            <div class="default text">Search @lang('labels.insured')</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="userForm"></div>

            @include("company.quotes.quote-models")
        @endslot
    </x-jet-form-section>
	<script>
	var agencyJson  = '@json($agencyJson ?? [])';
	var insuredJson  = '@json($insuredJson ?? [])';
	</script>
    @push('page_script_code')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('mailBox', () => ({
                    insuredList:null,
                    userType: "{{ Auth()->user()?->user_type }}",
                    agency: null,
                    draftId: false,
                    insurance_company: null,
                    open: 'version1',
                    title: 'Version 1',
                    ajaxRunFunction: false,
                    payment_method: null,
                    init() {
                       this.agency = "{{ $agencyId ?? '' }}";
                       this.insuredList = "{{ $insuredId ?? '' }}";
                       if(this.userType != 2 && this.userType != 5){
                           this.agencyDropDown();
                       }else if(this.userType == 2 ){
                           this.insuredDropDown();
                       }
                    },
                    insuredDropDown(agency = this.agency){
                        this.agency = agency 
                        remotelyDropDown('.insuredList', 'common/entity/insured', {
                            agency: parseInt(agency)
                        });
                    },
                    agencyDropDown(){
                        remotelyDropDown('.agencyListQuotes', 'common/entity/agency');
                    },
                    async slideEffect() {
                        $('.userForm').html(null);
                        if (!isEmptyChack(this.userType)) {
                            if (!isEmptyChack(this.insuredList) && !isEmptyChack(this.agency)) {
                                this.ajaxRunFunction = true;
                            }
                            $(document.body).on('change', '.agencyhidden', function() {
                                $('.userForm').html(null);
                                $('.insuredhidden').val('');
                                $('.insuredList .text').text('');
                            })
                            if (this.ajaxRunFunction) {
                                let mainUrl = `{{ routeCheck($route . 'new-quote') }}`;
                                let draftId =  $(".draftId").val();
                                const usersUrl = `${mainUrl}?userType=${this.userType}&agency=${this.agency}&insured=${this.insuredList}&draftId=${draftId}`;
                                let usersUrlResult = await doAjax(usersUrl, method = 'get');
                                $('.userForm').html(usersUrlResult?.view);

                                if(!isEmptyChack(usersUrlResult?.draftId)){
                                    $(".draftId").val(usersUrlResult?.draftId);
                                }
                                if(!isEmptyChack(usersUrlResult?.qId)){
                                    title = `Quote # ${usersUrlResult?.qId}`
                                    $(".page_title_heading").html(title);
                                }

                                $('.ui.dropdown').dropdown();
                                amount();
                                percentageInput();
                                singleDatePicker($('#inception_date'));
                                remotelyDropDown('.insurance_companyDropdown',
                                    'common/entity/insurance_company',{istype:'quote'});
                                remotelyDropDown('.general_agentDropdown',
                                    'common/entity/general_agent',{istype:'quote'});
                                $('.account_type input').change();
                                switch (this.open) {
                                    case 'version1':
                                        this.title = 'Version 1'
                                        break;
                                    default:
                                        this.title = 'Version 1'
                                        break;
                                }
                            }
                        }
                    }

                }))
            })
			setTimeout(function(){
				$('.agencyList').dropdown('setup menu', {values:$.parseJSON(agencyJson)});
				$('.agencyList').dropdown('set selected', {{!empty($data?->agency) ? $data?->agency :null}});
				$('.insuredList').dropdown('setup menu', {values:$.parseJSON(insuredJson)});
				$('.insuredList').dropdown('set selected', {{!empty($data?->insured) ? $data?->insured :null}});
			},100)
        </script>
    @endpush
</x-app-layout>
