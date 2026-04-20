<x-app-layout>
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto space-y-6">

            <div class="bg-gradient-to-r from-[#064e3b] to-[#022c22] rounded-2xl p-8 shadow-xl relative overflow-hidden border border-emerald-800">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold italic tracking-tight text-white" style="color: white !important;">Mes Absences</h1>
                        <p class="text-emerald-200 mt-2 font-medium" style="color: #a7f3d0 !important;">Suivi des présences et justificatifs</p>
                    </div>

                    <div class="flex space-x-4 mt-6 md:mt-0">
                        <div class="bg-black/30 backdrop-blur-md rounded-xl p-4 border border-white/10 text-center min-w-[120px]">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-emerald-300">Total</p>
                            <p class="text-3xl font-black text-white" style="color: white !important;">{{ $totalAbsences }}</p>
                        </div>
                        <div class="bg-red-900/40 backdrop-blur-md rounded-xl p-4 border border-red-500/20 text-center min-w-[120px]">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-red-300">Non Justifiées</p>
                            <p class="text-3xl font-black text-white" style="color: white !important;">{{ $unexcusedCount }}</p>
                        </div>
                    </div>
                </div>
                <span class="material-symbols-outlined absolute -right-4 -bottom-8 text-[12rem] text-white opacity-[0.05] rotate-12 select-none">calendar_today</span>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                    <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Historique des Absences</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 uppercase tracking-tighter border-b border-gray-50">
                                <th class="px-6 py-4">Date de l'absence</th>
                                <th class="px-6 py-4">Classe</th>
                                <th class="px-6 py-4">Enseignant</th>
                                <th class="px-6 py-4 text-right">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($absences as $absence)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="material-symbols-outlined text-gray-400 mr-3 text-sm">event</span>
                                        <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($absence->date)->format('l d F Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                    {{ $absence->class_->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 italic">
                                    M. {{ $absence->teacher->name }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @php
                                        $statusColors = [
                                            'unexcused' => 'bg-red-100 text-red-700 border-red-200',
                                            'pending'   => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'justified' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'refused'   => 'bg-gray-100 text-gray-700 border-gray-200',
                                        ];
                                        $statusLabel = [
                                            'unexcused' => 'Non justifiée',
                                            'pending'   => 'En attente',
                                            'justified' => 'Justifiée',
                                            'refused'   => 'Refusée',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border {{ $statusColors[$absence->status] }}">
                                        {{ $statusLabel[$absence->status] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                                            <span class="material-symbols-outlined text-3xl text-emerald-500">verified</span>
                                        </div>
                                        <p class="text-gray-800 font-bold">Félicitations !</p>
                                        <p class="text-gray-400 text-sm">Vous n'avez aucune absence enregistrée.</p>
                                    </div>
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
