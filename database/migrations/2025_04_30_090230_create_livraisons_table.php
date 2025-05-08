<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id('livraison_id');
            $table->unsignedBigInteger('co_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('livreur_id')->nullable();
            $table->string('rue', 255);
            $table->string('ville', 100);
            $table->string('code_postal', 20);
            $table->string('pays', 100);
            $table->enum('livraison_status', ['En attente', 'En cours', 'Livrée', 'Annulée'])->default('En attente');
            $table->dateTime('date_livraison_estimee')->nullable();
            $table->dateTime('date_livraison_effective')->nullable();
            $table->string('moyen_transport', 50)->nullable();
            $table->text('commentaires')->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('co_id')
                ->references('co_id')
                ->on('commandes')
                ->onDelete('cascade');

            $table->foreign('livreur_id')
                ->references('livreur_id')
                ->on('livreurs')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('livraisons');
    }
};
