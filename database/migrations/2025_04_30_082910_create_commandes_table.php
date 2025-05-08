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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('co_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('co_total', 10, 2);
            $table->enum('co_status', ['En attente', 'Payée', 'Annulée', 'Livrée'])->default('En attente');
            $table->enum('moyen_paiement', ['Carte bancaire', 'Espèces', 'PayPal', 'Mobile Money']);
            $table->boolean('est_a_livrer')->default(true);
            $table->boolean('livraison_creer')->default(false);
            $table->string('rue_livraison', 255);
            $table->string('ville_livraison', 100);
            $table->string('code_postal_livraison', 20)->nullable();
            $table->string('pays_livraison', 100);
            $table->dateTime('co_date')->useCurrent();
            $table->text('commentaires')->nullable();
            $table->timestamps();

            // Clé étrangère
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('commandes');
    }
};
