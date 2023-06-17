

{{-- Bootstrap css v4.0.0-alpha.6 --}}
    <link href="{{ asset('/') }}assets/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" data-turbolinks-track="reload">
{{-- End Bootstrap css v4.0.0-alpha.6 --}}


{{-- Semantic UI CSs - 2.5.0 --}}
<link rel="stylesheet" href="{{ asset('assets/lib/semantic-ui-statistic/semantic.min.css') }}" data-turbolinks-track="reload">
{{-- End Semantic UI CSS - 2.5.0 --}}

{{-- Bootstrap Table css  --}}
 @include('common.table',['type'=>'css'])
{{-- End Bootstrap Table css  --}}

@if(in_array("datepicker",$class))
{{-- daterangepicker css --}}
    <link href="{{ asset("assets/lib/daterangepicker/daterangepicker.css") }}" rel="stylesheet" data-turbolinks-track="reload">
{{-- End daterangepicker css --}}
@endif
@if(in_array("timepicker",$class))
{{-- timepicker css --}}
    <link href="{{ asset("assets/lib/timepicker/jquery.timepicker.min.css") }}" rel="stylesheet" data-turbolinks-track="reload">
{{-- End timepicker css --}}
@endif

{{-- Semantic Ui Dropdown css --}}
    <link href="{{ asset('/') }}assets/lib/semantic-ui-dropdown/dropdown.css" rel="stylesheet" data-turbolinks-track="reload">
    <link href="{{ asset('/') }}assets/lib/semantic-ui-transition/transition.css" rel="stylesheet" data-turbolinks-track="reload">
{{-- End Semantic Ui Dropdown css --}}

{{-- Remodal css --}}
    <link href="{{ asset('/') }}assets/lib/remodal/dist/remodal.css" rel="stylesheet" data-turbolinks-track="reload">
    <link href="{{ asset('/') }}assets/lib/remodal/dist/remodal-default-theme.css" rel="stylesheet" data-turbolinks-track="reload">
{{-- End Remodal css --}}

@if(in_array("codemirror",$class))
{{-- codemirror css --}}
    <link href="{{ asset("assets/lib/codemirror/codemirror.css") }}" rel="stylesheet" data-turbolinks-track="reload">
    <link href="{{ asset("assets/lib/codemirror/show-hint.css") }}" rel="stylesheet" data-turbolinks-track="reload">
    <link href="{{ asset("assets/lib/codemirror/material-ocean.css") }}" rel="stylesheet" data-turbolinks-track="reload">
	<link href="{{ asset("assets/lib/codemirror/dialog.css") }}" rel="stylesheet" data-turbolinks-track="reload">
{{-- End codemirror css --}}
@endif

@if(in_array("inMail",$class))
{{-- inMail css --}}
    <link href="{{ asset('/') }}assets/css/message.css" rel="stylesheet" data-turbolinks-track="reload">
{{-- End inMail css --}}
@endif


@if(in_array("quill",$class))
{{-- quill css --}}
    <link href="{{ asset("assets/lib/quill/quill.css") }}" rel="stylesheet" data-turbolinks-track="reload">
{{-- End quill css --}}
@endif

@if(in_array("emoji",$class))
{{-- emojionearea css --}}
    <link href="{{ asset("assets/css/emojionearea.min.css") }}" rel="stylesheet" data-turbolinks-track="reload">
{{-- End emojionearea css --}}
@endif




<link href="{{ asset('/') }}assets/css/style.css" rel="stylesheet" data-turbolinks-track="reload">
<link href="{{ asset('/') }}assets/css/custom.css" rel="stylesheet" data-turbolinks-track="reload">

@livewireStyles

@stack('common_style')
