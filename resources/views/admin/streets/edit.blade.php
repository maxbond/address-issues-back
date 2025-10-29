@extends('admin.layout')
@section('title', __('streets.edit_street'))
@section('content')
    @include('admin.common.header-line', ['header' => __('streets.edit_street')])
    <form class="max-w-sm mx-auto" action="{{ route('admin.streets.update', $street) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.streets.form')
        @include('admin.common.button-save')
    </form>
@endsection
