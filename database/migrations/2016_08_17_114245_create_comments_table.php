<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('parent')->unsigned()->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->string('author_url')->nullable();
            $table->text('body');
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->boolean('approved');
            $table->boolean('spam');
            $table->string('ip');
            $table->timestamps();

            // FK to table users to know the author of the comment if the user is logged in
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');

            // FK to table posts to know the article where the comment has been posted
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade');

            // FK to table comments to know the parent
            $table->foreign('parent')
                ->references('id')
                ->on('comments')
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
        Schema::drop('comments');
    }
}
