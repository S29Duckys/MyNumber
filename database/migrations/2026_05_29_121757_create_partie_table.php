<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->bigIncrements('id_partie');
            $table->char('token_invitation', 36)->unique();
            $table->unsignedBigInteger('createur_id');
            $table->unsignedBigInteger('adversaire_id')->nullable();
            $table->unsignedBigInteger('gagnant_id')->nullable();
            $table->unsignedBigInteger('tour_joueur_id')->nullable();
            $table->enum('statut', ['en_attente', 'preparation', 'en_cours', 'terminee'])->default('en_attente');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('createur_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('adversaire_id')->references('id_user')->on('users')->onDelete('set null');
            $table->foreign('gagnant_id')->references('id_user')->on('users')->onDelete('set null');
            $table->foreign('tour_joueur_id')->references('id_user')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
