<x-mail::message>
# Hello,

There is a request to deactivate a finance company {{ $data['name'] ?? '' }}. Please click on below link to confirm if its's you.

<x-mail::button :url="($data['url'] ?? '')">
  Deactivate Confirmation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
