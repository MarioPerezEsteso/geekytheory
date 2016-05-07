<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle');
            $table->string('description');
            $table->string('image');
            $table->string('twitter')->default(null);
            $table->string('instagram')->default(null);
            $table->string('facebook')->default(null);
            $table->string('github')->default(null);
            $table->string('youtube')->default(null);
            $table->string('dribbble')->default(null);
            $table->string('google-plus')->default(null);
            $table->string('stack-overflow')->default(null);
            $table->string('flickr')->default(null);
            $table->string('bitbucket')->default(null);
            $table->string('linkedin')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('site_meta');
    }
}
