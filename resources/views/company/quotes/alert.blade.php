
@if((auth()->user()->can('companyUser') || auth()->user()->can('isAdminCompany')) &&  !empty($data->unlock_request))
<div class="col-md-12">
    <div class="alert alert-info" role="alert" style="background-color:#fd7e14 !important;color:#fff!important">
        <button class="close" type="button" data-dismiss="alert" aria-label="Close" x-on:click="financeUnlockquote('lock')">
            <span aria-hidden="true">×</span>
        </button>
        Agent <strong>{{ $data?->agent_data?->name ?? '' }}</strong> requested to cancel the request for activation. <a href="javascript:void(0);" class="Unlockfinancequote linkButton" x-on:click="financeUnlockquote('unlock')">Click here</a> to UNLOCK the quote.</div>
</div>
@endif
@if($data->aggregate_limit_approve == 1 && $data->aggregate_limit_admin_user_id == auth()->user()->id)
@php
    $companyName = DBHelper::userData(['id'=>$data->finance_company],'name');
   
@endphp
<div class="alert alert-danger" role="alert">
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>{{ $companyName ?? '' }}</strong> has requested for approval of aggregate limit. Please <a href="javascript:void(0);" class="Aggregatelimit_approve" x-on:click="aggregateLimitStatus('approve')">@lang('labels.approve')</a> or <a href="javascript:void(0);" class="Aggregatelimit_decline" x-on:click="aggregateLimitStatus('decline')">@lang('labels.decline')</a> </div>
@endif


@if($data->status == 7)
<div class="alert alert-danger" role="alert">
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    Request for final approval <a href="javascript:void(0);" class="" x-on:click="finalApproved('approve')">@lang('labels.approve')</a>  </div>
@endif
