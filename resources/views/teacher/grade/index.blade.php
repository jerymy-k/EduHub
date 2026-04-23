<x-app-layout>
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-6">
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
            <div class="bg-[#064e3b] rounded-2xl p-6 text-white shadow-lg flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold italic">Grades Management</h1>
                    <p class="text-emerald-200 text-sm">Create activities and record student performance</p>
                </div>
                <button x-data="" x-on:click="$dispatch('open-modal', 'add-activity')"
                    class="bg-emerald-500 hover:bg-emerald-400 text-white px-4 py-2 rounded-xl font-bold transition-all flex items-center">
                    <span class="material-symbols-outlined mr-2">add_task</span> New Activity
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-xs uppercase text-gray-500 font-bold tracking-widest">
                            <th class="px-6 py-4">Activity</th>
                            <th class="px-6 py-4">Class</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Max Score</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($activities as $activity)
                        <tr class="hover:bg-emerald-50/20">
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $activity->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $activity->class_->name }}</td>
                            <td class="px-6 py-4 italic text-sm">{{ $activity->type }}</td>
                            <td class="px-6 py-4 font-mono text-emerald-700">{{ $activity->max_score }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('grades.enter', $activity->id) }}"
                                    class="text-[#064e3b] hover:underline font-bold text-sm flex items-center justify-center">
                                    <span class="material-symbols-outlined text-sm mr-1">edit_note</span> Enter Grades
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal name="add-activity">
        <form action="{{ route('activity.store') }}" method="POST" class="p-8 space-y-4">
            @csrf
            <h2 class="text-xl font-bold text-gray-800 mb-4">Create New Assessment</h2>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Title</label>
                    <input type="text" name="title" required class="w-full border-gray-200 rounded-lg">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase">Class</label>
                    <select name="class_id" required class="w-full border-gray-200 rounded-lg">
                        @foreach($classes as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase">Type</label>
                    <select name="type" class="w-full border-gray-200 rounded-lg">
                        <option value="Exam">Exam</option>
                        <option value="Quiz">Quiz</option>
                        <option value="Homework">Homework</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase">Max Score</label>
                    <input type="number" name="max_score" value="20" step="0.5"
                        class="w-full border-gray-200 rounded-lg">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase">Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}"
                        class="w-full border-gray-200 rounded-lg">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#064e3b] text-white px-6 py-2 rounded-xl font-bold shadow-md">Create
                    Activity</button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
