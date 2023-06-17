@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message')
<p class="lead">{{ __('Unauthorized') }}</p>
@endsection
