<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->routeIs('my-attendances.*') ? __('My Attendance Log') : __('Attendances') }}
        </h2>
    </x-slot>

    <div class="px-6 sm:px-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto py-14">
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if (request()->routeIs('my-attendances.*'))
                    <div class="flex justify-end mb-4">
                        <form method="POST" action="{{ route('my-attendances.store') }}">
                            @csrf
                            <button type="submit"
                                class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                                Log Attendance
                            </button>
                        </form>
                    </div>
                @endif

                <div class="overflow-x-auto bg-white border border-gray-300 rounded-lg overflow-y-auto relative mb-4">
                    {{-- style="height: 600px;"> --}}
                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                        <thead>
                            <tr class="text-left">
                                <th
                                    class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    Employee
                                </th>
                                <th
                                    class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    Time In
                                </th>
                                <th
                                    class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    Time Out
                                </th>
                                @if (request()->routeIs('my-attendances.*'))
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        Actions
                                    </th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td class="border-dashed border-t border-gray-200">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            {{ $attendance->user->name }}
                                        </span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            {{ $attendance->time_in->toDayDateTimeString() }}
                                        </span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            {{ $attendance->time_out ? $attendance->time_out->toDayDateTimeString() : null }}
                                        </span>
                                    </td>
                                    @if (request()->routeIs('my-attendances.*'))
                                        <td class="border-dashed border-t border-gray-200">
                                            @if (is_null($attendance->time_out))
                                                <span class="text-gray-700 px-6 py-3 flex items-center">
                                                    <a href="{{ route('my-attendances.check-out', ['attendance' => $attendance->uuid]) }}"
                                                        title="Clock out">
                                                        <svg class="h-4 w-4 text-gray-400 hover:text-gray-200"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            @endif

                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $attendances->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
