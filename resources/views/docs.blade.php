<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta charset="UTF-8" />
    <title>User Training Guide</title>
    <!-- Site theme -->
    <link rel="stylesheet" href="{{ url('docs') }}/assets/css/vue.css" />
    <link href="{{ url('docs') }}/assets/fonts/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="{{ url('docs') }}/assets/fonts/fontawesome/css/light.min.css" rel="stylesheet">
    <link href="{{ url('docs') }}/assets/fonts/fontawesome/css/thin.min.css" rel="stylesheet">
    <link href="{{ url('docs') }}/assets/fonts/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="{{ url('docs') }}/assets/fonts/fontawesome/css/duotone.min.css" rel="stylesheet">
    <link href="{{ url('docs') }}/assets/fonts/fontawesome/css/regular.min.css" rel="stylesheet">
    <style>
			.user-guide-popup main .sidebar > h1 {
				text-align: left;
				margin-left: 15px;
				padding: 10px;
			}
    </style>
    <!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"-->
</head>

<body class="user-guide-popup">

    <div id="app"></div>

    <script>
        window.$docsify = {
            basePath: "{{ url('docs') }}",
            search: 'auto',
            name: "<b>Agent User Guide</b>",
            homepage: "README.md",
            nativeEmoji: true,
            // Sidebar
            loadSidebar: true,
            auto2top: true,
            maxLevel: 4,
            subMaxLevel: 3,
            // Footer
            // loadFooter: true,
            loadFooter: "_footer.md",
        };
    </script>
    <script src="//cdn.jsdelivr.net/npm/docsify@4"></script>
    <script src="//cdn.jsdelivr.net/npm/docsify/lib/plugins/emoji.min.js"></script>
    <script src="{{ url('docs') }}/assets/plugins/docsify-footer.min.js"></script>
</body>

</html>
