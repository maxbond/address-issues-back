@extends('admin.layout')
@section('title', __('auth.login_form'))
@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black dark:text-white">
                {{ __('auth.signin') }}</h2>
        </div>
        @error('failed')
            <div class="mt-3 text-center font-bold text-xl/3 text-red-500 dark:text-red-300">{{ $message }}</div>
        @enderror
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="{{ route('authenticate') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email"
                        class="block text-sm/6 font-medium text-gray-900 dark:text-white">{{ __('auth.email_field') }}</label>
                    @error('email')
                        <div class="mt-2 font-medium text-sm/6 text-red-500 dark:text-red-300">{{ $message }}</div>
                    @enderror
                    <div class="mt-2">
                        <input id="email" type="email" value="{{ old('email') }}" name="email" autocomplete="email"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-blue-400 placeholder:text-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6 dark:text-white" />
                    </div>

                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password"
                            class="block text-sm/6 font-medium text-gray-900 dark:text-white">{{ __('auth.password_field') }}</label>
                    </div>
                    @error('password')
                        <div class="mt-2 font-medium text-sm/6 text-red-500 dark:text-red-300">{{ $message }}</div>
                    @enderror
                    <div class="mt-2">
                        <input id="password" type="password" value="{{ old('password') }}" name="password"
                            autocomplete="current-password"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-blue-400 placeholder:text-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6 dark:text-white" />
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full cursor-pointer justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center text-sm dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('auth.login') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
