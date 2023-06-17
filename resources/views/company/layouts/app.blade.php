<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? $title : '' }} {{ config('app.name') }}</title>
    @includeIf("company.parts.head")
</head>
<body data-spy="scroll" data-target=".inner-link" data-offset="60">
    @auth('company')
        @includeIf("company.parts.header")
    @endauth

    <main>
        @yield('content')
    </main>
@includeIf("company.parts.footer")
    @includeIf("company.parts.scripts")
</body>
</html>
