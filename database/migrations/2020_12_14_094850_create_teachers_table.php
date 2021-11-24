<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('country_id')->constrained();

            $table->string('name');
            $table->string('surname');

            $table->text('bio')->nullable();
            $table->string('year_starting_practice')->nullable();
            $table->string('year_starting_teach')->nullable();
            $table->text('significant_teachers')->nullable();

            //$table->string('profile_picture')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();

            $table->string('slug');

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
        Schema::dropIfExists('teachers');
    }
}
