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
        Schema::create('pedido_producto', function (Blueprint $table) {
            $table->id();
            $table->integer("cantidad")->default(1)->unsigned();
            // N:M
            $table->unsignedBigInteger("pedido_id");
            $table->unsignedBigInteger("producto_id");

            $table->foreign("pedido_id")->references("id")->on("pedidos");
            $table->foreign("producto_id")->references("id")->on("productos");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_producto');
    }
};
