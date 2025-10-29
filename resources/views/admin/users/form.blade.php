<div class="mb-5">
    <label for="name"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('users.name') }}</label>
    @error('name')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
<div class="mb-5">
    <label for="email"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('users.email') }}</label>
    @error('email')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
<div class="mb-5">
    <label for="password"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('users.password') }}</label>
    @error('password')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="password" name="password" value="{{ old('password') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
<div class="mb-5">
    <label for="password_confirmation"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('users.password_confirmation') }}</label>
    @error('password_confirmation')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <input type="text" id="password_confirmation" name="password_confirmation"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
<div class="mb-5">
    @error('active')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <div class="flex items-center mb-4">
        <input type="hidden" name="active" value="0">
        <input @checked(old('active', $user->active ?? false)) id="active" name="active" type="checkbox" value="1"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="active"
            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('users.active') }}</label>
    </div>
</div>
<div class="mb-5">
    @error('executor')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <div class="flex items-center mb-4">
        <input type="hidden" name="executor" value="0">
        <input @checked(old('active', $user->executor ?? false)) id="executor" name="executor" type="checkbox" value="1"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="executor"
            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('users.executor') }}</label>
    </div>
</div>
<div class="mb-5">
    @error('admin')
        <div class="mt-2 font-medium text-sm/6 text-red-500">{{ $message }}</div>
    @enderror
    <div class="flex items-center mb-4">
        <input type="hidden" name="admin" value="0">
        <input @checked(old('admin', $user->admin ?? false)) id="admin" name="admin" type="checkbox" value="1"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="admin"
            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('users.admin') }}</label>
    </div>
</div>
