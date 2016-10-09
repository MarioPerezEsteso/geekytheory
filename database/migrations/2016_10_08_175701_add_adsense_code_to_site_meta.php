<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdsenseCodeToSiteMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->text('adsense_script')->default('');
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
            $table->dropColumn('adsense_script');
        });
    }
}
