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
        Schema::table('users', function ($table) {
            $table->string('braintree_id')->after('stripe_id')->nullable();
            $table->string('paypal_email')->after('braintree_id')->nullable();
        });

        Schema::table('subscriptions', function ($table) {
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
        Schema::table('users', function ($table) {
            $table->dropColumn('braintree_id');
            $table->dropColumn('paypal_email');
        });

        Schema::table('subscriptions', function ($table) {
            $table->dropColumn('braintree_id');
            $table->dropColumn('braintree_plan');
        });
    }
}
