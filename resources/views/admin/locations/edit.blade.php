@extends('admin.layout')
@section('title', __('locations.edit_location'))
@section('content')
    @include('admin.common.header-line', ['header' => __('locations.edit_location')])
    <form class="max-w-sm mx-auto" action="{{ route('admin.locations.update', $location) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.locations.form')
        @include('admin.common.button-save')
    </form>
@endsection
