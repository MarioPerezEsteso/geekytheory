<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialNetworksToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('biography');
            $table->dropColumn('twitter');
            $table->dropColumn('instagram');
            $table->dropColumn('facebook');
            $table->dropColumn('github');
            $table->dropColumn('youtube');
            $table->dropColumn('dribbble');
            $table->dropColumn('google-plus');
            $table->dropColumn('stack-overflow');
            $table->dropColumn('flickr');
            $table->dropColumn('bitbucket');
            $table->dropColumn('linkedin');
        });
    }
}
