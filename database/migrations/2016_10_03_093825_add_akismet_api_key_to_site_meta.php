<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAkismetApiKeyToSiteMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->string('akismet_api_key')->default('');
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
            $table->dropColumn('akismet_api_key');
        });
    }
}
