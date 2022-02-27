<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // created by
            $table->foreignId('country_id')->nullable()->constrained();
            $table->foreignId('gift_country_of')->nullable()->constrained('countries');

            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->text('contact_trough_voip')->nullable();
            $table->text('language_spoken')->nullable();
            $table->string('offer_kind');
            $table->string('gift_kind')->nullable();
            $table->text('gift_description')->nullable();
            $table->string('volunteer_kind')->nullable();
            $table->text('volunteer_description')->nullable();
            $table->text('other_description')->nullable();
            $table->text('suggestions')->nullable();
            //$table->integer('status')->default(1);  // use status module
            $table->string('gift_title')->nullable();
            $table->string('gift_donater')->nullable();
            $table->string('gift_economic_value')->nullable();
            $table->string('gift_volunteer_time_value')->nullable();
            $table->string('gift_given_to')->nullable();
            $table->dateTime('gift_given_when')->nullable();

            $table->text('admin_notes')->nullable();
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
        Schema::dropIfExists('donation_offers');
    }
}
