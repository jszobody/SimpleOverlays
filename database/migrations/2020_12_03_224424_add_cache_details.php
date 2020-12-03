<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCacheDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overlays', function (Blueprint $table) {
            $table->string('cache_url')->after('cache_name')->nullable();
            $table->timestamp('cache_expires_at')->after('cache_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overlays', function (Blueprint $table) {
            //
        });
    }
}
