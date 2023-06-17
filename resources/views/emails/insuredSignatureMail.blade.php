<x-mail::message>
# Hello



<x-mail::button :url="($data['url'] ?? '')">
    {{ __('labels.e_signature_') }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
