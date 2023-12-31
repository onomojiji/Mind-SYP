<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Personnel::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Structure::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Poste::class)->constrained()->cascadeOnDelete();
            $table->string('mois');
            $table->string('annee');
            $table->date('date');
            $table->time('entree')->nullable();
            $table->time('sortie')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointages');
    }
};
