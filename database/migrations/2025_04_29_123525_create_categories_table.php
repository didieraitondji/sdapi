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
        Schema::create('categories', function (Blueprint $table) {
            $table->id('c_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tp_id');
            $table->string('c_name', 255);
            $table->text('c_description')->nullable();
            $table->string('c_image', 2083)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->enum('c_status', ['Active', 'Inactive'])->default('Active');

            // Clés étrangères
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('tp_id')
                ->references('tp_id')
                ->on('type_produits')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
