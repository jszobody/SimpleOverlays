<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->unsignedBigInteger('stack_id');
            $table->unsignedBigInteger('overlay_id');
            $table->smallInteger('visible')->default(1);

            $table->timestamps();
            $table->foreign('stack_id')->references('id')->on('stacks');
            $table->foreign('overlay_id')->references('id')->on('overlays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
