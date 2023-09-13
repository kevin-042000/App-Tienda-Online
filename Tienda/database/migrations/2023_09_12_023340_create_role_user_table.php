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
        Schema::create('role_user', function (Blueprint $table) {
              // definicion de las columnas:
              $table->unsignedBigInteger('user_id');
              $table->unsignedBigInteger('role_id');
  
              // claves foráneas:
              $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
              $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
  
              // clave primaria compuesta:
              $table->primary(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
