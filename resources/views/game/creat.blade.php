<x-app-layout>
    <div style="max-width: 600px; margin: 40px auto; padding: 20px;">

        <h1>Ta partie est créée !</h1>

        <p>Statut : <strong>{{ $partie->statut }}</strong></p>

        <p>Partage ce lien à ton adversaire pour qu'il rejoigne :</p>

        <input
            type="text"
            value="{{ route('partie.afficher', $partie->token_invitation) }}"
            readonly
            style="width: 100%; padding: 10px; font-size: 14px;"
            onclick="this.select()"
        >

        <p style="margin-top: 20px; color: gray;">
            En attente que ton adversaire rejoigne...
        </p>

    </div>
</x-app-layout>