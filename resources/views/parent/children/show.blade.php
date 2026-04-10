<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto space-y-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('parent.children') }}" class="text-gray-400 hover:text-emerald-600"><span
                        class="material-symbols-outlined">arrow_back</span></a>
                <h1 class="text-2xl font-bold text-[#064e3b]">Détails de scolarité : {{ $child->name }}</h1>
            </div>

            <section class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                <div class="p-4 bg-emerald-50 border-b border-emerald-100 flex items-center">
                    <span class="material-symbols-outlined mr-2 text-emerald-600">grade</span>
                    <h2 class="font-bold text-emerald-800 uppercase text-xs tracking-widest">Dernières Notes</h2>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y">
                        @foreach($child->gradesAsStudent as $grade)
                        <tr>
                            <td class="px-6 py-4 font-bold text-gray-700">{{ $grade->activity->title }}</td>
                            <td class="px-6 py-4 text-right font-black text-emerald-600">{{ $grade->score }}/{{
                                $grade->activity->max_score }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

            <section class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                <div class="p-4 bg-red-50 border-b border-red-100 flex items-center">
                    <span class="material-symbols-outlined mr-2 text-red-600">calendar_today</span>
                    <h2 class="font-bold text-red-800 uppercase text-xs tracking-widest">Absences et Justificatifs</h2>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y">
                        @foreach($child->absencesAsStudent as $absence)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($absence->date)->format('d M
                                    Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $absence->class_->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $absence->status == 'unexcused' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                    {{ $absence->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($absence->justification)
                                {{-- If justification exists, show status badge and NO button --}}
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    Soumis ({{ $absence->justification->status }})
                                </span>
                                @else
                                {{-- If no justification exists, show the button --}}
                                <button x-data="" x-on:click="$dispatch('open-modal', 'justify-{{ $absence->id }}')"
                                    class="text-xs bg-[#064e3b] text-white px-4 py-2 rounded-xl font-bold hover:bg-emerald-800 transition shadow-sm">
                                    Justifier
                                </button>
                                @endif
                            </td>
                        </tr>

                        <x-modal name="justify-{{ $absence->id }}">
                            <form action="{{ route('parent.absence.justify', $absence->id) }}" method="POST"
                                enctype="multipart/form-data" class="p-6">
                                @csrf
                                <h3 class="text-lg font-bold mb-4">Justifier l'absence du {{ $absence->date }}</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Motif</label>
                                        <textarea name="reason" required
                                            class="w-full border-gray-200 rounded-xl mt-1"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Document (PDF,
                                            Image)</label>
                                        <input type="file" name="document" required class="w-full mt-1">
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-[#064e3b] text-white py-3 rounded-xl font-bold shadow-lg">Envoyer
                                        le justificatif</button>
                                </div>
                            </form>
                        </x-modal>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</x-app-layout>
