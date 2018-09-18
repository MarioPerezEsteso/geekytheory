<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTrackingTimestampsToUserLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_lessons', function (Blueprint $table) {
            $table->dateTime('started_at')->after('lesson_id');
            $table->dateTime('completed_at')->nullable()->after('started_at');
        });

        DB::update('update users_lessons set started_at = created_at, completed_at = created_at');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_lessons', function (Blueprint $table) {
            $table->dropColumn('started_at');
            $table->dropColumn('completed_at');
        });
    }
}
