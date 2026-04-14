<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();

            $table->string('nom_prenom_stagiaire', 150);
            $table->date('date_naissance_stagiaire')->nullable();
            $table->string('lieu_naissance_stagiaire', 150)->nullable();

            // Diplôme
            $table->string('nature_diplome', 100)->nullable();
            $table->string('numero_diplome', 50)->nullable();
            $table->string('session', 50)->nullable();
            $table->string('option', 100)->nullable();

            // Contact
            $table->string('contact_stagiaire', 20)->nullable();
            $table->string('contact_urgence_stagiaire', 20)->nullable();

            // Stage
            $table->string('annee_exercice', 10)->nullable();
            $table->string('service_accueil', 100)->nullable();
            $table->string('maitre_stage', 150)->nullable();
            $table->date('date_demarrage')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('theme_stage', 255)->nullable();
            $table->decimal('note', 5, 2)->nullable();
            $table->string('appreciation', 50)->nullable();
            $table->boolean('inscri_emploi_jeune')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stagiaires');
    }
};
