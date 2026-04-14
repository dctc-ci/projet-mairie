<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sollicitations', function (Blueprint $table) {
            $table->id();

            // Clés étrangères polymorphiques (une seule non nulle à la fois)
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('agent_non_permanent_id')->nullable()->constrained('agents_non_permanents')->nullOnDelete();
            $table->foreignId('stagiaire_id')->nullable()->constrained('stagiaires')->nullOnDelete();
            $table->foreignId('type_sollicitation_id')->nullable()->constrained('types_sollicitation')->nullOnDelete();

            // Informations générales
            $table->string('motif_sollicitation', 255)->nullable();
            $table->string('destination', 150)->nullable();
            $table->date('date_sollicitation')->nullable();
            $table->date('date_cessation')->nullable();
            $table->date('date_depart')->nullable();
            $table->date('date_retour')->nullable();
            $table->date('date_reprise')->nullable();

            // Signataire
            $table->string('signataire', 150)->nullable();
            $table->string('fonction_signataire', 100)->nullable();

            // Justificatif (pièce jointe)
            $table->string('justificatif')->nullable();

            // Congé
            $table->string('tranche_conge', 50)->nullable();
            $table->text('observation_conge')->nullable();

            // Statut
            $table->enum('etat_sollicitation', ['en_attente', 'approuvee', 'rejetee', 'annulee'])
                  ->default('en_attente');

            // Accident de travail
            $table->date('date_accident')->nullable();
            $table->string('lieu_accident', 150)->nullable();
            $table->string('gravite_accident', 50)->nullable();
            $table->boolean('declare_cnps')->default(false);
            $table->date('date_declare_cnps')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sollicitations');
    }
};
