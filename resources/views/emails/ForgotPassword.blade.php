<x-mail::message>
# Dear {{ $data['name'] ?? '' }}

We received a request to reset your Loan Management System account password.
  
Please click on the link below and follow the instructions.

<x-mail::button :url="($data['url'] ?? '')">
    Reset Password
</x-mail::button>

This password reset link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.

Thank you,<br>
{{ config('app.name') }}
</x-mail::message>
