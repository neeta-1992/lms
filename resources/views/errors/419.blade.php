@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message')
<p class="lead">{{ __('Page Expired') }}</p>
@endsection
