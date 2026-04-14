<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();

            
            $table->foreignId('commune_id')
                  ->constrained('communes')
                  ->restrictOnDelete();

            $table->foreignId('bareme_salarial_id')
                  ->constrained('bareme_salarials')   
                  ->restrictOnDelete();

            // Identité
            $table->string('nom_prenom_agent', 150);
            $table->date('date_naissance_agent');
            $table->enum('sexe_agent', ['M', 'F']);
            $table->string('matricule', 50)->unique();
            $table->string('qualification', 100)->nullable();
            $table->string('contact_agent', 20)->nullable();
            $table->string('contact_urgence_1', 20)->nullable();
            $table->string('contact_urgence_2', 20)->nullable();

            // Embauche
            $table->string('nature_embauche', 100)->nullable();
            $table->string('numero_embauche', 50)->nullable();
            $table->date('date_embauche')->nullable();
            $table->date('date_fonction_embauche')->nullable();
            $table->date('date_prise_service')->nullable();

            // Classification
            $table->string('groupe', 50)->nullable();
            $table->decimal('indem_transp', 10, 2)->default(0);
            $table->decimal('indem_fonction', 10, 2)->default(0);
            $table->decimal('indem_techn', 10, 2)->default(0);

            // Poste
            $table->string('fonction', 100)->nullable();
            $table->string('service', 100)->nullable();
            $table->string('post_travail', 100)->nullable();
            $table->string('statut', 50)->nullable();

            // Budgétaire
            $table->string('imputa_budgetaire', 100)->nullable();
            $table->string('chapitre_paie', 50)->nullable();
            $table->string('article_paie', 50)->nullable();

            // Photo
            $table->string('photo_agent')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
