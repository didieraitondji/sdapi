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
        Schema::create('produits', function (Blueprint $table) {
            $table->id('p_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('p_name', 255);
            $table->text('p_description')->nullable();
            $table->unsignedBigInteger('c_id');
            $table->string('p_type', 255);
            $table->decimal('prix', 10, 2);
            $table->integer('quantite_stock');
            $table->enum('p_status', ['Disponible', 'Indisponible', 'En rupture'])->default('Disponible');
            $table->boolean('est_en_promotion')->default(false);
            $table->decimal('prix_promotionnel', 10, 2)->nullable();
            $table->dateTime('date_debut_promotion')->nullable();
            $table->dateTime('date_fin_promotion')->nullable();
            $table->string('p_image', 255)->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('c_id')
                ->references('c_id')
                ->on('categories')
                ->onDelete('cascade');

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
        Schema::dropIfExists('produits');
    }
};
