@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')
<p class="lead">{{ __($exception->getMessage() ?: 'Forbidden') }}</p>
@endsection
