<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-black text-[#064e3b]">Mot de passe oublié ?</h2>
        <p class="text-gray-400 text-sm mt-2 leading-relaxed">
            Pas de souci. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation.
        </p>
    </div>

    <x-auth-session-status class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl text-sm"
        :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Votre
                Adresse Email</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">alternate_email</span>
                <input id="email"
                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 transition-all placeholder:text-gray-300"
                    type="email" name="email" :value="old('email')" placeholder="nom@ecole.com" required autofocus />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-[#064e3b] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-sm shadow-lg shadow-emerald-900/20 hover:bg-emerald-800 hover:-translate-y-0.5 transition-all active:scale-95 flex items-center justify-center space-x-2">
                <span>{{ __('Envoyer le lien') }}</span>
                <span class="material-symbols-outlined text-base">send</span>
            </button>
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('login') }}"
                class="text-xs font-bold text-gray-400 hover:text-emerald-600 transition-colors uppercase tracking-widest flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>
