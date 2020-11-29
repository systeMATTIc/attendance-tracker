<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h4 class="text-xl mb-10">Travel Compensation Report</h4>

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form action="{{ route('reports.travel-compensation') }}">
                        <div class="flex space-x-4 items-end">
                            <!-- Month -->
                            <div>
                                <x-label for="month" :value="__('Month')" />

                                <x-input id="month" class="block mt-1 w-full" type="number" max="12" name="month"
                                    placeholder="02" :value="old('month')" required autofocus />
                            </div>
                            <!-- Year -->
                            <div>
                                <x-label for="year" :value="__('Year')" />

                                <x-input id="year" class="block mt-1 w-full" type="number" name="year"
                                    :value="old('year')" placeholder="2020" required />
                            </div>
                            <div>
                                <x-button class="py-3">
                                    {{ __('Download') }}
                                </x-button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
