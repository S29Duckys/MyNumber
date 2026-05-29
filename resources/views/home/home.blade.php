<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNumber — Mastermind</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-950 text-white flex flex-col">

    {{-- Navbar --}}
    <nav class="border-b border-gray-800 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center font-bold text-sm">M</div>
            <span class="font-semibold text-lg tracking-tight">MyNumber</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="#" class="text-sm text-gray-400 hover:text-white transition">Connexion</a>
            <a href="#" class="text-sm bg-indigo-600 hover:bg-indigo-500 transition px-4 py-2 rounded-lg font-medium">
                S'inscrire
            </a>
        </div>
    </nav>

    {{-- Hero --}}
    <main class="flex-1 flex flex-col items-center justify-center px-4 text-center">

        <div class="inline-flex items-center gap-2 bg-indigo-950 border border-indigo-800 text-indigo-300 text-xs font-medium px-3 py-1.5 rounded-full mb-6">
            <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span>
            Jeu de déduction à 2 joueurs
        </div>

        <h1 class="text-5xl font-bold tracking-tight mb-4 max-w-xl">
            Trouve le code secret avant ton adversaire
        </h1>

        <p class="text-gray-400 text-lg max-w-md mb-10">
            Crée une partie, partage le lien d'invitation et affronte un ami en temps réel. 10 essais pour deviner sa combinaison de 4 chiffres.
        </p>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4 w-full max-w-sm">
            <a href="#"
               class="flex-1 bg-indigo-600 hover:bg-indigo-500 transition text-white font-semibold py-3 px-6 rounded-xl text-center">
                Créer une partie
            </a>
            <a href="#"
               class="flex-1 bg-gray-800 hover:bg-gray-700 transition text-white font-semibold py-3 px-6 rounded-xl text-center">
                Rejoindre
            </a>
        </div>

        {{-- Exemple de code --}}
        <div class="mt-16 flex gap-3">
            @foreach(['2', '7', '0', '4'] as $digit)
            <div class="w-14 h-14 bg-gray-800 border border-gray-700 rounded-xl flex items-center justify-center text-2xl font-bold text-indigo-400">
                {{ $digit }}
            </div>
            @endforeach
        </div>
        <p class="text-gray-600 text-sm mt-3">Exemple de combinaison secrète</p>

    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-800 px-6 py-4 text-center text-gray-600 text-sm">
        MyNumber &copy; {{ date('Y') }}
    </footer>

</body>
</html>
