<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-6">
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

            <div class="bg-gradient-to-r from-[#064e3b] to-emerald-700 rounded-2xl p-8 text-white shadow-xl">
                <h1 class="text-3xl font-black italic">Validation des Justificatifs</h1>
                <p class="text-emerald-100 opacity-80">Gérez les preuves d'absence soumises par les parents.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <th class="px-6 py-4">Élève</th>
                            <th class="px-6 py-4">Date Absence</th>
                            <th class="px-6 py-4">Motif / Document</th>
                            <th class="px-6 py-4">Statut Actuel</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($justifications as $j)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-800">{{ $j->absence->student->name }}</p>
                                <p class="text-xs text-gray-400">{{ $j->absence->class_->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $j->absence->date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700 mb-2 italic">"{{ $j->reason }}"</p>
                                <a href="{{ asset('storage/' . $j->document_path) }}" target="_blank"
                                    class="inline-flex items-center text-xs font-bold text-emerald-600 hover:underline">
                                    <span class="material-symbols-outlined text-sm mr-1">picture_as_pdf</span>
                                    Voir le document
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                                    {{ $j->status == 'pending' ? 'bg-amber-100 text-amber-700' : ($j->status == 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $j->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($j->status == 'pending')
                                <div class="flex justify-end space-x-2">
                                    <form action="{{ route('admin.justifications.update', $j->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button
                                            class="bg-emerald-600 text-white p-2 rounded-lg hover:bg-emerald-700 shadow-sm"
                                            title="Accepter">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.justifications.update', $j->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="refused">
                                        <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 shadow-sm"
                                            title="Refuser">
                                            <span class="material-symbols-outlined text-sm">close</span>
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="text-xs text-gray-300 italic">Traité</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
