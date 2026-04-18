<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mariages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commune_id')
                  ->constrained('communes')
                  ->restrictOnDelete();

            // ── Registre ─────────────────────────────
            $table->year('annee_encours')->nullable();
            $table->year('annee_registre_mariage')->nullable();
            $table->string('numero_act_mariage', 50)->nullable();
            $table->string('numero_complet_act_mariage', 100)->nullable();

            // ── Dates & heure ─────────────────────────
            $table->date('date_mariage')->nullable();
            $table->string('date_mariage_lettre', 200)->nullable();
            $table->string('heure_min_mariage', 20)->nullable();
            $table->date('date_dessage')->nullable();
            $table->date('date_dreesage_copie_integrale')->nullable();

            // ── Régime & lieu ─────────────────────────
            $table->string('regime_matrimonial', 100)->nullable();
            $table->string('lieu_mariage', 150)->nullable();

            // ── Officier ──────────────────────────────
            $table->string('officier_etat_civil_mariage', 150)->nullable();
            $table->string('qualite_officier', 100)->nullable();

            // ── Époux ────────────────────────────────
            $table->string('nom_epoux', 100)->nullable();
            $table->string('prenom_epoux', 100)->nullable();
            $table->string('date_naissance_lettre_epoux', 200)->nullable();
            $table->date('date_naissance_epoux')->nullable();
            $table->string('lieu_naissance_epoux', 150)->nullable();
            $table->string('ref_extrai_epoux', 100)->nullable();
            $table->string('ref_piece_epoux', 100)->nullable();
            $table->string('profession_epoux', 100)->nullable();
            $table->string('nom_prenom_pere_epoux', 150)->nullable();
            $table->string('nom_prenom_mere_epoux', 150)->nullable();
            $table->string('domicile_pere', 200)->nullable();
            $table->string('statut_matrimo_epoux', 80)->nullable();

            // ── Épouse ───────────────────────────────
            $table->string('nom_epouse', 100)->nullable();
            $table->string('prenom_epouse', 100)->nullable();
            $table->string('date_naissance_lettre_epouse', 200)->nullable();
            $table->date('date_naissance_epouse')->nullable();
            $table->string('lieu_naissance_epouse', 150)->nullable();
            $table->string('ref_extrai_epouse', 100)->nullable();
            $table->string('ref_piece_epouse', 100)->nullable();
            $table->string('profession_epouse', 100)->nullable();
            $table->string('nom_prenom_pere_epouse', 150)->nullable();
            $table->string('nom_prenom_mere_epouse', 150)->nullable();
            $table->string('domicile_mere', 200)->nullable();
            $table->string('statut_matrimo_epouse', 80)->nullable();

            // ── Témoin de l'époux ─────────────────────
            $table->string('nom_prenom_temoin_epoux', 150)->nullable();
            $table->integer('age_temoin_epoux')->nullable();
            $table->string('ref_piece_temoin_epoux', 100)->nullable();
            $table->string('profession_temoin_epoux', 100)->nullable();
            $table->string('domicile_temoin_epoux', 200)->nullable();
            $table->date('date_naissance_temoin_epoux')->nullable();
            $table->string('lieu_naissance_temoin_epoux', 150)->nullable();
            $table->text('plus_info_temoin_epoux')->nullable();

            // ── Témoin de l'épouse ────────────────────
            $table->string('nom_prenom_temoin_epouse', 150)->nullable();
            $table->integer('age_temoin_epouse')->nullable();
            $table->string('ref_piece_temoin_epouse', 100)->nullable();
            $table->string('profession_temoin_epouse', 100)->nullable();
            $table->string('domicile_temoin_epouse', 200)->nullable();
            $table->date('date_naissance_temoin_epouse')->nullable();
            $table->string('lieu_naissance_temoin_epouse', 150)->nullable();
            $table->text('plus_info_temoin_epouse')->nullable();

            // ── Officiers d'origine ───────────────────
            $table->string('officier_etat_civil_origin_epoux', 150)->nullable();
            $table->string('centre_etat_civil_origin_epoux', 150)->nullable();
            $table->string('officier_etat_civil_origin_epouse', 150)->nullable();
            $table->string('centre_etat_civil_origin_epouse', 150)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mariages');
    }
};
