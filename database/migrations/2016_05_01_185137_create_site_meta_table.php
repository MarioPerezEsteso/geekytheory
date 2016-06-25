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
            $table->string('url');
            $table->string('title');
            $table->string('subtitle');
            $table->string('description');
            $table->string('image');
            $table->string('logo');
            $table->string('favicon');
            $table->string('logo_57');
            $table->string('logo_72');
            $table->string('logo_114');
            $table->string('twitter')->nullable()->default(null);
            $table->string('instagram')->nullable()->default(null);
            $table->string('facebook')->nullable()->default(null);
            $table->string('github')->nullable()->default(null);
            $table->string('youtube')->nullable()->default(null);
            $table->string('dribbble')->nullable()->default(null);
            $table->string('google-plus')->nullable()->default(null);
            $table->string('stack-overflow')->nullable()->default(null);
            $table->string('flickr')->nullable()->default(null);
            $table->string('bitbucket')->nullable()->default(null);
            $table->string('linkedin')->nullable()->default(null);
            $table->boolean('allow_register')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_meta');
    }
}
