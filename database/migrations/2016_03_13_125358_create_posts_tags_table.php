<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->unique(array('post_id', 'tag_id'));

            // Foreign key to post
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade');

            // Foreign key to tags
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts_tags');
    }
}
