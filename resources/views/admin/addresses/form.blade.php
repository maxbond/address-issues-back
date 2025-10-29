<div class="mb-5">
    <label for="street_id"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('streets.street') }}</label>
    @error('street_id')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <select id="street_id" name="street_id"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        @foreach ($streets as $street)
            <option value="{{ $street->id }}" @selected(old('street_id', $address->street_id ?? null) == $street->id)>{{ $street->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-5">
    <label for="house"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('address.house') }}</label>
    @error('house')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="house" name="house" value="{{ old('house', $address?->house ?? '') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/6 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
<div class="mb-5">
    <label for="flat"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('address.flat') }}</label>
    @error('flat')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="flat" name="flat" value="{{ old('flat', $address->flat ?? '') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/6 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
<div class="mb-5">
    <label for="floor"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('address.floor') }}</label>
    @error('floor')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="floor" name="floor" value="{{ old('flat', $address->floor ?? '') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/6 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
<div class="mb-5">
    <label for="entrance"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('address.entrance') }}</label>
    @error('entrance')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="entrance" name="entrance" value="{{ old('entrance', $address->entrance ?? '') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/6 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
<div class="mb-5">
    @error('entrance_is_locked')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <div class="flex items-center mb-4">
        <input type="hidden" name="entrance_is_locked" value="0">
        <input @checked(old('entrance_is_locked', $address->entrance_is_locked ?? false)) id="entrance_is_locked" name="entrance_is_locked" type="checkbox"
            value="1"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="entrance_is_locked"
            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('address.entrance_is_locked') }}</label>
    </div>
</div>
<div class="mb-5">
    @error('has_gate')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <div class="flex items-center mb-4">
        <input type="hidden" name="has_gate" value="0">
        <input @checked(old('has_gate', $address->has_gate ?? false)) id="has_gate" name="has_gate" type="checkbox" value="1"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="has_gate"
            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('address.has_gate') }}</label>
    </div>
</div>
<div class="mb-5">
    @error('comment')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <label for="comment"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('address.comment') }}</label>
    <textarea id="comment" name="comment" rows="4"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('comment', $address->comment ?? '') }}</textarea>
</div>
