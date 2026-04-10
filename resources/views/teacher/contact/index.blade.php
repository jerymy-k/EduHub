<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="bg-gradient-to-r from-[#064e3b] to-emerald-600 rounded-2xl p-8 text-white shadow-xl">
                <h1 class="text-3xl font-black italic">Contacter Parents</h1>
                <p class="text-emerald-100 opacity-90">Envoyez un message direct au parent d'un élève.</p>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <form action="{{ route('teacher.contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Sélectionner
                            l'élève</label>
                        <select name="student_id"
                            class="w-full border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                            @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} (Parent: {{
                                $student->parentOfChild->first()->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Sujet</label>
                        <input type="text" name="subject" placeholder="Ex: Comportement en classe"
                            class="w-full border-gray-200 rounded-xl">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Message</label>
                        <textarea name="message" rows="6" class="w-full border-gray-200 rounded-xl"
                            placeholder="Votre message ici..."></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#064e3b] text-white py-4 rounded-xl font-bold shadow-lg hover:bg-emerald-800 transition flex items-center justify-center">
                        <span class="material-symbols-outlined mr-2">send</span>
                        Envoyer l'Email
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
