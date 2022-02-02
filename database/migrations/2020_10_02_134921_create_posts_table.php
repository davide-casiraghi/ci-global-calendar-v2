<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('post_categories');
            $table->foreignId('user_id')->constrained();

            $table->string('title');
            $table->text('intro_text');
            $table->text('body');
            $table->text('before_content')->nullable();
            $table->text('after_content')->nullable();
            $table->string('introimage')->nullable();
            $table->string('introimage_alt')->nullable();

            $table->datetime('publish_at')->nullable();
            $table->datetime('publish_until')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
