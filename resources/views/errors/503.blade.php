@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message')
<p class="lead">{{ __('Service Unavailable') }}</p>
@endsection
