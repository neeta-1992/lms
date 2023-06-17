<div class="row ">
    
    <div class="col-md-4">
        {{-- Menu Dropdown --}}
        <div class="columns">
            <div class="ui selection dropdown table-head-dropdown maindropdown">
                <input type="hidden" x-bind:value=open /><i class="dropdown icon"></i>
                <div class="text" x-text="title">@lang('labels.quote_information')</div>
                <div class="menu">
                    <div class="item" @click="trigger('quote_information')"  x-show="open != 'quote_information'">@lang('labels.quote_information')
                    </div>
                    <div class="item" @click="trigger('policies')"  x-show="(open != 'policies')">  @lang('labels.policies')</div>
                   {{--   <div class="item" @click="trigger('terms')"  x-show="(open != 'terms')">  @lang('labels.terms')</div>  --}}
                    <div class="item" @click="trigger('e_signature')"   x-show="open != 'e_signature'">@lang('labels.e_signature_')</div>
                    <div class="item" @click="trigger('attachments')"   x-show="open != 'attachments'">@lang('labels.attachments')</div>
                    
                    <div class="item" @click="trigger('inmail')" x-show="open != 'inmail'"> @lang('labels.inmail')</div>
                    <div class="item" @click="trigger('tasks')" x-show="open != 'tasks'">    @lang('labels.tasks')</div>
                    @if($data?->status >= $model::APPROVE)
                        <div class="item" @click="trigger('underwriting_questions')" x-show="open != 'underwriting_questions'">@lang('labels.underwriting_questions')</div>
                    <div class="item" @click="trigger('underwriting_logs')" x-show="open != 'underwriting_logs'"> @lang('labels.underwriting_logs')</div>
                    @endif
                    
                    <div class="item" @click="trigger('logs')" x-show="open != 'logs'">  @lang('labels.logs')</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8" x-show="(open != 'contacts' && open != 'logs' && open != 'inmail')">
        <div class="row align-items-end">
            <div class="col-md-12">
                <div class="columns d-flex justify-content-end">
                    <div class="lodeHtmlData" x-bind:class="(open == 'quote_information' || open == 'policies' || open == 'addPolicy'  || open == 'newVersion' || open == 'terms') ? 'd-flex' : 'd-none'">
                        @empty($deleted)


                        <button class="btn btn-default " type="button"><a href="javascript:void(0)" x-on:click="eSignatureQuote()">@lang('labels.e_signature_quote')</a></button>
                            @if($isRequestActive)
                                @if((auth()->user()->can('agentUser') || auth()->user()->can('company')))
                                    @if($data?->status < $model::ACTIVEREQUEST && auth()->user()->can('agentUser'))
                                        <button class="btn btn-default " type="button"><a href="javascript:void(0)" x-on:click="quoteRequestActivation()">@lang('labels.quote_request_activation')</a></button>
                                    @elseif($data?->status < $model::ACTIVEREQUEST && auth()->user()->can('company'))
                                         <button class="btn btn-default " type="button"><a href="javascript:void(0)" x-on:click="underwritingVerification()">@lang('labels.quote_request_activation')</a></button>
                                    @endif
                                @endif
                                @if(auth()->user()->can('agentUser') )
                                    @if($data?->status == $model::ACTIVEREQUEST)
                                            <button class="btn btn-default " type="button"><a href="javascript:void(0)" x-on:click="quoteRequestToUnlock()">@lang('labels.quote_request_to_unlock')</a></button>
                                    @endif
                                @endif
                            @endif

                            @if((auth()->user()->can('companyUser') || auth()->user()->can('companyAdmin') || auth()->user()->can('isAdminCompany')) && $data->status == 2 && $pageType == 'edit')
                                 <button class="btn btn-default " type="button"> <a href="javascript:void(0)" x-on:click="underwritingVerification()" data-turbolinks="false">@lang("labels.underwriting_verification")</a></button>
                            @endif
                            @if($pageType == 'underwriting-quote')
                                    @if( auth()->user()->can('companyAdmin') && $data->status == $model::FINALAPPROVAL)
                                        <button class="btn btn-default " type="button"> <a href="javascript:void(0)" x-on:click="quoteApprove()" data-turbolinks="false">@lang("labels.final_approval")</a></button>
                                    @elseif($data->status != $model::APPROVE &&  $data?->status != $model::FINALAPPROVAL)
                                        <button class="btn btn-default " type="button"> <a href="javascript:void(0)" x-on:click="quoteApprove()" data-turbolinks="false">@lang("labels.approve")</a></button>
                                        <button class="btn btn-default " type="button"> <a href="javascript:void(0)" x-on:click="quoteDecline()" data-turbolinks="false">@lang("labels.decline")</a></button>
                                    @endif
                            @endif

                            <button class="btn btn-default " type="button"> <a href="javascript:void(0)" x-on:click="viewFa()" data-turbolinks="false">@lang("labels.view_fa")</a></button>
                            <button class="btn btn-default " type="button"> <a href="javascript:void(0)" x-on:click="quoteDelete()" data-turbolinks="false">@lang("labels.delete")</a></button>
                        @endempty
                        <button class="btn btn-default " type="button"> <a href="{{ routeCheck($route . 'index') }}"  data-turbolinks="false">@lang('labels.cancel')</a></button>
                    </div>
                    <div class="lodeHtmlData" x-bind:class="(open == 'attachments') ? 'd-flex' : 'd-none'">
                        <button class="btn btn-default borderless collapse_all" type="button">@lang('labels.collapse_all')</button>
                        <button class="btn btn-default borderless expand_all" type="button">@lang('labels.expand_all')</button>
                        @if(empty($deleted) || $data->status != $model::APPROVE)
                            <button class="btn btn-default borderless" type="button" x-on:click="open = 'uploadSignedPFA'">@lang('labels.upload_signed_pfa')</button>
                        <button class="btn btn-default borderless" type="button" x-on:click="open = 'uploadAttachment'">@lang('labels.upload_attachment')</button>
                        @endif
                        <button class="btn btn-default"   x-on:click="open = 'terms'">@lang('labels.cancel')</a></button>
                    </div>
                    <div class="lodeHtmlData" x-bind:class="(back) ? 'd-flex' : 'd-none'">
                        <button class="btn btn-default" x-on:click="open = back">@lang('labels.exit')</a></button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
