<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAllowRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->dropColumn('allow_register');
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
            $table->boolean('allow_register')->nullable()->default(false);
        });
    }
}
