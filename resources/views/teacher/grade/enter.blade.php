<x-app-layout>
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('grades.index') }}" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="text-2xl font-bold text-gray-800 italic uppercase">{{ $activity->title }} <span
                        class="text-gray-400 font-light">/ Entry</span></h1>
            </div>

            <form action="{{ route('grades.store', $activity->id) }}" method="POST">
                @csrf
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-bold text-gray-500 uppercase tracking-widest">
                                <th class="px-6 py-4 italic uppercase tracking-tighter">Student Name</th>
                                <th class="px-6 py-4 text-right">Score (Max: {{ $activity->max_score }})</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($activity->class_->students as $student)
                            @php $existingGrade = $activity->grades->where('student_id', $student->id)->first(); @endphp
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700">{{ $student->name }}</td>
                                <td class="px-6 py-4 flex justify-end">
                                    <input type="number" name="grades[{{ $student->id }}]"
                                        value="{{ $existingGrade ? $existingGrade->score : '' }}" step="0.25" min="0"
                                        max="{{ $activity->max_score }}" placeholder="0.00"
                                        class="w-24 text-right border-gray-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 font-mono font-bold text-emerald-800">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="p-6 bg-gray-50 border-t flex justify-end">
                        <button type="submit"
                            class="bg-[#064e3b] text-white px-10 py-3 rounded-xl font-bold shadow-lg">Save All
                            Grades</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
