@extends('errors.illustrated-layout')

@section('code', '503')
@section('title', 'Service Unavailable')

@section('image')
<div style="background-image: url('/svg/500.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', $exception->getMessage() ?: 'Service Unavailable')
