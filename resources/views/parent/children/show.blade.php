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
                                    class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $absence->status == 'unexcused'? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
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
                            <div class="p-8 w-full max-w-[420px] mx-auto rounded-none bg-white shadow-2xl">

                                <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                                    <div>
                                        <p class="text-[10px] font-black text-emerald-800 uppercase tracking-[0.4em] mb-1">
                                            Absence • {{ $absence->date }}
                                        </p>
                                        <h3 class="text-2xl font-black text-[#064e3b] tracking-tighter leading-tight">
                                            Justifier l'absence
                                        </h3>
                                    </div>
                                    <div
                                        class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center font-black text-emerald-500 text-sm">
                                        PDF
                                    </div>
                                </div>

                                <form action="{{ route('parent.absence.justify', $absence->id) }}" method="POST" enctype="multipart/form-data"
                                    class="flex flex-col gap-6">
                                    @csrf

                                    <div>
                                        <label for="reason-{{ $absence->id }}"
                                            class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] mb-2">
                                            Motif de l'absence
                                        </label>
                                        <textarea id="reason-{{ $absence->id }}" name="reason" rows="3" required
                                            placeholder="Ex: Maladie, rendez-vous médical, raison familiale..."
                                            class="w-full border border-slate-200 rounded-none px-4 py-3 text-md text-black font-medium bg-white resize-none focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 placeholder:text-slate-300"></textarea>
                                    </div>

                                    <div x-data="{ fileName: '' }">
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] mb-2">
                                            Document justificatif
                                        </label>

                                        <label
                                            class="flex items-center gap-4 border border-dashed border-slate-300 rounded-none px-5 py-4 cursor-pointer bg-white hover:border-emerald-400 hover:bg-emerald-50 transition-colors">

                                            <span class="material-symbols-outlined text-emerald-500 text-lg">upload</span>

                                            <div class="flex-1">
                                                <p class="text-sm font-bold text-[#064e3b]" x-text="fileName || 'Choisir un fichier'"></p>
                                                <p class="text-[10px] text-slate-400 font-medium">PDF, JPG, PNG — max 5 Mo</p>
                                            </div>

                                            <input type="file" name="document" required accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                                                @change="fileName = $event.target.files[0].name">
                                        </label>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-[#064e3b] text-white rounded-none py-4 text-xs font-black uppercase tracking-[0.3em] transition-all hover:bg-emerald-600 hover:shadow-2xl hover:shadow-emerald-900/10 hover:-translate-y-0.5">
                                        Envoyer le justificatif
                                    </button>
                                </form>
                            </div>
                        </x-modal>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</x-app-layout>
