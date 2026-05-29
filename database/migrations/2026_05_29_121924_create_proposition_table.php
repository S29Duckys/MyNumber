<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposition', function (Blueprint $table) {
            $table->bigIncrements('id_proposition');
            $table->unsignedBigInteger('partie_id');
            $table->unsignedBigInteger('joueur_id');
            $table->unsignedInteger('num_tour');
            $table->char('combinaison', 4);
            $table->unsignedTinyInteger('chiffre_correct');
            $table->timestamp('created_at')->nullable();

            $table->foreign('partie_id')->references('id_partie')->on('parties')->onDelete('cascade');
            $table->foreign('joueur_id')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposition');
    }
};
