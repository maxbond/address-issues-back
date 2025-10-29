@extends('admin.layout')
@section('title', __('streets.create_street'))
@section('content')
    @include('admin.common.header-line', ['header' => __('streets.create_street')])
    <form class="max-w-sm mx-auto" action="{{ route('admin.streets.store') }}" method="POST">
        @csrf
        @include('admin.streets.form')
        @include('admin.common.button-save')
    </form>
@endsection
