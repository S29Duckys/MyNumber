<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="username" :value="__('Nom d\'utilisateur')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-700 bg-gray-800 text-indigo-500 focus:ring-indigo-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-400">Se souvenir de moi</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('register') }}" class="text-sm text-gray-400 hover:text-white transition">
                Pas encore de compte ?
            </a>
            <x-primary-button>Connexion</x-primary-button>
        </div>
    </form>
</x-guest-layout>
