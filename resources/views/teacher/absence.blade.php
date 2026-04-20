<x-app-layout>
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto space-y-6">

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

            <div class="bg-[#064e3b] rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center space-x-2 mb-2">
                        <span
                            class="px-2 py-1 bg-emerald-500/30 rounded text-[10px] font-bold uppercase tracking-widest">Live
                            Attendance</span>
                    </div>
                    <h1 class="text-3xl font-extrabold italic tracking-tight">Digital Attendance Sheet</h1>
                    <p class="text-emerald-200 mt-2 flex items-center text-sm">
                        <span class="material-symbols-outlined text-base mr-2">calendar_month</span>
                        {{ now()->format('l, F jS, Y') }}
                        <span class="mx-3 text-emerald-500">|</span>
                        <span class="material-symbols-outlined text-base mr-2">school</span>
                        Class: <span class="font-bold ml-1 text-white">{{ $classe->name }}</span>
                    </p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-6 -bottom-6 text-[12rem] opacity-10 rotate-12 select-none">
                    verified_user
                </span>
            </div>

            <form action="{{ route('absence.add') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $classe->id }}">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center text-gray-500">
                            <span class="material-symbols-outlined text-sm mr-2">group</span>
                            <span class="text-xs font-bold uppercase tracking-widest">Student Roster ({{
                                $classe->students->count() }})</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                            <span class="text-[11px] font-bold text-red-600 uppercase">Toggle to mark Absence</span>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-50">
                        @forelse($classe->students as $student)
                        <div
                            class="flex items-center justify-between px-6 py-4 hover:bg-emerald-50/30 transition-all group">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="h-11 w-11 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center font-bold text-gray-400 group-hover:bg-[#064e3b] group-hover:text-white group-hover:border-[#064e3b] transition-all duration-300">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 group-hover:text-[#064e3b] transition-colors">{{
                                        $student->name }}</p>
                                    <p class="text-xs text-gray-400 font-medium">{{ $student->email }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="absent_students[]" value="{{ $student->id }}"
                                        class="sr-only peer" {{ in_array($student->id, $todayAbsences) ? 'checked' : ''
                                    }}>

                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer
                                            peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                                            after:content-[''] after:absolute after:top-1 after:start-[4px] after:bg-white
                                            after:rounded-full after:h-5 after:w-5 after:transition-all
                                            peer-checked:bg-red-500 shadow-inner">
                                    </div>

                                    <span
                                        class="ms-3 text-[11px] font-black uppercase tracking-tighter transition-colors
                                            {{ in_array($student->id, $todayAbsences) ? 'text-red-600' : 'text-gray-300 group-hover:text-gray-400' }}">
                                        Absent
                                    </span>
                                </label>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-5xl text-gray-200 mb-2">person_off</span>
                            <p class="text-gray-400 font-medium italic">No students are currently enrolled in this
                                class.</p>
                        </div>
                        @endforelse
                    </div>

                    @if($classe->students->isNotEmpty())
                    <div
                        class="px-6 py-8 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <p class="text-xs text-gray-400 italic flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">info</span>
                            Changes are saved instantly to the school database.
                        </p>
                        <button type="submit"
                            class="w-full sm:w-auto bg-[#064e3b] hover:bg-[#065f46] text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-emerald-900/20 transition-all flex items-center justify-center group">
                            <span
                                class="material-symbols-outlined mr-2 group-hover:rotate-12 transition-transform">how_to_reg</span>
                            Submit Attendance
                        </button>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out forwards;
        }
    </style>
</x-app-layout>
