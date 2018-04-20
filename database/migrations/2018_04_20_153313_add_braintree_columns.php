<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBraintreeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('braintree_id')->nullable()->after('stripe_id');
            $table->string('paypal_email')->nullable()->after('braintree_id');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('braintree_id')->after('stripe_plan');
            $table->string('braintree_plan')->after('braintree_id');
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
            $table->dropColumn('braintree_id');
            $table->dropColumn('paypal_email');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('braintree_id');
            $table->dropColumn('braintree_plan');
        });
    }
}
