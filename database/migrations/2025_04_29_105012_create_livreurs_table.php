<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livreurs', function (Blueprint $table) {
            $table->id('livreur_id');
            $table->unsignedBigInteger('user_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('sexe', 5);
            $table->string('email', 255)->nullable();
            $table->string('telephone', 20);
            $table->string('livreur_password');
            $table->string('rue')->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('code_postal', 20)->nullable();
            $table->string('pays', 100)->nullable();
            $table->enum('livreur_status', ['Disponible', 'Occupé'])->default('Disponible');
            $table->dateTime('last_connexion')->nullable();
            $table->enum('notification_option', ['sms', 'email', 'none'])->default('sms');
            $table->boolean('is_activated')->default(true);
            $table->boolean('is_connected')->default(false);
            $table->string('vehicule_type', 50)->nullable();
            $table->string('vehicule_immatriculation', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Clé étrangère vers la table users
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livreurs');
    }
};
