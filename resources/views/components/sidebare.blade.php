<style>
    .bg-edu-dark {
        background-color: #064e3b;
    }

    .bg-edu-sidebar {
        background-color: #022c22;
    }

    .text-edu-light {
        color: #ecfdf5;
    }

    .hover-edu:hover {
        background-color: #065f46;
        transition: 0.3s;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }


    #mobile-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #mobile-sidebar.open {
        transform: translateX(0);
    }

    #sidebar-overlay {
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    #sidebar-overlay.open {
        opacity: 1;
        pointer-events: auto;
    }
</style>

@php
$user = Auth::user();
$role = $user->role;
@endphp

<button id="hamburger-btn"
    class="lg:hidden fixed top-4 left-4 z-[999] bg-emerald-800 text-white p-2.5 rounded-lg shadow-lg hover:bg-emerald-700 transition focus:outline-none">
    <i class="fas fa-bars text-lg"></i>
</button>

<div id="sidebar-overlay" class="lg:hidden fixed inset-0 bg-black/60 z-[998]"></div>


<aside class="fixed left-0 top-0 w-72 bg-edu-sidebar text-white flex-shrink-0 hidden lg:flex flex-col h-full">
    <div class="p-6 flex items-center space-x-3 border-b border-emerald-900/50">
        <img src="{{ asset('favicon.ico') }}" alt="" class="h-16 rounded-lg">
        <span class="text-2xl font-bold tracking-wider italic">EDUHUB</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar no-scrollbar">
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mb-2 tracking-widest">Principal</p>
        <a href="/dashboard"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('dashboard') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}">
            <i class="fas fa-th-large w-5 text-emerald-400"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('profile.edit') }}"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('profile*') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}">
            <i class="fas fa-user-circle w-5 text-emerald-400"></i>
            <span>Mon Profil</span>
        </a>

        @if ($role === 'admin')
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mt-6 mb-2 tracking-widest">Gestion Système</p>
        <a href="/admin/teachers" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition">
            <i class="fas fa-chalkboard-teacher w-5 text-emerald-400"></i>
            <span>Teachers</span>
        </a>
        <a href="/admin/students" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition">
            <i class="fas fa-user-graduate w-5 text-emerald-400"></i>
            <span class="text-gray-100 font-medium">Students</span>
        </a>
        <a href="/admin/classes" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition">
            <i class="fas fa-chalkboard w-5 text-emerald-400"></i>
            <span class="text-gray-100 font-medium">Classes</span>
        </a>
        <a href="/admin/parents" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition">
            <i class="fas fa-user-friends w-5 text-emerald-400"></i>
            <span class="text-gray-100 font-medium">Parents</span>
        </a>
        <a href="/admin/justifications"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition">
            <i class="fas fa-file-circle-check w-5 text-emerald-400"></i>
            <span>Justificatifs</span>
        </a>
        @endif

        @if ($role === 'teacher')
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mt-6 mb-2 tracking-widest">Ma Classe</p>
        <a href="{{ route('absences.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('teacher/absences*') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}">
            <i class="fas fa-clipboard-check w-5 text-emerald-400"></i>
            <span>Faire l'appel</span>
        </a>
        <a href="{{ route('grades.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('teacher/grades*') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}">
            <i class="fas fa-file-invoice w-5 text-emerald-400"></i>
            <span>Gestion des notes</span>
        </a>
        <a href="/teacher/messages"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('teacher/messages*') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}">
            <i class="fas fa-comments w-5 text-emerald-400"></i>
            <span>Contacter Parents</span>
        </a>
        @endif

        @if ($role === 'parent')
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mt-6 mb-2 tracking-widest">Suivi Enfants</p>
        <a href="/parent/children"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition">
            <i class="fas fa-users w-5 text-emerald-400"></i>
            <span>Mes Enfants</span>
        </a>
        @endif

        @if ($role === 'student')
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mt-6 mb-2 tracking-widest">Scolarité</p>
        <a href="/student/grades" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition">
            <i class="fas fa-star w-5 text-emerald-400"></i>
            <span>Mes Notes</span>
        </a>
        <a href="/student/absences"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition">
            <i class="fas fa-calendar-times w-5 text-emerald-400"></i>
            <span>Mes Absences</span>
        </a>
        @endif
    </nav>

    <div class="p-4 border-t border-emerald-900 bg-black/10">
        <div class="flex items-center space-x-3 p-2 bg-emerald-900/30 rounded-xl">
            <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=10b981&color=fff&size=40&bold=true"
                class="w-10 h-10 rounded-full border-2 border-emerald-500/50 shadow-sm" alt="Profile">
            <div class="overflow-hidden">
                <p class="text-sm font-semibold truncate text-emerald-100">{{ $user->name }}</p>
                <p class="text-[10px] text-emerald-300 font-bold uppercase tracking-widest">{{ ucfirst($role) }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button
                class="w-full text-left flex items-center space-x-3 p-2 text-xs text-emerald-300 hover:text-white transition hover:bg-emerald-800/50 rounded-lg">
                <i class="fas fa-power-off"></i>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>

<aside id="mobile-sidebar"
    class="lg:hidden fixed left-0 top-0 h-full z-[999] w-80 bg-edu-sidebar text-white flex flex-col">

    <div class="p-6 flex items-center justify-between border-b border-emerald-900/50">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('favicon.ico') }}" alt="" class="h-16 rounded-lg">
            <span class="text-2xl font-bold tracking-wider italic">EDUHUB</span>
        </div>
        <button id="close-btn" class="text-emerald-400 hover:text-white transition">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto no-scrollbar">
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mb-2 tracking-widest">Principal</p>
        <a href="/dashboard"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('dashboard') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}">
            <i class="fas fa-th-large w-5 text-emerald-400"></i><span>Tableau de bord</span>
        </a>
        <a href="{{ route('profile.edit') }}"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('profile*') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}">
            <i class="fas fa-user-circle w-5 text-emerald-400"></i><span>Mon Profil</span>
        </a>

        @if ($role === 'admin')
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mt-6 mb-2 tracking-widest">Gestion Système</p>
        <a href="/admin/teachers"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition"><i
                class="fas fa-chalkboard-teacher w-5 text-emerald-400"></i><span>Teachers</span></a>
        <a href="/admin/students"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition"><i
                class="fas fa-user-graduate w-5 text-emerald-400"></i><span>Students</span></a>
        <a href="/admin/classes"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition"><i
                class="fas fa-chalkboard w-5 text-emerald-400"></i><span>Classes</span></a>
        <a href="/admin/parents"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition"><i
                class="fas fa-user-friends w-5 text-emerald-400"></i><span>Parents</span></a>
        <a href="/admin/justifications"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition"><i
                class="fas fa-file-circle-check w-5 text-emerald-400"></i><span>Justificatifs</span></a>
        @endif

        @if ($role === 'teacher')
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mt-6 mb-2 tracking-widest">Ma Classe</p>
        <a href="{{ route('absences.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('teacher/absences*') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}"><i
                class="fas fa-clipboard-check w-5 text-emerald-400"></i><span>Faire l'appel</span></a>
        <a href="{{ route('grades.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('teacher/grades*') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}"><i
                class="fas fa-file-invoice w-5 text-emerald-400"></i><span>Gestion des notes</span></a>
        <a href="/teacher/messages"
            class="flex items-center space-x-3 p-3 rounded-lg {{ Request::is('teacher/messages*') ? 'bg-emerald-800 shadow-inner' : 'hover:bg-emerald-800/50 transition' }}"><i
                class="fas fa-comments w-5 text-emerald-400"></i><span>Contacter Parents</span></a>
        @endif

        @if ($role === 'parent')
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mt-6 mb-2 tracking-widest">Suivi Enfants</p>
        <a href="/parent/children"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition"><i
                class="fas fa-users w-5 text-emerald-400"></i><span>Mes Enfants</span></a>
        @endif

        @if ($role === 'student')
        <p class="text-[10px] uppercase text-emerald-500 font-bold px-3 mt-6 mb-2 tracking-widest">Scolarité</p>
        <a href="/student/grades"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition"><i
                class="fas fa-star w-5 text-emerald-400"></i><span>Mes Notes</span></a>
        <a href="/student/absences"
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-800/50 transition"><i
                class="fas fa-calendar-times w-5 text-emerald-400"></i><span>Mes Absences</span></a>
        @endif
    </nav>

    <div class="p-4 border-t border-emerald-900 bg-black/10">
        <div class="flex items-center space-x-3 p-2 bg-emerald-900/30 rounded-xl">
            <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=10b981&color=fff&size=40&bold=true"
                class="w-10 h-10 rounded-full border-2 border-emerald-500/50 shadow-sm" alt="Profile">
            <div class="overflow-hidden">
                <p class="text-sm font-semibold truncate text-emerald-100">{{ $user->name }}</p>
                <p class="text-[10px] text-emerald-300 font-bold uppercase tracking-widest">{{ ucfirst($role) }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button
                class="w-full text-left flex items-center space-x-3 p-2 text-xs text-emerald-300 hover:text-white transition hover:bg-emerald-800/50 rounded-lg">
                <i class="fas fa-power-off"></i><span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>

<script>
    const btn = document.getElementById('hamburger-btn');
    const closeBtn = document.getElementById('close-btn');
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    btn.addEventListener('click', () => {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    });

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);
</script>
