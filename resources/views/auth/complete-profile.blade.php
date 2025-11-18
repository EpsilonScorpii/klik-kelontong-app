<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complete Your Profile - Klik Kelontong</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <a href="{{ route('verification.notice') }}" class="absolute top-6 left-6 text-gray-700">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </a>

    <div class="flex items-center justify-center min-h-screen py-12 px-6">
        <div class="w-full max-w-sm">

            <h1 class="text-4xl font-bold text-gray-900 text-center">
                Complete Your Profile
            </h1>

            <p class="text-gray-600 text-center mt-2">
                Don't worry, only you can see your personal data. No one else will be able to see it.
            </p>

            <div class="flex justify-center my-8">
                <div class="relative">
                    <span class="inline-block h-32 w-32 rounded-full overflow-hidden bg-gray-100">
                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                    <button class="absolute bottom-1 right-1 bg-white p-2 rounded-full shadow border border-gray-200">
                        <svg class="w-5 h-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </button>
                </div>
            </div>

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />

            <form method="POST" action="{{ route('profile.store') }}">
                @csrf

                <div class="mt-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                        placeholder="Jahri">
                </div>

                <div class="mt-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <div class="flex mt-1">
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                            +62
                        </span>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                               class="block w-full rounded-r-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="8123456789">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="gender" required
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="" disabled selected>Select</option>
                        <option value="male" @if(old('gender') == 'male') selected @endif>Male</option>
                        <option value="female" @if(old('gender') == 'female') selected @endif>Female</option>
                        <option value="other" @if(old('gender') == 'other') selected @endif>Prefer not to say</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full text-center bg-green-700 text-white py-3 px-4 rounded-lg font-semibold text-lg mt-8 hover:bg-green-800 transition duration-300">
                    Complete Profile
                </button>
            </form>

        </div>
    </div>
</body>
</html>