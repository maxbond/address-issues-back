@extends('admin.layout')
@section('title', __('users.edit_user'))
@section('content')
    @include('admin.common.header-line', ['header' => __('users.edit_user')])
    <form class="max-w-lg mx-auto" action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.users.form')
        @include('admin.common.button-save')
    </form>
@endsection
