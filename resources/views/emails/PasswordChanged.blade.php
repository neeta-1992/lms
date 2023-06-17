<x-mail::message>
Dear {{ $data['name'] ?? '' }}

This email is confirmation that your password has been changed.
  
Please click on the link below and follow the instructions.


Thank you,<br>
{{ config('app.name') }}
</x-mail::message>
