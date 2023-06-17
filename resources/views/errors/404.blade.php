@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
<p class="lead">{{ __('Not Found') }}</p>
@endsection
