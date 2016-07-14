<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteCascadeToPostsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts_categories', function (Blueprint $table) {
            // Drop existent foreign keys before creating the new ones
            $table->dropForeign(['post_id']);
            $table->dropForeign(['category_id']);

            // Foreign key to posts
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Foreign key to categories
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts_categories', function (Blueprint $table) {
            // Drop existent foreign keys before creating the new ones
            $table->dropForeign(['post_id']);
            $table->dropForeign(['category_id']);

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
}
