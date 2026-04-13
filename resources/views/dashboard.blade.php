<x-app-layout>
    <div class="relative h-[100vh] w-full overflow-hidden">

        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/campus.png') }}" class="w-full h-full object-cover" alt="EduHub Campus">
            <div class="absolute inset-0 bg-gradient-to-t from-[#064e3b] via-[#064e3b]/80 to-black/40 h-[100vh]"></div>
        </div>

        <div class="flex justify-center items-center border border-black w-full h-[65vh]">
            <div class="relative z-10 h-full flex flex-col items-center justify-end px-6 text-center">

                <div class="mb-6 backdrop-blur-xl bg-white/10 border border-white/20 px-6 py-2 rounded-2xl shadow-2xl">
                    <p class="text-white text-[10px] font-black uppercase tracking-[0.5em]">Session Active • {{
                        Auth::user()->role }}</p>
                </div>

                <h1 class="text-white text-6xl md:text-8xl font-black tracking-tighter mb-4 drop-shadow-2xl">
                    Edu<span class="text-emerald-400">Hub.</span>
                </h1>

                <p class="text-emerald-50 text-xl md:text-2xl font-light max-w-2xl mb-12 drop-shadow-lg">
                    Bienvenue, <span class="font-bold underline decoration-emerald-500 underline-offset-8">{{ explode('
                        ',
                        Auth::user()->name)[0] }}</span>.
                    Prêt pour votre prochaine leçon ?
                </p>

                <div class="flex items-center space-x-6">
                    <a href="#services"
                        class="group relative px-12 py-4 bg-white text-[#064e3b] font-black uppercase tracking-widest text-xs rounded-full transition-all hover:scale-105 active:scale-95 shadow-2xl">
                        Tableau de Bord
                    </a>

                    <button class="text-white/80 hover:text-white transition-colors flex items-center space-x-2">
                        <span class="material-symbols-outlined text-xl">help_outline</span>
                        <span class="text-[10px] font-black uppercase tracking-widest">Support</span>
                    </button>
                </div>
            </div>
        </div>

        <div
            class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-emerald-500 to-transparent opacity-50">
        </div>
    </div>
</x-app-layout>
