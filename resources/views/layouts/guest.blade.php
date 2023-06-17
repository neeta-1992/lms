<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? $title : '' }} {{ config('app.name') }}</title>
    @includeIf("common.style")
</head>

<body data-spy="scroll" data-target=".inner-link" data-offset="60">
   
    

    <main>
        {{ $slot }}
    </main>


    @includeIf("common.footer")
    @includeIf("common.scripts")

</body>

</html>