<x-mail::message>
# Hello Admin

Please create a new database in company

<b>DataBase Name: {{ $data['name'] ?? '' }} </b>


Thank you,<br>
{{ config('app.name') }}
</x-mail::message>
