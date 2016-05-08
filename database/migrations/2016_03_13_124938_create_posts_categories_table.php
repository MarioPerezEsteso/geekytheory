<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('category_id');
            $table->timestamps();

            $table->unique(array('post_id', 'category_id'));

            // Foreign key to posts
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade');

            // Foreign key to categories
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::drop('posts_categories');
    }
}
