<x-mail::message>
# Hello {{ $data['name'] ?? '' }}

Two-Step Verification Otp  : {{ $data['otp'] ?? '' }}


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
