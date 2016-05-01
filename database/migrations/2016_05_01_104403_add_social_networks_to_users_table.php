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
            $table->string('twitter')->default(null);
            $table->string('instagram')->default(null);
            $table->string('facebook')->default(null);
            $table->string('github')->default(null);
            $table->string('youtube')->default(null);
            $table->string('dribble')->default(null);
            $table->string('googleplus')->default(null);
            $table->string('stackoverflow')->default(null);
            $table->string('flickr')->default(null);
            $table->string('bitbucket')->default(null);
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
            $table->dropColumn('dribble');
            $table->dropColumn('googleplus');
            $table->dropColumn('stackoverflow');
            $table->dropColumn('flickr');
            $table->dropColumn('bitbucket');
        });
    }
}
