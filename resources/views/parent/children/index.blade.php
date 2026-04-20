<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 italic">Mes Enfants</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($children as $child)
                <a href="{{ route('parent.child.show', $child->id) }}" class="block group">
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-500 transition-all flex items-center space-x-4">
                        <div
                            class="h-16 w-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-xl font-black">
                            {{ strtoupper(substr($child->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <h2 class="text-lg font-bold text-gray-800 group-hover:text-emerald-600">{{ $child->name }}
                            </h2>
                            <p class="text-sm text-gray-400">Cliquez pour voir les notes et absences</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-300 group-hover:text-emerald-500">arrow_forward_ios</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
