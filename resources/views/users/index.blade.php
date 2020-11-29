<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="px-6 sm:px-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto mt-12">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="flex justify-end mb-4">
                    <a href="{{ route('users.create') }}"
                        class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                        New User
                    </a>
                </div>

                <div class="overflow-x-auto bg-white border border-gray-300 rounded-lg overflow-y-auto relative mb-4">
                    {{-- style="height: 600px;"> --}}
                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                        <thead>
                            <tr class="text-left">
                                <th
                                    class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    First Name
                                </th>
                                <th
                                    class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    Last Name
                                </th>
                                <th
                                    class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    Email
                                </th>
                                <th
                                    class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    Travel Type
                                </th>
                                <th
                                    class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border-dashed border-t border-gray-200">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            {{ $user->first_name }}</span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            {{ $user->last_name }}</span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            {{ $user->email }}</span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            {{ $travelTypes->firstWhere('id', $user->travel_type_id)['name'] }}</span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            <a href="{{ route('users.edit', ['user' => $user->uuid]) }}"
                                                title="Edit User">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 text-gray-400 hover:text-gray-200" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
