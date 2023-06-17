<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    @includeIf("common.style",['class'=>[]])
</head>

<body class="antialiased">
    <section class="py-0 font-1">
        <div class="container-fluid">
            <div class="row align-items-center text-center justify-content-center h-full">
                <div class="col-lg-6 col-xl-5 px-0">
                    <h1 class="mb-0"> @yield('code')</h1>

                    @yield('message')
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
</body>

</html>
