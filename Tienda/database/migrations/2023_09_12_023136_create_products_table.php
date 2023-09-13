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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Referencia al administrador que agregó o modificó el producto
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Clave foránea para users
            $table->string('description');
            $table->decimal('price', 8, 2); // Precio con dos decimales de precisión y un total de 8 dígitos
            $table->unsignedInteger('quantity_in_stock'); // Cantidad disponible
            $table->string('image_path'); // Ruta o enlace a la imagen del producto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
