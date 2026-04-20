<x-app-layout>
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-full mx-auto space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 shadow-sm rounded-r-lg flex items-center">
                    <span class="material-symbols-outlined mr-2 text-emerald-600">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-white">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="material-symbols-outlined mr-2 text-emerald-600">person_add</span>
                        Student Management
                    </h2>
                </div>

                <form action="student-add" method="POST" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Name</label>
                            <input type="text" name="name" required class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Email</label>
                            <input type="email" name="email" required class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Password</label>
                            <input type="password" name="password" required class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Add To Class</label>
                            <select required name="classe_id" class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                <option disabled selected>Choose Student Class</option>
                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}"> {{ $classe->name }}</option>
                                @endforeach
                            </select>
                            @if (count($classes) === 0)
                                <p class="text-xs text-amber-600 mt-1 italic font-medium">There is no class, create one first.</p>
                            @endif
                            <input type="text" name="role" value="student" hidden>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-[#064e3b] hover:bg-[#065f46] text-white px-6 py-2 rounded-lg font-semibold text-sm transition-all shadow-md flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">add</span>
                            Add Student
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider">
                                <th class="px-6 py-4 border-b border-gray-100">Name</th>
                                <th class="px-6 py-4 border-b border-gray-100">Email</th>
                                <th class="px-6 py-4 border-b border-gray-100">Class</th>
                                <th class="px-6 py-4 border-b border-gray-100 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($students as $student)
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $student->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $student->email }}</td>
                                    <td class="px-6 py-4 text-gray-600">
                                        @forelse ($student->classesAsStudent as $classe)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                {{ $classe->name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic text-xs">No class assigned</span>
                                        @endforelse
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-4">
                                            <button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'student-edit'); $dispatch('set-edit-student', {{ json_encode($student) }})"
                                                class="text-gray-400 hover:text-emerald-600 transition-colors">
                                                <span class="material-symbols-outlined text-xl">edit_square</span>
                                            </button>
                                            <form action="{{ route('student-delete', $student->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this student?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">No students found in the database.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="student-edit">
        <div class="p-8" x-data="{ student: {}, classes: {{ json_encode($classes) }} }" x-on:set-edit-student.window="student = $event.detail">
            <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                <span class="material-symbols-outlined mr-2 text-emerald-600">edit</span>
                <h2 class="text-xl font-bold text-gray-800">Update Student Profile</h2>
            </div>

            <form method="POST" action="student-edit" class="space-y-5">
                @csrf
                <input type="hidden" name="id" x-bind:value="student.id">

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Full Name</label>
                    <input type="text" name="name" x-bind:value="student.name" required
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Email</label>
                    <input type="email" name="email" x-bind:value="student.email" required
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Student Class</label>
                    <select name="class_id" required class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="" disabled>Choose Student Class</option>
                        <template x-for="classe in classes" :key="classe.id">
                            <option :value="classe.id"
                                    x-text="classe.name"
                                    :selected="student.classes_as_student && student.classes_as_student.some(c => c.id === classe.id)">
                            </option>
                        </template>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700 transition">
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
