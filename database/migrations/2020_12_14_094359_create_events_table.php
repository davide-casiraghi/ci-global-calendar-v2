<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('id');

            $table->foreignId('event_category_id')->constrained();
            $table->foreignId('venue_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('claimer_id')->nullable()->constrained('users');

            $table->boolean('is_published')->default(0);

            $table->string('title');
            $table->text('description');
            $table->string('contact_email')->nullable();
            $table->string('website_event_link')->nullable();
            $table->string('facebook_event_link')->nullable();

            $table->integer('repeat_type');
            $table->dateTime('repeat_until')->nullable();
            $table->string('repeat_weekly_on')->nullable();
            $table->string('on_monthly_kind')->nullable();
            $table->text('multiple_dates')->nullable();

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
        Schema::dropIfExists('events');
    }
}
