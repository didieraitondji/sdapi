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
            $table->id('user_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('sexe', 5);
            $table->string('email', 150)->nullable()->unique();
            $table->string('telephone', 20);
            $table->string('user_password');
            $table->string('rue')->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('code_postal', 20)->nullable();
            $table->string('pays', 100)->nullable();
            $table->dateTime('last_connexion')->nullable();
            $table->enum('notification_option', ['sms', 'email', 'none'])->default('sms');
            $table->string('picture')->nullable();
            $table->enum('user_type', ['admin', 'user', 'Particulier', 'Bars, Resto, Buvette'])->default('user');
            $table->boolean('is_activated')->default(true);
            $table->boolean('is_connected')->default(false);
            $table->timestamps();
            $table->softDeletes();
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
