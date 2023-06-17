@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message')
<p class="lead">{{ __('Too Many Requests') }}</p>
@endsection
