@extends('admin.layout')
@section('title', __('address.edit_address'))
@section('content')
    @include('admin.common.header-line', ['header' => __('address.edit_address')])
    <form class="max-w-lg mx-auto" action="{{ route('admin.addresses.update', $address) }}" method="POST">
        @method('PUT')
        @csrf
        @include('admin.addresses.form')
        @include('admin.common.button-save')
    </form>
@endsection
