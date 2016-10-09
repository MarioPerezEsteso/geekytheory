<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdsenseOptionToEnableOrDisable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->boolean('adsense_enabled')->default(true);
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
            $table->dropColumn('adsense_enabled');
        });
    }
}
