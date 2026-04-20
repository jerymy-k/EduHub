<x-app-layout>
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-full mx-auto space-y-6">

            @if (session('success'))
                <div
                    class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 shadow-sm rounded-r-lg flex items-center">
                    <span class="material-symbols-outlined mr-2">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-white">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="material-symbols-outlined mr-2 text-emerald-600">person_add</span>
                        Teacher Management
                    </h2>
                </div>

                <form method="POST" action="teacher-add" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Name</label>
                            <input type="text" name="name" required
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Email
                                Address</label>
                            <input type="email" name="email" required
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Password</label>
                            <input type="password" name="password" required
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Phone Number</label>
                            <input type="text" name="phone" maxlength="10" placeholder="0612345678"
                                pattern="0[5-7][0-9]{8}"
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <input type="text" name="role" hidden value="teacher">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="bg-[#064e3b] hover:bg-[#065f46] text-white px-6 py-2 rounded-lg font-semibold text-sm transition-all shadow-md flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">add</span>
                            Add Teacher
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider">
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Phone</th>
                                <th class="px-6 py-4">Assigned Class</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse ($teachers as $teacher)
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $teacher->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $teacher->email }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $teacher->phone }}</td>
                                    <td class="px-6 py-4">
                                        @forelse ($teacher->classesAsTeacher as $classe)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                {{ $classe->name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic">No class assigned</span>
                                        @endforelse
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-4">
                                            <button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'teacher-edit'); $dispatch('set-edit-teacher', {{ json_encode($teacher) }})"
                                                class="text-gray-400 hover:text-emerald-600 transition-colors">
                                                <span class="material-symbols-outlined">edit_square</span>
                                            </button>
                                            <form action="{{ route('teacher-delete', $teacher->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this teacher?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-red-500 transition-colors">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">No teachers
                                        found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="teacher-edit">
        <div class="p-8" x-data="{ teacher: {} }" x-on:set-edit-teacher.window="teacher = $event.detail">
            <div class="flex items-center mb-6">
                <span class="material-symbols-outlined mr-2 text-emerald-800">edit</span>
                <h2 class="text-xl font-bold text-gray-800">Update Teacher Profile</h2>
            </div>

            <form method="POST" action="teacher-edit" class="space-y-5">
                @csrf
                <input type="hidden" name="id" x-bind:value="teacher.id">

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase">Full Name</label>
                    <input type="text" name="name" x-bind:value="teacher.name"
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase">Email</label>
                    <input type="email" name="email" x-bind:value="teacher.email"
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase">Phone</label>
                    <input type="text" name="phone" x-bind:value="teacher.phone"
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500">
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-[#064e3b] hover:bg-[#065f46] text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-all">
                        Update Record
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
