<x-app-layout>
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto space-y-6">

            <div class="bg-gradient-to-r from-[#064e3b] to-emerald-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold italic tracking-tight">Mes Notes</h1>
                        <p class="text-emerald-100 mt-2 opacity-90 font-medium">Suivi de vos performances académiques</p>
                    </div>

                    @if($grades->isNotEmpty())
                    <div class="mt-6 md:mt-0 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20">
                        <p class="text-[10px] uppercase font-bold tracking-widest text-emerald-200">Moyenne Générale</p>
                        <p class="text-4xl font-black">{{ number_format($average, 2) }} <span class="text-sm font-normal">pts</span></p>
                    </div>
                    @endif
                </div>
                <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-[10rem] opacity-10 rotate-12 select-none">grade</span>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                    <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Relevé détaillé</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 uppercase tracking-tighter border-b border-gray-50">
                                <th class="px-6 py-4">Activité / Évaluation</th>
                                <th class="px-6 py-4">Type</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4 text-right">Note obtenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($grades as $grade)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 mr-3"></div>
                                        <span class="font-bold text-gray-800">{{ $grade->activity->title }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-bold uppercase">
                                        {{ $grade->activity->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $grade->date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex flex-col items-end">
                                        <span class="text-lg font-black {{ $grade->score >= ($grade->activity->max_score / 2) ? 'text-emerald-700' : 'text-red-600' }}">
                                            {{ $grade->score }} <span class="text-xs text-gray-400 font-normal">/ {{ $grade->activity->max_score }}</span>
                                        </span>
                                        <div class="w-24 h-1 bg-gray-100 rounded-full mt-1 overflow-hidden">
                                            <div class="h-full {{ $grade->score >= ($grade->activity->max_score / 2) ? 'bg-emerald-500' : 'bg-red-500' }}"
                                                 style="width: {{ ($grade->score / $grade->activity->max_score) * 100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">history_edu</span>
                                    <p class="text-gray-400 font-medium">Aucune note n'a encore été enregistrée.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
