<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deces', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commune_id')
                  ->constrained('communes')
                  ->restrictOnDelete();

            // ── Registre ─────────────────────────────
            $table->year('annee_registre_deces')->nullable();
            $table->string('numero_registre_deces', 50)->nullable();
            $table->string('numero_act_deces', 50)->nullable();
            $table->string('nature_declarat_deces', 100)->nullable();
            $table->text('ment_jugem_supplet')->nullable(); // mention jugement supplétif

            // ── Dates & heure dressage ────────────────
            $table->date('date_dessage_deces')->nullable();
            $table->date('date_dessage_copi_integral_deces')->nullable();
            $table->string('heure_dressage_deces', 20)->nullable();

            // ── Officier ──────────────────────────────
            $table->string('nous_avons_signe_deces', 150)->nullable();
            $table->string('officier_etat_civil_deces', 150)->nullable();
            $table->string('qualite_etat_civil_deces', 100)->nullable();

            // ── Décès ─────────────────────────────────
            $table->date('date_deces')->nullable();
            $table->string('lieu_deces', 150)->nullable();
            $table->string('heure_min_deces', 20)->nullable();

            // ── Défunt ───────────────────────────────
            $table->enum('sexe_deces', ['M', 'F'])->nullable();
            $table->string('fils_fille_deces', 30)->nullable();
            $table->string('nom_defunt', 100)->nullable();
            $table->string('prenom_defunt', 100)->nullable();
            $table->date('date_naissance_defunt')->nullable();
            $table->string('lieu_naissance_defunt', 150)->nullable();
            $table->string('profession_defunt', 100)->nullable();
            $table->string('situa_familial_defunt', 80)->nullable();
            $table->string('nom_prenom_epoux_defunt', 150)->nullable();

            // ── Parents du défunt ─────────────────────
            $table->string('nom_prenom_pere_defunt', 150)->nullable();
            $table->string('domicile_pere_defunt', 200)->nullable();
            $table->string('nom_prenom_mere_defunt', 150)->nullable();
            $table->string('domicile_mere_defunt', 200)->nullable();

            // ── Déclarant & interprète ────────────────
            $table->text('info_declarant')->nullable();
            $table->string('langue_declarant', 80)->nullable();
            $table->string('nom_prenom_interprete', 150)->nullable();

            // ── Officier d'origine ────────────────────
            $table->string('officier_etat_civil_origin_defunt', 150)->nullable();
            $table->string('centre_etat_civil_origin_defunt', 150)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deces');
    }
};
