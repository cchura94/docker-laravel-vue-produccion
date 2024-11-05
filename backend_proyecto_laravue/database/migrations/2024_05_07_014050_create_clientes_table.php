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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string("razon_social");
            $table->string("ci_nit")->nullable();
            $table->string("correo")->nullable();

            $table->unsignedBigInteger("persona_id")->nullable();
            $table->foreign("persona_id")->references("id")->on("personas");// ->onDelete("CASCADE");

            $table->softDeletes(); // deleted_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
