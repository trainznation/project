<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamp('time_start')->default(now());
            $table->string('short_description');
            $table->text('description');
            $table->integer('published')->default(0)->comment('0: Trash|1: Private |2: Public');
            $table->integer('state')->default(0)->comment('0: En cours |1: Terminer |2: Annuler |3: En attente');
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
        Schema::dropIfExists('projects');
    }
}
