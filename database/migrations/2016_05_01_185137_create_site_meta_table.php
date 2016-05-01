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
            $table->string('twitter');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('github');
            $table->string('youtube');
            $table->string('dribbble');
            $table->string('google-plus');
            $table->string('stack-overflow');
            $table->string('flickr');
            $table->string('bitbucket');
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
