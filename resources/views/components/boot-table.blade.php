<div class="table-responsive-sm">
@php
    dd('dddd');
@endphp
    <table

    >
   {{-- Table Html Body Append --}}
        {{ $slot ?? '' }}
    </table>


</div>


