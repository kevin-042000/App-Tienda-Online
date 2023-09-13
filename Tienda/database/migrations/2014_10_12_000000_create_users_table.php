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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_confirmation');
            $table->unsignedBigInteger('role_id');//id del rol
            $table->foreign('role_id')->references('id')->on('roles');//referencia a la tabla de rol e id
            $table->string('city')->nullable();
            $table->string('gender')->nullable(); 
            $table->date('birth_date')->nullable(); // fecha de nacimiento
            $table->string('phone', 20)->nullable();
            $table->string('avatar')->nullable();// foto de perfil
            $table->softDeletes();// marcará a un usuario como eliminado sin eliminarlo realmente
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
