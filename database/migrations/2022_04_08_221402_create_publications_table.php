<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->string('media')->nullable();
            $table->text('message')->nullable();
            $table->string('type_de_fichier')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('facebook_post_id')->nullable();
            $table->enum('status', ['published', 'waiting'])->nullable()->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
