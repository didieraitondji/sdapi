<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commande_produits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('co_id');
            $table->unsignedBigInteger('p_id');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('remise', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('co_id')->references('co_id')->on('commandes')->onDelete('cascade');
            $table->foreign('p_id')->references('p_id')->on('produits')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('commande_produits');
    }
};
