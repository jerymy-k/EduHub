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
                <div class="px-6 py-4 border-b border-gray-50 bg-white">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="material-symbols-outlined mr-2 text-emerald-600">class</span>
                        Class Management
                    </h2>
                </div>

                <form action="classe-add" method="POST" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Class Name</label>
                            <input type="text" name="class_name" required
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Assigned To</label>
                            <select name="teacher_id" required
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                <option disabled selected>Choose Teacher For This Class</option>
                                @foreach ($teacherNotAssigned as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @if (count($teacherNotAssigned) == 0)
                            <span class="text-xs text-amber-600 italic mt-1 inline-block">No available teachers.</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="bg-[#064e3b] hover:bg-[#065f46] text-white px-6 py-2 rounded-lg font-semibold text-sm transition-all shadow-md flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">add</span>
                            Add Class
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider">
                                <th class="px-6 py-4 border-b border-gray-100">Class Name</th>
                                <th class="px-6 py-4 border-b border-gray-100">Year</th>
                                <th class="px-6 py-4 border-b border-gray-100">Teacher</th>
                                <th class="px-6 py-4 border-b border-gray-100 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse ($classes as $classe)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $classe->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $classe->year }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    @forelse ($classe->teachers as $teacher)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ $teacher->name }}
                                    </span>
                                    @empty
                                    <span class="text-gray-400 italic font-light text-xs">No teacher assigned</span>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-4">
                                        <button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'view-students'); $dispatch('set-class-students', {{ json_encode($classe) }})"
                                            class="text-gray-400 hover:text-blue-600 transition-colors"
                                            title="Student List">
                                            <span class="material-symbols-outlined text-xl">groups</span>
                                        </button>

                                        <button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal' , 'classe-edit'); $dispatch('set-edit-classe' ,{{ json_encode($classe) }})"
                                            class="text-gray-400 hover:text-emerald-600 transition-colors">
                                            <span class="material-symbols-outlined text-xl">edit_square</span>
                                        </button>

                                        <form action="{{ route('classe-delete', $classe->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this Class?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-500 transition-colors">
                                                <span class="material-symbols-outlined text-xl">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">No classes found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="view-students">
        <div class="p-8" x-data="{ currentClass: { name: '', students: [] } }"
            x-on:set-class-students.window="currentClass = $event.detail">

            <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                <div class="flex items-center">
                    <span class="material-symbols-outlined mr-2 text-emerald-600">groups</span>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800" x-text="'Class: ' + currentClass.name"></h2>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-tight tracking-wider">Student
                            Roster</p>
                    </div>
                </div>
            </div>

            <div class="max-h-96 overflow-y-auto rounded-lg border border-gray-100">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                        <tr>
                            <th class="px-4 py-3 border-b">Student Name</th>
                            <th class="px-4 py-3 border-b">Email</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        <template x-for="student in currentClass.students" :key="student.id">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-900 font-medium" x-text="student.name"></td>
                                <td class="px-4 py-3 text-gray-500" x-text="student.email"></td>
                            </tr>
                        </template>
                        <template x-if="!currentClass.students || currentClass.students.length === 0">
                            <tr>
                                <td colspan="2" class="px-4 py-10 text-center text-gray-400 italic">No students
                                    enrolled.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold text-sm transition-all">
                    Close Window
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal name="classe-edit">
        <div class="p-8" x-data="{ classe: {}, allTeachers: {{ json_encode($allTeachers) }} }"
            x-on:set-edit-classe.window="classe = $event.detail">
            <div class="flex items-center mb-6">
                <span class="material-symbols-outlined mr-2 text-emerald-600">edit_note</span>
                <h2 class="text-xl font-bold text-gray-800">Update Class Details</h2>
            </div>

            <form action="classe-edit" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="id" x-bind:value="classe.id">

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Class Name</label>
                    <input type="text" name="class_name" x-bind:value="classe.name"
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Assigned Teacher</label>
                    <select name="teacher_id" required x-model="classe.teacher_id"
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="" disabled>Choose Teacher</option>
                        <template x-for="teacher in allTeachers">
                            <option :value="teacher.id" x-text="teacher.name"
                                :selected="classe.teachers && classe.teachers.length > 0 && teacher.id === classe.teachers[0].id">
                            </option>
                        </template>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700">Cancel</button>
                    <button type="submit"
                        class="bg-[#064e3b] hover:bg-[#065f46] text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-all">
                        Update Class
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
