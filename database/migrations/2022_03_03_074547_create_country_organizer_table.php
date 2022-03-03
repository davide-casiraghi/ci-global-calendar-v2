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
        Schema::create('country_organizer', function (Blueprint $table) {
            $table->foreignId('country_id')->constrained();
            $table->foreignId('organizer_id')->constrained()->onDelete('cascade'); //When delete organizer delete all the relations in this table relations
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_organizer');
    }
};
