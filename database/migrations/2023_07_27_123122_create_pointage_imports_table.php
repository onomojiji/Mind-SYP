<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pointage_imports', function (Blueprint $table) {
            $table->id();
            $table->string("prenom")->nullable();
            $table->string("nom")->nullable();
            $table->string("sexe")->nullable();
            $table->string("structure")->nullable();
            $table->string("poste")->nullable();
            $table->string("date")->nullable();
            $table->string("entree")->nullable();
            $table->string("sortie")->nullable();
            $table->string("total")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pointage_imports');
    }
};
