<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Tableau de Bord') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-xs font-medium px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full">En ligne</span>
                <div
                    class="h-10 w-10 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 shadow-lg flex items-center justify-center text-white font-bold text-lg border-2 border-white/20">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </x-slot>
    @if (session('success'))
    <div
        class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 shadow-sm rounded-r-lg flex items-center">
        <span class="material-symbols-outlined mr-2">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-r from-emerald-800/90 to-emerald-600/90 backdrop-blur-md rounded-3xl p-12 text-white mb-12 shadow-2xl border border-white/20 relative overflow-hidden">
                <div class="relative z-10">
                    <h1
                        class="text-5xl font-bold mb-4 bg-gradient-to-r from-white to-emerald-100/50 bg-clip-text text-transparent">
                        Bienvenue, {{ Auth::user()->name }}!</h1>
                    <p class="opacity-90 text-xl leading-relaxed">Plateforme de gestion scolaire centralisée <span
                            class="font-bold">v1.0</span></p>
                    <p class="text-emerald-100 mt-2 font-medium">Rôle: {{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <i class="fas fa-graduation-cap absolute -right-12 -bottom-12 text-9xl opacity-10 animate-pulse"></i>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <a href="#" onclick="alert('Notes en développement')"
                    class="group bg-white/70 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-emerald-100/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-emerald-200">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-3">Gestion Notes</h4>
                    <p class="text-gray-600 leading-relaxed">Consultez et saisissez les résultats</p>
                </a>

                <a href="#" onclick="alert('Absences en développement')"
                    class="group bg-white/70 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-emerald-100/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-emerald-200">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                        <i class="fas fa-calendar-times text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-3">Absences</h4>
                    <p class="text-gray-600 leading-relaxed">Faire l'appel et justificatifs</p>
                </a>

                <a href="#" onclick="alert('Messages en développement')"
                    class="group bg-white/70 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-emerald-100/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-emerald-200">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                        <i class="fas fa-envelope text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-3">Notifications</h4>
                    <p class="text-gray-600 leading-relaxed">Alertes et communication</p>
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="group bg-white/70 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-emerald-100/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-emerald-200">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                        <i class="fas fa-user-cog text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-3">Mon Profil</h4>
                    <p class="text-gray-600 leading-relaxed">Paramètres et informations</p>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white/80 backdrop-blur-sm p-10 rounded-3xl shadow-2xl border border-gray-100/50">
                    <h3 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                        <i class="fas fa-info-circle text-emerald-500 mr-4 text-3xl"></i>
                        À propos d'EduHub
                    </h3>
                    <p class="text-xl text-gray-700 leading-relaxed">
                        Interface moderne pour la gestion scolaire. Suivi des notes, absences et communications
                        centralisés.
                    </p>
                    <div class="mt-8 p-6 bg-emerald-50 rounded-2xl">
                        <p class="font-bold text-emerald-800">Phase 1 complète:</p>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                            <span>Authentification & Rôles</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                            <span>Dashboard responsive</span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 backdrop-blur-sm p-10 rounded-3xl border border-emerald-200/50 shadow-2xl">
                    <h3 class="text-3xl font-bold text-white mb-8 flex items-center">
                        <i class="fas fa-rocket text-emerald-200 mr-4 text-3xl"></i>
                        Prochaines étapes
                    </h3>
                    <ul class="space-y-4 text-emerald-100">
                        <li
                            class="flex items-center p-4 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <i class="fas fa-plus-circle text-emerald-300 mr-4"></i>
                            <span>Controllers & Routes</span>
                        </li>
                        <li
                            class="flex items-center p-4 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <i class="fas fa-plus-circle text-emerald-300 mr-4"></i>
                            <span>Modèles & Migrations</span>
                        </li>
                        <li
                            class="flex items-center p-4 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <i class="fas fa-plus-circle text-emerald-300 mr-4"></i>
                            <span>Emails automatisés</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </xai:function_call>

    <xai:function_call name="edit_file">
        <parameter name="path">/home/elkerymy-mohamed/Desktop/EduHub/TODO-FIX-DASHBOARD.md
</x-app-layout>
