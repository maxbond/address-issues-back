<div class="mb-5">
    <label for="location"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('locations.location') }}</label>
    @error('location')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <select id="location" name="location_id"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        @foreach ($locations as $location)
            <option value="{{ $location->id }}" @selected(old('location_id', $street->location_id ?? null) == $location->id)>{{ $location->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-5">
    <label for="name"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('streets.name') }}</label>
    @error('name')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="name" name="name" value="{{ old('name', $street->name ?? '') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
