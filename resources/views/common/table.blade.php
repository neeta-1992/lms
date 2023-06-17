@php
     $type = isset($type) ? $type: '' ;
@endphp
@if($type == 'css')
    <link href="{{ asset('/') }}assets/lib/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
@endif

@if($type == 'js')
    <script src="{{ asset('assets/lib/bootstrap-table/tableExport.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bootstrap-table/bootstrap-table.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bootstrap-table/bootstrap-table-export.min.js') }}" type="text/javascript"></script>
@endif