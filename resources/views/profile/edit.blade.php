<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="bg-emerald-600 p-1.5 rounded-lg">
                <i class="fas fa-user-cog text-white"></i>
            </div>
            <h2 class="font-bold text-2xl text-emerald-900 leading-tight">
                {{ __('Paramètres du Profil') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-8">

            <div
                class="bg-white shadow-xl shadow-emerald-900/5 rounded-3xl overflow-hidden border border-emerald-100 transition hover:shadow-emerald-900/10">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-emerald-900 p-8 text-white flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2 italic tracking-tight">Informations</h3>
                            <p class="text-emerald-200 text-sm leading-relaxed">Mettez à jour votre nom d'affichage et
                                votre adresse e-mail institutionnelle.</p>
                        </div>
                        <i class="fas fa-id-card text-6xl mt-8 opacity-10 self-end"></i>
                    </div>
                    <div class="md:w-2/3 p-8">
                        @if ($role === 'admin')
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')
                            <div>
                                <label class="block font-bold text-emerald-900 text-sm mb-2" for="name">Nom
                                    complet</label>
                                <input id="name" name="name" type="text"
                                    class="w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition bg-emerald-50/30"
                                    value="{{ old('name', $user->name) }}" required autofocus>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div>
                                <label class="block font-bold text-emerald-900 text-sm mb-2" for="email">Email</label>
                                <input id="email" name="email" type="email"
                                    class="w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition bg-emerald-50/30"
                                    value="{{ old('email', $user->email) }}" required>
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                            <div class="flex items-center gap-4">
                                <button type="submit"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all active:scale-95">
                                    {{ __('Enregistrer') }}
                                </button>
                                @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-emerald-600 font-bold italic">
                                    <i class="fas fa-check-circle mr-1"></i> Modifié !
                                </p>
                                @endif
                            </div>
                        </form>
                        @else
                        <div class="flex flex-col gap-4">
                            <div>
                                <label class="block font-bold text-emerald-900 text-sm mb-2" for="name">Nom
                                    complet</label>
                                <div
                                    class="border p-2 w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition bg-emerald-50/30">
                                    {{ old('name', $user->name) }}</div>
                            </div>
                            <div>
                                <label class="block font-bold text-emerald-900 text-sm mb-2" for="email">Email</label>
                                <div
                                    class="border p-2 w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition bg-emerald-50/30">
                                    {{ old('name', $user->email) }}</div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            <div
                class="bg-white shadow-xl shadow-emerald-900/5 rounded-3xl overflow-hidden border border-emerald-100 transition hover:shadow-emerald-900/10">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-emerald-800 p-8 text-white flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2 italic tracking-tight">Sécurité</h3>
                            <p class="text-emerald-100 text-sm leading-relaxed">Assurez la protection de votre compte
                                avec un mot de passe robuste.</p>
                        </div>
                        <i class="fas fa-shield-alt text-6xl mt-8 opacity-10 self-end"></i>
                    </div>
                    <div class="md:w-2/3 p-8">
                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')
                            <div>
                                <label class="block font-bold text-emerald-900 text-sm mb-2">Mot de passe actuel</label>
                                <input name="current_password" type="password"
                                    class="w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition bg-emerald-50/30">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')"
                                    class="mt-2" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold text-emerald-900 text-sm mb-2">Nouveau mot de
                                        passe</label>
                                    <input name="password" type="password"
                                        class="w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition bg-emerald-50/30">
                                </div>
                                <div>
                                    <label class="block font-bold text-emerald-900 text-sm mb-2">Confirmation</label>
                                    <input name="password_confirmation" type="password"
                                        class="w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition bg-emerald-50/30">
                                </div>
                            </div>
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            <button type="submit"
                                class="bg-emerald-800 hover:bg-emerald-900 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition-all active:scale-95">
                                {{ __('Mettre à jour') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @if ($role === 'admin')
            <div
                class="bg-white shadow-xl shadow-red-900/5 rounded-3xl overflow-hidden border border-red-100 transition hover:shadow-red-900/10">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-red-700 p-8 text-white flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2 italic tracking-tight">Zone Critique</h3>
                            <p class="text-red-100 text-sm leading-relaxed">La suppression est irréversible. Toutes vos
                                données seront effacées.</p>
                        </div>
                        <i class="fas fa-exclamation-triangle text-6xl mt-8 opacity-20 self-end"></i>
                    </div>
                    <div class="md:w-2/3 p-8 flex items-center justify-between">
                        <p class="text-gray-600 text-sm max-w-xs">Souhaitez-vous fermer définitivement votre accès à la
                            plateforme ?</p>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            class="bg-red-50 text-red-700 hover:bg-red-700 hover:text-white border border-red-200 px-6 py-3 rounded-xl font-bold transition-all">
                            {{ __('Supprimer le compte') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white rounded-3xl">
            @csrf
            @method('delete')
            <h2 class="text-2xl font-bold text-gray-900 mb-4 italic">Confirmation</h2>
            <p class="text-gray-600 mb-6 text-sm">Veuillez entrer votre mot de passe pour confirmer la suppression.</p>
            <div class="mb-6">
                <input id="password" name="password" type="password"
                    class="w-full rounded-xl border-red-200 focus:border-red-500 focus:ring focus:ring-red-200 transition"
                    placeholder="Mot de passe">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-2 text-gray-500 font-bold">Annuler</button>
                <button type="submit"
                    class="bg-red-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-red-200">Confirmer la
                    suppression</button>
            </div>
        </form>
    </x-modal>
    @endif
</x-app-layout>
