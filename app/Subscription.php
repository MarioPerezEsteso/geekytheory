<?php

namespace App;

class Subscription extends \Laravel\Cashier\Subscription
{
    const PLAN_MONTHLY = 'monthly';
    const PLAN_MONTHLY_PRICE_EUR = 15;
}
