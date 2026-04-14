<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents_non_permanents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commune_id')->constrained('communes')->restrictOnDelete();

            $table->string('nom_prenom_nopermanent', 150);
            $table->enum('sexe_nopermanent', ['M', 'F']);
            $table->string('fonction_nopermanent', 100)->nullable();
            $table->string('service_nopermanent', 100)->nullable();
            $table->string('statut_nopermanent', 50)->nullable();
            $table->date('date_recrutement_nopermanent')->nullable();
            $table->decimal('indemnite', 10, 2)->default(0);
            $table->string('situa_marial_nopermanent', 50)->nullable();
            $table->string('act_recrutement_nopermanent', 150)->nullable();
            $table->string('numero_act_recrutement_nopermanent', 50)->nullable();
            $table->string('contact_agent_nopermanent', 20)->nullable();
            $table->string('contact_urgence_1_nopermanent', 20)->nullable();
            $table->string('contact_urgence_2_nopermanent', 20)->nullable();
            $table->string('photo_agent_nopermanent')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents_non_permanents');
    }
};
