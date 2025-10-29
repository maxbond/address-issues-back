@extends('admin.layout')
@section('title', __('users.create_user'))
@section('content')
    @include('admin.common.header-line', ['header' => __('users.create_user')])
    <form class="max-w-lg mx-auto" action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        @include('admin.users.form')
        @include('admin.common.button-save')
    </form>
@endsection
