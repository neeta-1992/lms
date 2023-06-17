<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @includeIf('common.meta')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ isset($title) ? $title : '' }} {{ config('app.name') }}</title>
    @includeIf("common.fonts")
    @includeIf("common.style")
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Allura&family=Great+Vibes&family=Marck+Script&family=Niconne&display=swap');
	@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap');
    .isBodyDisabled{
        pointer-events: none;
        opacity: 0.5;
    }

    /* CSS styling for before/after/avoid. */
    .before {
    page-break-before: always;
    }
    .after {
    page-break-after: always;
    }
    .avoid {
    page-break-inside: avoid;
    }
    </style>
</head>

<body data-spy="scroll" data-target=".inner-link" data-offset="60">
   
    

    <main>
        @yield("content")
    </main>


   
    @includeIf("common.scripts",['type'=>'blank'])
</body>

</html>