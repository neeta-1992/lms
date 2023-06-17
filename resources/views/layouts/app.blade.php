<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="default-style">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{  dynamicPageTitle() ?? ''  }}</title>
    @includeIf(layoutParts('head','common'))
    @php
       $icons =  App\Helpers\Iocns::addIons();
    @endphp
    <script data-turbolinks-eval="false" data-turbolinks-suppress-warning>
        let iconsArr = @json($icons ?? []);
    </script>
</head>

<body data-spy="scroll" data-target=".inner-link" data-offset="60">
    {{-- <x-jet-banner /> --}}
    <div class="loader loading d-none">Loading&#8230;</div>
    @auth
     @includeIf(layoutParts('header','common'))
    @endauth

    <main>
        {{ $slot  }}
    </main>


    @includeIf(layoutParts('footer','common'))
    @includeIf(layoutParts('scripts','common'))
    @stack('modals')

</body>

</html>
