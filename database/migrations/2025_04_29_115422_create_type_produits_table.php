<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_produits', function (Blueprint $table) {
            $table->id('tp_id');  // id_type AUTO_INCREMENT PRIMARY KEY
            $table->string('tp_name', 255); // nom_type
            $table->text('tp_description')->nullable(); // t_description
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Inverser la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_produits');
    }
};
