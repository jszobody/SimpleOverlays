<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverlaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overlays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stack_id');

            $table->text('content')->nullable();
            $table->string('layout');
            $table->string('size');

            $table->json('css')->nullable();
            $table->integer('sort')->default(0);

            $table->timestamps();

            $table->foreign('stack_id')->references('id')->on('stacks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overlays');
    }
}
