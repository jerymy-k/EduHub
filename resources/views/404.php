<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - EduHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen overflow-hidden">

    <div class="absolute inset-0 z-0">
        <div class="absolute top-20 left-20 w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-40 right-20 w-96 h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/2 w-96 h-96 bg-emerald-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 text-center px-6">
        <h1 class="text-[12rem] font-black text-[#064e3b] opacity-10 leading-none">404</h1>

        <div class="mt-[1rem]">
            <h2 class="text-4xl font-black text-[#064e3b] mt-4">Oups ! Page introuvable.</h2>
            <p class="text-gray-500 mt-4 max-w-sm mx-auto leading-relaxed text-lg">
                Désolé, la page que vous recherchez semble avoir pris des vacances prolongées.
            </p>
        </div>

        <div class="mt-10">
            <a href="/dashboard"
               class="inline-flex items-center space-x-3 bg-[#064e3b] text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-emerald-900/20 hover:bg-emerald-800 hover:-translate-y-1 transition-all active:scale-95">
                <span class="material-symbols-outlined">home</span>
                <span>Retour au Tableau de Bord</span>
            </a>
        </div>
    </div>

</body>
</html>
