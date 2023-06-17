<x-form action="{{ routeCheck($route.'policy-details',$data->id) }}" method="post" class="quoteEditForm {{ $data?->quote_data?->status  >= 2 ? 'disabled' : '' }}">
    {{--  <x-jet-input type="hidden" name="account_type" value="{{ $data?->quote_data?->account_type }} " />  --}}

    <x-quote-policy :data="$data" />
    @if($data?->quote_data?->status < 2)
        <x-button-group class="saveData" xclick="open = 'policies'" cancelClass='cancelList' />
    @endif
    
</x-form>
