<div>
    <div class="row align-items-end page_table_menu">
        <div class="col-md-12">
            <div class="row align-items-end">
                <div class="col-md-12">
                    <div class="columns d-flex justify-content-end ">
                        <button class="btn btn-default borderless" type="button" x-on:click="open='terms'">@lang('labels.exit')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-form action="{{ routeCheck($route.'new-version',['qId'=>$quoteId]) }}" method="post">
        {{--  <x-jet-input type="hidden" name="account_type" value="{{ $data?->quote_data?->account_type }} " />  --}}
            <x-quote-policy />

        <x-button-group />
    </x-form>
</div>

