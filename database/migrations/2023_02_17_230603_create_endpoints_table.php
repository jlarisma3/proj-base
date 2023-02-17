<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endpoints', function (Blueprint $table) {
            $table->id();
            $table->string('uri')->nullable();
            $table->string('middleware')->nullable();
            $table->string('route_name')->nullable()->index();
            $table->string('method')->nullable();
        });

        Schema::table('endpoints', function (Blueprint $table) {
            $table->index('route_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('endpoints', function (Blueprint $table) {
            $table->dropIndex('route_name');
        });

        Schema::dropIfExists('endpoints');
    }
};
