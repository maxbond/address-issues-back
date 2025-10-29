@extends('admin.layout')
@section('title', __('address.create_address'))
@section('content')
    @include('admin.common.header-line', ['header' => __('address.create_address')])
    <form class="max-w-lg mx-auto" action="{{ route('admin.addresses.store') }}" method="POST">
        @csrf
        @include('admin.addresses.form')
        @include('admin.common.button-save')
    </form>
@endsection
