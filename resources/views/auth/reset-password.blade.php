<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-black text-[#064e3b]">Réinitialiser le mot de passe</h2>
        <p class="text-gray-400 text-sm">Sécurisez votre compte avec un nouveau mot de passe.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Adresse
                Email</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">mail</span>
                <input id="email"
                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 transition-all"
                    type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                    autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Nouveau
                mot de passe</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">lock_open</span>
                <input id="password"
                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 transition-all"
                    type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation"
                class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Confirmer le mot de
                passe</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">lock_reset</span>
                <input id="password_confirmation"
                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 transition-all"
                    type="password" name="password_confirmation" placeholder="••••••••" required
                    autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-[#064e3b] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-sm shadow-lg shadow-emerald-900/20 hover:bg-emerald-800 hover:-translate-y-0.5 transition-all active:scale-95 flex items-center justify-center space-x-2">
                <span>{{ __('Réinitialiser') }}</span>
                <span class="material-symbols-outlined text-base">published_with_changes</span>
            </button>
        </div>
    </form>
</x-guest-layout>
