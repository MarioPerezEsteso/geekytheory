<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialSharesToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('shares_whatsapp')->default(0);
            $table->integer('shares_twitter')->default(0);
            $table->integer('shares_facebook')->default(0);
            $table->integer('shares_google-plus')->default(0);
            $table->integer('shares_telegram')->default(0);
            $table->integer('shares_mail')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
			$table->dropColumn('shares_whatsapp');
			$table->dropColumn('shares_twitter');
			$table->dropColumn('shares_facebook');
			$table->dropColumn('shares_google-plus');
			$table->dropColumn('shares_telegram');
			$table->dropColumn('shares_mail');
        });
    }
}
