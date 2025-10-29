@extends('admin.layout')
@section('title', __('address.addresses'))
@section('content')
    @include('admin.common.header-line', ['header' => __('address.addresses')])
    <div class="mt-3">
        @include('admin.common.button-create', ['route' => route('admin.addresses.create')])
    </div>
    <div class="mt-3 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('streets.street') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('address.house') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('address.flat') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('address.floor') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('address.entrance') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('address.entrance_is_locked') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('address.has_gate') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('address.comment') }}
                    </th>
                    <th scope="col" class="px-6 py-3">

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($addresses as $address)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $address->id }}
                        </th>
                        <td class="px-6 py-4 text-leftt">
                            {{ $address->street->location->name }}, {{ $address->street->name }}
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            {{ $address->house }}
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            {{ $address->flat }}
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            {{ $address->floor }}
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            {{ $address->entrance }}
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            @includeWhen($address->entrance_is_locked, 'admin.common.boolean-indicator')
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            @includeWhen($address->has_gate, 'admin.common.boolean-indicator')
                        </td>
                        <td class="px-6 py-4 text-leftt">
                            {{ $address->comment }}
                        </td>
                        <td class="px-6 py-4 text-right flex items-center">
                            <a href="{{ route('admin.addresses.edit', $address) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('form.edit') }}</a>
                            <a href="#" onclick="document.getElementById('form_delete_{{ $address->id }}').submit()"
                                class="font-medium
                                text-blue-600 dark:text-blue-500 hover:underline ms-3">{{ __('form.delete') }}</a>
                            <form id="form_delete_{{ $address->id }}" style="display: none" method="POST"
                                action="{{ route('admin.addresses.destroy', $address) }}">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{ $addresses->links() }}
    </div>


@endsection
