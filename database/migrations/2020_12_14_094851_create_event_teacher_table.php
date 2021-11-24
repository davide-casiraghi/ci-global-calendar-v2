<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_teacher', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')->constrained()->onDelete('cascade'); //When delete event delete all the relations in this table relations
            $table->foreignId('teacher_id')->constrained();

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
        Schema::dropIfExists('event_teacher');
    }
}
