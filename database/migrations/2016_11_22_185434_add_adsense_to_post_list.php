<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdsenseToPostList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->text('adsense_postlist')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->dropColumn('adsense_postlist');
        });
    }
}
