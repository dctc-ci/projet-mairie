<?php

use App\Models\ModuleSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('module_settings')->insert([
            ['key' => ModuleSetting::PERSONNELS, 'enabled' => true, 'created_at' => $now, 'updated_at' => $now],
            ['key' => ModuleSetting::ETAT_CIVIL, 'enabled' => true, 'created_at' => $now, 'updated_at' => $now],
            ['key' => ModuleSetting::PRESTATIONS, 'enabled' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('module_settings');
    }
};
