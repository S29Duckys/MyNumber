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
        Schema::create('combinaison_secret', function (Blueprint $table) {
            $table->bigIncrements('id_combinaison');
            $table->unsignedBigInteger('joueur_id');
            $table->unsignedBigInteger('partie_id');
            $table->char('combinaison', 4);
            $table->timestamp('created_at')->nullable();

            $table->foreign('joueur_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('partie_id')->references('id_partie')->on('parties')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combinaison_secret');
    }
};
