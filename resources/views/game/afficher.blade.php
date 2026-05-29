<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 py-12">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-white transition text-sm">← Accueil</a>
            <span class="text-xs font-medium px-3 py-1 rounded-full border
                @if($partie->statut === 'en_attente') border-yellow-700 text-yellow-400 bg-yellow-950
                @elseif($partie->statut === 'preparation') border-blue-700 text-blue-400 bg-blue-950
                @elseif($partie->statut === 'en_cours') border-green-700 text-green-400 bg-green-950
                @else border-gray-700 text-gray-400 bg-gray-900
                @endif">
                @switch($partie->statut)
                    @case('en_attente') En attente @break
                    @case('preparation') Préparation @break
                    @case('en_cours') En cours @break
                    @case('terminee') Terminée @break
                @endswitch
            </span>
        </div>

        {{-- EN ATTENTE --}}
        @if($partie->statut === 'en_attente')

            @if($partie->createur_id == auth()->id())
                {{-- Créateur : affiche le lien d'invitation --}}
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 text-center">
                    <div class="w-14 h-14 bg-yellow-950 border border-yellow-800 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">⏳</div>
                    <h1 class="text-2xl font-bold mb-2">Partie créée !</h1>
                    <p class="text-gray-400 mb-8">Partage ce lien à ton adversaire pour qu'il rejoigne la partie.</p>
                    <div class="flex gap-2">
                        <input id="invite-link" type="text" readonly
                            value="{{ route('game.afficher', $partie->token_invitation) }}"
                            class="flex-1 bg-gray-800 border border-gray-700 text-white text-sm rounded-xl px-4 py-3 focus:outline-none"
                            onclick="this.select()">
                        <button
                            onclick="navigator.clipboard.writeText(document.getElementById('invite-link').value).then(() => this.textContent = 'Copié !')"
                            class="bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-medium px-5 py-3 rounded-xl whitespace-nowrap">
                            Copier
                        </button>
                    </div>
                    <p class="text-gray-600 text-sm mt-6">En attente d'un adversaire…</p>
                </div>

            @else
                {{-- Adversaire : bouton pour rejoindre --}}
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 text-center">
                    <div class="w-14 h-14 bg-indigo-950 border border-indigo-800 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">🎮</div>
                    <h1 class="text-2xl font-bold mb-2">Tu es invité !</h1>
                    <p class="text-gray-400 mb-8">Un joueur t'invite à une partie de Mastermind.</p>
                    <form method="POST" action="{{ route('parties.rejoindre', $partie->token_invitation) }}">
                        @csrf
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-500 transition text-white font-semibold px-10 py-3 rounded-xl">
                            Rejoindre la partie
                        </button>
                    </form>
                </div>
            @endif

        {{-- PREPARATION --}}
        @elseif($partie->statut === 'preparation')
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 text-center">

                @if($aDejaSubmis)
                    <div class="w-14 h-14 bg-green-950 border border-green-800 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">✅</div>
                    <h1 class="text-2xl font-bold mb-2">Combinaison enregistrée</h1>
                    <p class="text-gray-400">En attente que ton adversaire choisisse sa combinaison…</p>

                @else
                    <div class="w-14 h-14 bg-blue-950 border border-blue-800 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">🔐</div>
                    <h1 class="text-2xl font-bold mb-2">Choisis ta combinaison secrète</h1>
                    <p class="text-gray-400 mb-8">4 chiffres de 0 à 9. Ton adversaire devra la deviner.</p>
                    <form method="POST" action="{{ route('parties.combinaison', $partie->token_invitation) }}" class="flex flex-col items-center gap-6">
                        @csrf
                        <input type="text" name="combinaison" maxlength="4" placeholder="0000"
                            value="{{ old('combinaison') }}"
                            class="w-40 text-center text-3xl font-bold tracking-widest bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-4 focus:outline-none focus:border-indigo-500">
                        @error('combinaison')
                            <p class="text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-500 transition text-white font-semibold px-8 py-3 rounded-xl">
                            Confirmer
                        </button>
                    </form>
                @endif

            </div>

        {{-- EN COURS --}}
        @elseif($partie->statut === 'en_cours')
            <div class="space-y-6">

                <h1 class="text-2xl font-bold text-center">Partie en cours</h1>

                {{-- Indicateur de tour --}}
                <div class="text-center">
                    @if($partie->tour_joueur_id == auth()->id())
                        <span class="text-green-400 font-semibold">C'est ton tour !</span>
                    @else
                        <span class="text-gray-400">En attente du tour de ton adversaire…</span>
                    @endif
                </div>

                {{-- Historique des propositions --}}
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                    <h2 class="text-sm font-medium text-gray-400 mb-4">Tes essais</h2>
                    @forelse($partie->propositions()->where('joueur_id', auth()->id())->orderBy('num_tour')->get() as $prop)
                        <div class="flex items-center justify-between py-3 border-b border-gray-800 last:border-0">
                            <div class="flex items-center gap-3">
                                <span class="text-gray-600 text-sm w-6">{{ $prop->num_tour }}</span>
                                <div class="flex gap-2">
                                    @foreach(str_split($prop->combinaison) as $digit)
                                        <div class="w-10 h-10 bg-gray-800 border border-gray-700 rounded-lg flex items-center justify-center font-bold text-indigo-400">
                                            {{ $digit }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold {{ $prop->chiffre_correct === 4 ? 'text-green-400' : 'text-white' }}">
                                    {{ $prop->chiffre_correct }}
                                </span>
                                <span class="text-gray-500 text-sm">/ 4</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600 text-sm text-center py-4">Aucun essai pour l'instant.</p>
                    @endforelse
                </div>

                {{-- Formulaire de proposition --}}
                @if($partie->tour_joueur_id == auth()->id())
                    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 text-center">
                        <p class="text-gray-400 text-sm mb-4">Entre ta proposition</p>
                        <form method="POST" action="{{ route('parties.proposer', $partie->token_invitation) }}" class="flex flex-col items-center gap-4">
                            @csrf
                            <input type="text" name="combinaison" maxlength="4" placeholder="0000"
                                value="{{ old('combinaison') }}"
                                class="w-40 text-center text-3xl font-bold tracking-widest bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-4 focus:outline-none focus:border-indigo-500">
                            @error('combinaison')
                                <p class="text-red-400 text-sm">{{ $message }}</p>
                            @enderror
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-500 transition text-white font-semibold px-8 py-3 rounded-xl">
                                Proposer
                            </button>
                        </form>
                    </div>
                @endif

            </div>

        {{-- TERMINEE --}}
        @else
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 text-center">
                <div class="w-14 h-14 bg-gray-800 border border-gray-700 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">🏆</div>
                <h1 class="text-2xl font-bold mb-2">Partie terminée</h1>
                @if($partie->gagnant_id == auth()->id())
                    <p class="text-green-400 font-semibold text-lg mb-2">Tu as gagné !</p>
                @else
                    <p class="text-red-400 font-semibold text-lg mb-2">Tu as perdu.</p>
                @endif
                <a href="{{ route('home') }}"
                    class="inline-block mt-6 bg-indigo-600 hover:bg-indigo-500 transition text-white font-semibold px-8 py-3 rounded-xl">
                    Retour à l'accueil
                </a>
            </div>
        @endif

    </div>

@if(
    $partie->statut === 'en_attente' ||
    ($partie->statut === 'preparation' && $aDejaSubmis) ||
    ($partie->statut === 'en_cours' && $partie->tour_joueur_id != auth()->id())
)
<script>
    setTimeout(() => location.reload(), 1000);
</script>
@endif

</x-app-layout>
