<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extraits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commune_id')
                  ->constrained('communes')
                  ->restrictOnDelete();

            // ── Registre ─────────────────────────────
            $table->string('centr_etat_civil', 150)->nullable();
            $table->year('annee_registre_extrai')->nullable();
            $table->string('nature_declarat_extrai', 100)->nullable();
            $table->string('numero_registre_extrai', 50)->nullable();
            $table->string('numero_act_extrai', 50)->nullable();
            $table->string('numero_complet_act_extrai', 100)->nullable();

            // ── Dates & heure ─────────────────────────
            $table->date('date_dressage')->nullable();
            $table->string('heure_dressage', 20)->nullable();
            $table->date('date_dressage_copie_integrale')->nullable();

            // ── Officier ──────────────────────────────
            $table->string('officier_etat_civil', 150)->nullable();
            $table->string('qualite', 100)->nullable();
            $table->string('nous_avons_signer', 150)->nullable();

            // ── Enfant ───────────────────────────────
            $table->string('nom_enfant', 100)->nullable();
            $table->string('prenom_enfant', 100)->nullable();
            $table->string('date_naissance_lettre', 200)->nullable(); // en toutes lettres
            $table->date('date_naissance')->nullable();
            $table->string('heure_min_naissance', 20)->nullable();
            $table->string('lieux_naissance', 150)->nullable();
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->string('fils_fille', 30)->nullable(); // "fils" ou "fille"

            // ── Père ─────────────────────────────────
            $table->string('nom_prenom_pere', 150)->nullable();
            $table->date('date_naissance_pere')->nullable();
            $table->year('annee_naissance_pere')->nullable();
            $table->string('lieu_naissance_pere', 150)->nullable();
            $table->string('profession_pere', 100)->nullable();
            $table->string('nationnalite_pere', 80)->nullable();
            $table->string('domicile_pere', 200)->nullable();
            $table->string('nature_piece_pere', 100)->nullable();

            // ── Mère ─────────────────────────────────
            $table->string('nom_prenom_mere', 150)->nullable();
            $table->date('date_naissance_mere')->nullable();
            $table->year('annee_naissance_mere')->nullable();
            $table->string('profession_mere', 100)->nullable();
            $table->string('nationalite_mere', 80)->nullable();
            $table->string('domicile_mere', 200)->nullable();
            $table->string('nature_piece_mere', 100)->nullable();

            // ── Déclarant & Témoins (JSON) ────────────
            $table->text('info_declarant')->nullable();
            $table->text('info_temoin_1')->nullable();
            $table->text('info_temoin_2')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extraits');
    }
};
