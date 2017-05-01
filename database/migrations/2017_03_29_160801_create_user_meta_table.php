<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meta', function (Blueprint $table) {
			$table->integer('user_id')->unsigned()->unique();
			$table->string('biography')->nullable();
			$table->string('job')->nullable();
			$table->string('twitter')->nullable();
			$table->string('instagram')->nullable();
			$table->string('facebook')->nullable();
			$table->string('github')->nullable();
			$table->string('youtube')->nullable();
			$table->string('googleplus')->nullable();
			$table->string('stackoverflow')->nullable();
			$table->string('bitbucket')->nullable();
			$table->string('linkedin')->nullable();
			$table->string('tumblr')->nullable();
			$table->string('twitch')->nullable();
			$table->string('vimeo')->nullable();

			$table->foreign('user_id')
				->references('id')
				->on('users')
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
		Schema::dropIfExists('user_meta');
    }
}
