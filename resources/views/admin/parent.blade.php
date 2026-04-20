<x-app-layout>
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-full mx-auto space-y-6">

            @if (session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 shadow-sm rounded-r-lg flex items-center">
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
                        <span class="material-symbols-outlined mr-2 text-emerald-600">family_restroom</span>
                        Parent Management
                    </h2>
                </div>

                <form action="{{ route('parent-add') }}" method="POST" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Parent Name</label>
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
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Assign Students
                                (Hold Ctrl to select many)</label>
                            <select name="student_id[]" multiple required
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm min-h-[40px]">
                                @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Password</label>
                            <input type="password" name="password" required
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-tight">Phone Number</label>
                            <input type="text" name="phone" placeholder="06XXXXXXXX"
                                class="w-full border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <input type="hidden" name="role" value="parent">
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="bg-[#064e3b] hover:bg-[#065f46] text-white px-6 py-2 rounded-lg font-semibold text-sm transition-all shadow-md flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">person_add</span>
                            Register Parent
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider">
                                <th class="px-6 py-4 border-b border-gray-100">Parent</th>
                                <th class="px-6 py-4 border-b border-gray-100">Contact</th>
                                <th class="px-6 py-4 border-b border-gray-100">Children (Students)</th>
                                <th class="px-6 py-4 border-b border-gray-100 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($parents as $parent)
                            <tr class="hover:bg-emerald-50/30 transition-colors text-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $parent->name }}</td>
                                <td class="px-6 py-4 border-black">
                                    <div class="flex flex-col">
                                        <span>{{ $parent->email }}</span>
                                        <span class="text-xs text-emerald-600 font-bold">{{ $parent->phone ?? 'No Phone'
                                            }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @forelse($parent->childrenAsParent as $child)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100 mr-1 mb-1">
                                        {{ $child->name }}
                                    </span>
                                    @empty
                                    <span class="text-gray-300 italic text-xs">No children linked</span>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-3">
                                        <button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'parent-edit'); $dispatch('set-edit-parent', {{ json_encode($parent) }})"
                                            class="text-gray-400 hover:text-emerald-600 transition-colors">
                                            <span class="material-symbols-outlined text-xl">edit_square</span>
                                        </button>
                                        <form action="{{ route('parent-delete', $parent->id) }}" method="POST"
                                            onsubmit="return confirm('Remove this parent?')">
                                            @csrf @method('DELETE')
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
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">No parent records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="parent-edit">
        <div class="p-8" x-data="{ parent: {} }" x-on:set-edit-parent.window="parent = $event.detail">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <span class="material-symbols-outlined mr-2 text-emerald-600">edit</span>
                Update Parent Profile
            </h2>
            <form action="{{ route('parent-edit') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="id" :value="parent.id">

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase">Name</label>
                    <input type="text" name="name" :value="parent.name"
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase">Email</label>
                    <input type="email" name="email" :value="parent.email"
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase">Phone Number</label>
                    <input type="text" name="phone" :value="parent.phone"
                        class="w-full border-gray-200 rounded-lg focus:ring-emerald-500">
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="text-gray-400 font-semibold text-sm">Cancel</button>
                    <button type="submit"
                        class="bg-[#064e3b] text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md">
                        Update Record
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
