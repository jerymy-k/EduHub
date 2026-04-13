<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-4xl font-black text-[#064e3b]">Bon retour !</h2>
        <p class="text-gray-400 text-sm">Veuillez vous connecter à votre compte EduHub.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Adresse
                Email</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">mail</span>
                <input id="email"
                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 transition-all placeholder:text-gray-300"
                    type="email" name="email" :value="old('email')" placeholder="exemple@eduhub.com" required autofocus
                    autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">Mot de
                    passe</label>
                @if (Route::has('password.request'))
                <a class="text-[10px] font-bold text-emerald-600 hover:text-[#064e3b] uppercase tracking-tighter"
                    href="{{ route('password.request') }}">
                    Oublié ?
                </a>
                @endif
            </div>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">lock</span>
                <input id="password"
                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 transition-all"
                    type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 cursor-pointer"
                    name="remember">
                <span
                    class="ms-2 text-xs font-bold text-gray-400 group-hover:text-gray-600 transition-colors uppercase tracking-widest">{{
                    __('Rester connecté') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button
                class="w-full bg-[#064e3b] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-sm shadow-lg shadow-emerald-900/20 hover:bg-emerald-800 hover:-translate-y-0.5 transition-all active:scale-95 flex items-center justify-center space-x-2">
                <span>Connexion</span>
                <span class="material-symbols-outlined text-base">login</span>
            </button>
        </div>
    </form>
</x-guest-layout>
