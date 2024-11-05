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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("cod_producto");
            $table->string("nombre", 200);
            $table->integer("stock")->default(0);
            $table->decimal("precio", 10, 2)->default(0);
            $table->string("imagen")->nullable();
            $table->boolean("estado")->default(true);
            $table->text("descripcion")->nullable();
            $table->bigInteger("categoria_id")->unsigned();
            // N:1
            $table->foreign("categoria_id")->references("id")->on("categorias");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
