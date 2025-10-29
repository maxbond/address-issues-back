@extends('admin.layout')
@section('title', __('users.users'))
@section('content')
    @include('admin.common.header-line', ['header' => __('users.users')])
    <div class="mt-3">
        @include('admin.common.button-create', ['route' => route('admin.users.create')])
    </div>
    <div class="mt-3 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('users.name') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('users.email') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('users.active') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('users.executor') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('users.admin') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('users.deleted_at') }}
                    </th>
                    <th scope="col" class="px-6 py-3">

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->id }}
                        </th>
                        <td class="px-6 py-4 text-leftt font-bold">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            @includeWhen($user->active, 'admin.common.boolean-indicator')
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            @includeWhen($user->executor, 'admin.common.boolean-indicator')

                        </td>
                        <td class="px-6 py-4 text-leftt">
                            @includeWhen($user->admin, 'admin.common.boolean-indicator')

                        </td>
                        <td class="px-6 py-4 text-leftt">
                            @if ($user->deleted_at)
                                {{ $user->deleted_at }}
                            @endIf
                        </td>
                        <td class="px-6 py-4 text-right flex items-center">
                            @if (!$user->deleted_at)
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('form.edit') }}</a>
                                <a href="#"
                                    onclick="document.getElementById('form_delete_{{ $user->id }}').submit()"
                                    class="font-medium
                                text-blue-600 dark:text-blue-500 hover:underline ms-3">{{ __('form.delete') }}</a>
                                <form id="form_delete_{{ $user->id }}" style="display: none" method="POST"
                                    action="{{ route('admin.users.destroy', $user) }}">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            @else
                                <a onclick="document.getElementById('form_restore_{{ $user->id }}').submit()"
                                    href="#"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('form.restore') }}</a>
                                <form id="form_restore_{{ $user->id }}" style="display: none" method="POST"
                                    action="{{ route('admin.users.restore', $user) }}">
                                    @method('PUT')
                                    @csrf
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{ $users->links() }}
    </div>


@endsection
