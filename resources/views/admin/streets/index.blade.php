@extends('admin.layout')
@section('title', __('streets.streets'))
@section('content')
    @include('admin.common.header-line', ['header' => __('streets.streets')])
    <div class="mt-3">
        @include('admin.common.button-create', ['route' => route('admin.streets.create')])
    </div>
    <div class="mt-3 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('locations.location') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('streets.name') }}
                    </th>
                    <th scope="col" class="px-6 py-3">

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($streets as $street)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $street->id }}
                        </th>
                        <td class="px-6 py-4 text-leftt">
                            {{ $street->location->name }}
                        </td>
                        <td class="px-6 py-4 text-leftt w-full font-bold">
                            {{ $street->name }}
                        </td>
                        <td class="px-6 py-4 text-right flex items-center">
                            <a href="{{ route('admin.streets.edit', $street) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('form.edit') }}</a>
                            <a href="#" onclick="document.getElementById('form_delete_{{ $street->id }}').submit()"
                                class="font-medium
                                text-blue-600 dark:text-blue-500 hover:underline ms-3">{{ __('form.delete') }}</a>
                            <form id="form_delete_{{ $street->id }}" style="display: none" method="POST"
                                action="{{ route('admin.streets.destroy', $street) }}">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{ $streets->links() }}
    </div>


@endsection
