@extends('admin.layout')
@section('title', __('locations.create_location'))
@section('content')
    @include('admin.common.header-line', ['header' => __('locations.create_location')])
    <form class="max-w-sm mx-auto" action="{{ route('admin.locations.store') }}" method="POST">
        @csrf
        @include('admin.locations.form')
        @include('admin.common.button-save')
    </form>
@endsection
