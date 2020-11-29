<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <x-auth-validation-errors class="mb-4" :errors="$errors" />


                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- First Name -->
                        <div>
                            <x-label for="first_name" :value="__('First Name')" />

                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                :value="old('first_name')" required autofocus />
                        </div>

                        <!--Last Name -->
                        <div class="mt-4">
                            <x-label for="last_name" :value="__('Last Name')" />

                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                :value="old('last_name')" required />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                                autocomplete="new-password" />
                        </div>

                        <!-- Travel Type -->
                        <div class="mt-4">
                            <x-label for="travel_type_id" :value="__('Travel Type')" />

                            <select id="travel_type_id"
                                class="block mt-1 w-full outline-none border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                name="travel_type_id" value="old('travel_type_id')" required>
                                <option value="">Select Travel Type</option>
                                @foreach ($travelTypes as $travelType)
                                    <option value="{{ $travelType['id'] }}">{{ $travelType['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Distance From Home -->
                        <div class="mt-4">
                            <x-label for="distance_from_home" :value="__('Distance From Home (km)')" />

                            <x-input id="distance_from_home" class="block mt-1 w-full" type="number"
                                name="distance_from_home" :value="old('distance_from_home')" required />
                        </div>

                        <!-- Is Admin -->
                        <div class="flex mt-6 space-x-2">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Admin') }}</span>
                            <label for="is_admin" class="inline-flex items-center">
                                <input id="is_admin" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    name="is_admin">
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
