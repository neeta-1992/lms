<x-mail::message>
# Hello

Your Login Detials

@if(!empty($data['email']))
<b>Email : {{ $data['email'] ?? '' }} </b> <br>
@endif
@if(!empty($data['username']))
<b>Username : {{ $data['username'] ?? '' }} </b> <br>
@endif
<b>Password : {{ $data['password'] ?? '' }} </b>


Thank you,<br>
{{ config('app.name') }}
</x-mail::message>
