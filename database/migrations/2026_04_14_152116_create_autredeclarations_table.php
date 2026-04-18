<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autredeclarations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commune_id')
                  ->constrained('communes')
                  ->restrictOnDelete();

            // ── Registre ─────────────────────────────
            $table->year('annee_registre_autre')->nullable();
            $table->string('numero_registe_autre', 50)->nullable();
            $table->string('numero_act_autre', 50)->nullable();

            // ── Date & heure ──────────────────────────
            $table->date('date_dressage_autre')->nullable();
            $table->string('heure_autre', 20)->nullable();
            $table->string('date_lettre_autre', 200)->nullable();

            // ── Officier ──────────────────────────────
            $table->string('officier_etat_civil_autre', 150)->nullable();
            $table->string('qualite_etat_civil_autre', 100)->nullable();

            // ── Déclarant ─────────────────────────────
            $table->string('civilite', 30)->nullable(); // M., Mme, Dr, etc.
            $table->string('nom_prenom_autre', 150)->nullable();
            $table->string('profession_autre', 100)->nullable();
            $table->string('domicile_autre', 200)->nullable();

            // ── Acte ─────────────────────────────────
            $table->string('act_autre', 100)->nullable();        // type de l'acte
            $table->string('concernant_autre', 200)->nullable(); // objet de la déclaration
            $table->text('info_complet_rapport_act')->nullable(); // corps complet

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autredeclarations');
    }
};
