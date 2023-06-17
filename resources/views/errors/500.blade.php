@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
@if(empty($exception->getMessage()))

    <p class="lead">Internal Server Error</p>
    <p class="lead">An unexpected error seems to have occurred. Why not try refreshing your page? Or you can contact us if the problem persists.</p>
@else
 <p class="lead">{{ $exception->getMessage() }}</p>
@endif
@endsection
