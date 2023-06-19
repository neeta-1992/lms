

<script  data-turbolinks-eval="false" data-turbolinks-suppress-warning>
    const BASE_URL = '{{ url("/") }}/{{ request()->segment(1) }}/';
    window.icons = {
        refresh: 'fa-sync',
        columns: 'fa-columns',
    }

</script>

<script src="{{ asset("build/assets/app-41abd5d6.js") }}" data-turbolinks-eval="false" data-turbolinks-suppress-warning></script>
@stack('tableIconsArr')
 <script defer src="{{ asset("assets/js/form-data.min.js") }}" data-turbolinks-eval="false" data-turbolinks-suppress-warning></script>
 <script defer src="{{ asset("assets/js/cdn.min.js") }}" data-turbolinks-eval="false" data-turbolinks-suppress-warning></script>
<script src="{{ asset('assets/lib/jquery/dist/jquery.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
<script src="{{ asset('assets/js/tether.min.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
@if(in_array("timepicker",$class))
{{-- timepicker Js --}}
    <script src="{{ asset("assets/lib/timepicker/jquery.timepicker.min.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End timepicker Js --}}
@endif

@if(in_array("datepicker",$class))
{{-- daterangepicker Js --}}
    <script src="{{ asset("assets/lib/daterangepicker/moment.min.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/daterangepicker/moment-timezone-with-data.min.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/daterangepicker/daterangepicker.min.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End daterangepicker Js --}}
<script>
    moment.tz.setDefault('{{ config("app.timezone") }}');
</script>
@endif



@if(in_array("dateDropdown",$class))
{{-- jQuery Date Dropdowns - v1.0.0  --}}
    <script src="{{ asset("assets/js/date-dropdowns.min.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- EndjQuery Date Dropdowns --}}
@endif

{{-- Bootstrap Js v4.0.0-alpha.6 --}}
<script src="{{ asset('assets/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>

{{-- End Bootstrap Js v4.0.0-alpha.6 --}}

{{-- Semantic UI Js - 2.5.0 --}}
<script src="{{ asset('assets/lib/semantic-ui-statistic/semantic.min.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End Semantic UI Js - 2.5.0 --}}

{{-- Semantic Ui Dropdown Js --}}
<!--<script src="{{ asset('assets/lib/semantic-ui-dropdown/dropdown.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
<script src="{{ asset('assets/lib/semantic-ui-transition/transition.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>-->
{{-- End Semantic Ui Dropdown Js --}}


{{-- Bootstrap Table Js --}}
@include('common.table',['type'=>'js'])
{{-- End Bootstrap Table Js --}}



@if(in_array("codemirror",$class))
{{-- codemirror js --}}
    <script src="{{ asset('assets/lib/codemirror/codemirror.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/css.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>

    <script src="{{ asset("assets/lib/codemirror/xml-fold.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/javascript.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/htmlmixed.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/show-hint.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/html-hint.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/css-hint.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/javascript-hint.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/xml-hint.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/closebrackets.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/closetag.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/matchtags.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    <script src="{{ asset("assets/lib/codemirror/xml.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>

    <script src="{{ asset("assets/lib/codemirror/sublime.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
	<script src="{{ asset("assets/lib/codemirror/search.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
	<script src="{{ asset("assets/lib/codemirror/searchcursor.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
	<script src="{{ asset("assets/lib/codemirror/dialog.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>

{{-- End codemirror js --}}
@endif


@if(in_array("quill",$class))
{{-- quill - v1.3.6  --}}
    <script src="{{ asset("assets/lib/quill/quill.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End quill --}}
@endif
@if(in_array("emoji",$class))
{{-- emojionearea   --}}
    <script src="{{ asset("assets/js/emojionearea.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End emojionearea --}}
@endif

@if(in_array("jSignature",$class))
{{-- jSignature   --}}
    <script src="{{ asset('assets/lib/jSignature/jSignature.min.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End jSignature --}}
@endif
@if(in_array("pdf",$class))
{{-- pdf   --}}
    <script src="{{ asset('assets/lib/pdf/jspdf.min.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End pdf --}}
@endif
@if(in_array("square",$class))
{{-- square Payment getway    --}}
    <script src="https://sandbox.web.squarecdn.com/v1/square.js" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End square --}}
@endif

<script src="{{ asset('assets/js/core.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
<script src="{{ asset('assets/js/main.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>



<script src="{{ asset('assets/lib/inputmask/jquery.inputmask.min.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
<script src="{{ asset('assets/lib/inputmask/vanilla-text-mask.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
<script src="{{ asset('assets/lib/inputmask/text-mask-addons.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
<script src="{{ asset('assets/js/inputmask.js') }}" type="text/javascript" data-turbolinks-eval="false" data-turbolinks-suppress-warning></script>

{{-- Remodal Js --}}
<script src="{{ asset('assets/lib/remodal/dist/remodal.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
{{-- End Remodal Js --}}


@livewireScripts
{{-- Page Script  --}}
@stack('page_script')
{{-- End Page Script --}}
{{-- <script id="aioa-adawidget" src="https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=#000fff&token=&position=bottom_right"></script>
 --}}
<script src="{{ asset('assets/js/jsfunction.js') }}" type="text/javascript" data-turbolinks-eval="false" data-turbolinks-suppress-warning></script>
<script src="{{ asset('assets/js/validator.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
<script src="{{ asset('assets/js/common.js') }}" type="text/javascript"data-turbolinks-eval="false" data-turbolinks-suppress-warning></script>
<script src="{{ asset('assets/js/table-buttons.js') }}" type="text/javascript" data-turbolinks-track="reload" ></script>
<script src="{{ asset('assets/js/modal-alert.js') }}" type="text/javascript" data-turbolinks-eval="false" data-turbolinks-suppress-warning></script>
<script src="{{ asset('assets/js/dropdown.js') }}" type="text/javascript" data-turbolinks-eval="false" data-turbolinks-suppress-warning></script>

@stack('page_script_code')

@if(!empty($activePage))
    @php
        $activePage = Str::replaceFirst('company-', '', $activePage);
        $url = asset("assets/js/scripts/{$activePage}.js");
    @endphp
    @if(urlExists($url))
        <script src="{{ $url ?? '' }}" type="text/javascript" data-turbolinks-track="reload"></script>
    @else
      <script src="{{ asset("assets/js/scripts/form-submit.js") }}" type="text/javascript" data-turbolinks-track="reload"></script>
    @endif

    @if($activePage == 'quotes' && in_array("inMail",$class))
    <script src="{{ asset('assets/js/scripts/in-mail.js') }}" type="text/javascript" data-turbolinks-track="reload"></script>
    @endif
@endif
{{-- <div>
    <a href="http://localhost/enlaravel/enetworks/notice-templates/add" data-turbolinks-track="reload">Enabled</a>
</div> --}}
<script>
    document.addEventListener("turbolinks:before-visit", function() {
      Turbolinks.clearCache();
    })


</script>
