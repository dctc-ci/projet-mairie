<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commune_id')
                  ->constrained('communes')
                  ->restrictOnDelete();

            // Une mention est liée à un extrait de naissance
            $table->foreignId('extrait_id')
                  ->nullable()
                  ->constrained('extraits')
                  ->nullOnDelete();

            // ── Mariage ───────────────────────────────
            $table->date('date_mariage_mention')->nullable();
            $table->string('lieu_mariage_mention', 150)->nullable();
            $table->string('nom_prenom_conjoint_mention', 150)->nullable();

            // ── Dissolution ───────────────────────────
            $table->date('date_mariage_dissous')->nullable();
            $table->string('ref_act_dissous', 100)->nullable();

            // ── Décès ─────────────────────────────────
            $table->date('date_deces_mention')->nullable();
            $table->string('lieu_deces_mention', 150)->nullable();

            // ── Autres mentions ───────────────────────
            $table->text('mention_reconnaissance')->nullable();
            $table->text('mention_rectification')->nullable();
            $table->text('mention_adoption')->nullable();
            $table->text('mention_retablissement')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentions');
    }
};
