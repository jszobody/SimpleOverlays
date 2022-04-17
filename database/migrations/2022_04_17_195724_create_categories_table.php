<?php

use App\Models\Category;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class);

            $table->string('name');
            $table->string('description')->nullable();
            $table->string('icon');

            $table->timestamps();
        });

        Schema::table('stacks', function(Blueprint $table) {
            $table->foreignIdFor(Category::class)->after('team_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
